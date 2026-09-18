<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Agent;
use App\Models\User; // Make sure User model is imported!
use App\Models\VirtualAccount;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class WhatsAppBotController extends Controller
{
    /**
     * 1. META WEBHOOK VERIFICATION
     */
    public function verifyWebhook(Request $request)
    {
        $verifyToken = env('WHATSAPP_VERIFY_TOKEN'); 
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        if ($mode && $token) {
            if ($mode === 'subscribe' && $token === $verifyToken) {
                return response($challenge, 200);
            }
        }
        return response()->json('Forbidden', 403);
    }

    /**
     * 2. HANDLE INCOMING MESSAGES
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        
        if (!isset($payload['object']) || $payload['object'] !== 'whatsapp_business_account') {
            return response()->json(['status' => 'ignored']);
        }

        $entry = $payload['entry'][0] ?? null;
        $changes = $entry['changes'][0] ?? null;
        $value = $changes['value'] ?? null;

        if (isset($value['messages']) && isset($value['messages'][0])) {
            $messageObj = $value['messages'][0];
            $senderPhone = $messageObj['from']; 

            // --- A. HANDLE TEXT MESSAGES ---
            if ($messageObj['type'] === 'text') {
                $incomingText = trim($messageObj['text']['body']);
                $lowerText = strtolower($incomingText);
                
                // ==========================================
                // 1. 🚨 THE ESCAPE HATCH (MUST BE FIRST!) 🚨
                // ==========================================
                if (in_array($lowerText, ['cancel', 'exit', 'home', 'menu', 'restart', 'quit'])) {
                    // Wipe the memory clean instantly
                    Cache::forget("wa_state_{$senderPhone}");
                    Cache::forget("wa_cart_{$senderPhone}");
                    Cache::forget("wa_active_shop_{$senderPhone}");
                    
                    // Are they a vendor? Send them straight to the vendor menu
                    $vendorUser = \App\Models\User::where('phone', 'like', "%" . substr($senderPhone, -10))->first();
                    if ($vendorUser) {
                        $this->handleExistingUserFlow($vendorUser, $senderPhone, 'menu');
                        return response()->json(['status' => 'success']);
                    }

                    // Otherwise, send the buyer home
                    $reply = "🔄 Session cleared. You are back at the main menu!\n\n🛒 *To Shop:*\nReply with 'Shop [Store Name]'.\n\n💼 *To Sell:*\nVisit q4iltd.com/vendor/register";
                    $this->sendWhatsAppMessage($senderPhone, $reply);
                    return response()->json(['status' => 'success']);
                }

                // ==========================================
                // 2. CHECK BOT STATE (Waiting for Address)
                // ==========================================
                $botState = Cache::get("wa_state_{$senderPhone}");
                if ($botState === 'waiting_for_address') {
                    $this->finalizeOrderWithAddress($senderPhone, $incomingText);
                    return response()->json(['status' => 'success']);
                }

                // ==========================================
                // 3. MULTI-TENANT: Shop Routing
                // ==========================================
                if (str_starts_with($lowerText, 'shop ')) {
                    $storeName = trim(substr($incomingText, 5));
                    $vendor = \App\Models\User::where('store_name', 'LIKE', "%{$storeName}%")->first();

                    if ($vendor) {
                        Cache::put("wa_active_shop_{$senderPhone}", $vendor->id, now()->addHours(2));
                        
                        $reply = "Welcome to *{$vendor->store_name}*! 🛍️✨\n\nTo view our products, simply reply with the word *Catalog*.";
                        $this->sendWhatsAppMessage($senderPhone, $reply);
                        return response()->json(['status' => 'success']);
                    } else {
                        $reply = "Oops! 🧐 I couldn't find a store named '*{$storeName}*'.\n\nPlease check the spelling and try again (e.g., 'Shop [Store Name]').";
                        $this->sendWhatsAppMessage($senderPhone, $reply);
                        return response()->json(['status' => 'success']);
                    }
                }

                // ==========================================
                // 4. CATALOG TRIGGER
                // ==========================================
                $activeShopId = Cache::get("wa_active_shop_{$senderPhone}");
                if ($activeShopId && in_array($lowerText, ['catalog', 'products'])) {
                    $this->sendWhatsAppMessage($senderPhone, "Fetching the interactive catalog for this store... (Coming Next!)"); 
                    return response()->json(['status' => 'success']);
                }

                // ==========================================
                // 5. VENDOR RECOGNITION
                // ==========================================
                $vendorUser = \App\Models\User::where('phone', 'like', "%" . substr($senderPhone, -10))->first();
                if ($vendorUser) {
                    $this->handleExistingUserFlow($vendorUser, $senderPhone, $lowerText);
                    return response()->json(['status' => 'success']);
                }

                // ==========================================
                // 6. DEFAULT FALLBACK
                // ==========================================
                $reply = "Welcome to *Q4I Social Commerce*! 🚀\n\n🛒 *To Shop:*\nReply with 'Shop [Store Name]' (e.g., 'Shop Bussy Sneaks').\n\n💼 *To Sell:*\nVisit q4iltd.com/vendor/register to open your free WhatsApp storefront!";
                $this->sendWhatsAppMessage($senderPhone, $reply);
                return response()->json(['status' => 'success']);
            }
            
            // --- B. HANDLE INTERACTIVE CLICKS (Buttons & Lists) ---
            elseif ($messageObj['type'] === 'interactive') {
                $interactiveData = $messageObj['interactive'];
                $this->handleInteractiveShopping($senderPhone, $interactiveData);
            }
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * 3. NEW USER FLOW (BVN -> PIN -> Registration)
     */
    private function handleNewUserFlow($phone, $text)
    {
        $botState = Cache::get("wa_state_{$phone}");

        if (!$botState) {
            if (in_array($text, ['hi', 'hello', 'start', 'menu'])) {
                Cache::put("wa_state_{$phone}", 'waiting_for_bvn', now()->addMinutes(10));
                
                $reply = "Welcome to Q4I Payments! 🚀\n\nTo generate your dedicated Virtual Account, please reply with your 11-digit BVN.\n\n_Example: 22123456789_";
                $this->sendWhatsAppMessage($phone, $reply);
                return;
            }
        }

        if ($botState === 'waiting_for_bvn') {
            if (is_numeric($text) && strlen($text) == 11) {
                Cache::put("wa_bvn_{$phone}", $text, now()->addMinutes(10));
                Cache::put("wa_state_{$phone}", 'waiting_for_pin', now()->addMinutes(10));

                $reply = "Great! 🔒 Now, please reply with a 4-digit PIN.\n\nYou will use this PIN to log into your web dashboard at q4iltd.com and confirm withdrawals.";
                $this->sendWhatsAppMessage($phone, $reply);
                return;
            } else {
                $reply = "That doesn't look like an 11-digit BVN. Please check and send it again.";
                $this->sendWhatsAppMessage($phone, $reply);
                return;
            }
        }

        if ($botState === 'waiting_for_pin') {
            if (is_numeric($text) && strlen($text) == 4) {
                $this->sendWhatsAppMessage($phone, "⏳ Setting up your profile and generating your Virtual Account. Please wait...");
                
                $bvn = Cache::get("wa_bvn_{$phone}");
                $pin = $text;
                $autoEmail = $phone . '@vendor.q4i.com';

                $user = User::create([
                    'name' => 'WhatsApp Vendor',
                    'email' => $autoEmail,
                    'phone' => $phone,
                    'password' => Hash::make($pin),
                    'store_name' => 'WhatsApp Store'
                ]);

                $techvibesPayload = [
                    'bvn' => $bvn,
                    'phoneNo' => $phone,
                    'lastName' => 'Vendor',       
                    'otherNames' => 'WhatsApp',   
                    'dateOfBirth' => '1990-01-01', 
                    'gender' => 0                 
                ];

                $response = Http::withoutVerifying()
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . env('TECHVIBES_API_TOKEN'),
                        'Content-Type' => 'application/json'
                    ])->post('https://techvibs.com/bank/api_general/bvn_verification_token_api.php', $techvibesPayload);

                $responseData = $response->json();

                if ($response->successful() && isset($responseData['status']) && $responseData['status'] === 'success') {
                    
                    $accountNumber = $responseData['api_response']['accountNumber'];
                    
                    VirtualAccount::create([
                        'user_id' => $user->id, 
                        'account_number' => $accountNumber,
                        'bank_name' => '9PSB',
                        'customer_id' => $responseData['api_response']['customerID'],
                        'order_ref' => $responseData['api_response']['orderRef'] ?? 'WA_' . time(),
                    ]);

                    Cache::forget("wa_state_{$phone}");
                    Cache::forget("wa_bvn_{$phone}");

                    $reply = "✅ Setup Complete!\n\n🏦 *Your Wallet Account*\nBank: 9PSB\nAcct Name: Q4I Payments\nAcct No: *{$accountNumber}*\n\n💻 *Web Dashboard*\nLogin at: q4iltd.com/login\nPhone: {$phone}\nPIN: {$pin}\n\nReply 'menu' anytime to see your options.";
                    $this->sendWhatsAppMessage($phone, $reply);
                    return;
                } else {
                    Log::error('Techvibes Bot Account Creation Failed', ['response' => $responseData]);
                    $user->delete();
                    Cache::forget("wa_state_{$phone}");
                    Cache::forget("wa_bvn_{$phone}");

                    $reply = "❌ Bank Verification Failed.\n\nWe couldn't generate your account with that BVN. Please type 'hi' to restart the process and ensure your BVN is correct.";
                    $this->sendWhatsAppMessage($phone, $reply);
                    return;
                }
            } else {
                $reply = "Please send exactly 4 numbers for your PIN (e.g. 1234).";
                $this->sendWhatsAppMessage($phone, $reply);
                return;
            }
        }

        $reply = "I didn't quite get that. Send 'hi' to start your registration.";
        $this->sendWhatsAppMessage($phone, $reply);
    }

    /**
     * 4. EXISTING USER FLOW (Menu)
     */
    private function handleExistingUserFlow($user, $phone, $text)
    {
        if (in_array($text, ['hi', 'hello', 'menu'])) {
            $reply = "Welcome back, " . ($user->first_name ?? 'User') . "! 👋\n\nReply with a number:\n1. View My Account Details\n2. Check Balance\n3. Talk to Support";
            $this->sendWhatsAppMessage($phone, $reply);
            return;
        }

        if ($text == '1') {
            $va = VirtualAccount::where('user_id', $user->id)->first(); // Updated from agent_id
            if ($va) {
                $reply = "🏦 *Your Account Details*\nBank: " . $va->bank_name . "\nAcct No: " . $va->account_number . "\n\nAny funds sent here will update your wallet instantly.";
            } else {
                $reply = "You don't have an active account yet. Please contact support.";
            }
            $this->sendWhatsAppMessage($phone, $reply);
            return;
        }

        // Just an extra helper for the shopping flow
        if (in_array($text, ['catalog', 'shop', 'products'])) {
            $this->sendWhatsAppMessage($phone, "Send your Interactive Catalog List here!"); // Replace with your actual catalog sending logic
            return;
        }

        $reply = "I didn't understand that. Send 'menu' to see your options.";
        $this->sendWhatsAppMessage($phone, $reply);
    }

    /**
     * 5. INTERACTIVE SHOPPING CART LOGIC
     */
    private function handleInteractiveShopping($phone, $interactiveData)
    {
        $type = $interactiveData['type']; // 'list_reply' or 'button_reply'

        // A. USER TAPPED A PRODUCT FROM A LIST
        if ($type === 'list_reply') {
            $productId = $interactiveData['list_reply']['id'];
            
            // Fetch product from DB (Make sure \App\Models\Product exists!)
            $product = \App\Models\Product::find($productId);
            if(!$product) return;

            // Get cart & add item
            $cart = Cache::get("wa_cart_{$phone}", []);
            $cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price
            ];
            
            Cache::put("wa_cart_{$phone}", $cart, now()->addHours(2));

            $subtotal = collect($cart)->sum('price');
            $itemCount = count($cart);

            $message = "🛒 *Cart Updated!*\n\nAdded: {$product->name}\nItems in cart: {$itemCount}\nSubtotal: ₦" . number_format($subtotal) . "\n\nWould you like to checkout now?";
            
            $this->sendWhatsAppButtons($phone, $message, [
                ['id' => 'checkout_now', 'title' => '💳 Checkout'],
                ['id' => 'keep_shopping', 'title' => '🛍️ Add More Items'],
                ['id' => 'empty_cart', 'title' => '🗑️ Empty Cart']
            ]);
        }

        // B. USER TAPPED A BUTTON
        elseif ($type === 'button_reply') {
            $actionId = $interactiveData['button_reply']['id'];

            if ($actionId === 'keep_shopping') {
                $this->sendWhatsAppMessage($phone, "Sure! Type 'catalog' to see our products again.");
            } 
            elseif ($actionId === 'empty_cart') {
                Cache::forget("wa_cart_{$phone}");
                $this->sendWhatsAppMessage($phone, "🗑️ Your cart has been emptied. Type 'catalog' to start over.");
            }
            elseif ($actionId === 'checkout_now') {
                $cart = Cache::get("wa_cart_{$phone}", []);
                
                if (empty($cart)) {
                    $this->sendWhatsAppMessage($phone, "Your cart is empty! Type 'catalog' to add items.");
                    return;
                }

                // Set state so the NEXT text message they send is captured as their address!
                Cache::put("wa_state_{$phone}", 'waiting_for_address', now()->addMinutes(15));
                $this->sendWhatsAppMessage($phone, "Great! 📍 Please type your full delivery address (e.g., 12 Admiralty Way, Lekki Phase 1, Lagos) so we can calculate your shipping fee.");
            }
        }
    }

    /**
     * 6. FINALIZE ORDER WITH ADDRESS (Shipbubble + DVA)
     */
    private function finalizeOrderWithAddress($phone, $address)
    {
        $this->sendWhatsAppMessage($phone, "⏳ Calculating shipping rates via Shipbubble...");

        // 1. Get Cart Totals
        $cart = Cache::get("wa_cart_{$phone}", []);
        $subtotal = collect($cart)->sum('price');

        // 2. SHIPBUBBLE LOGIC GOES HERE
        $shippingFee = 3000; // Placeholder: Replace with actual Shipbubble API call using $address

        $grandTotal = $subtotal + $shippingFee;

        // 3. VIRTUAL ACCOUNT GENERATION GOES HERE
        $virtualAccount = "8012345678"; // Placeholder: Replace with Fincra/Moniepoint DVA generation

        // 4. Send Final Invoice
        $invoice = "🧾 *YOUR INVOICE*\n\n";
        foreach($cart as $item) {
            $invoice .= "▪️ {$item['name']} - ₦" . number_format($item['price']) . "\n";
        }
        $invoice .= "🚚 Shipping to: _{$address}_\n";
        $invoice .= "📦 Delivery Fee: ₦" . number_format($shippingFee) . "\n\n";
        $invoice .= "*Total Due: ₦" . number_format($grandTotal) . "*\n\n";
        
        $invoice .= "To complete your order, please transfer exactly *₦" . number_format($grandTotal) . "* to:\n\n";
        $invoice .= "Bank: Moniepoint MFB\nAccount: *{$virtualAccount}*\nName: Q4I Payments\n\n_Your order will be automatically confirmed once payment is received._";

        $this->sendWhatsAppMessage($phone, $invoice);

        // 5. Clear Memory
        Cache::forget("wa_state_{$phone}");
        Cache::forget("wa_cart_{$phone}");
    }

    /**
     * 7. META API: SEND TEXT MESSAGE
     */
    private function sendWhatsAppMessage($to, $message)
    {
        $token = env('WHATSAPP_TOKEN');
        $phoneId = env('WHATSAPP_PHONE_ID');
        
        $response = Http::withToken($token)->post("https://graph.facebook.com/v19.0/{$phoneId}/messages", [
            'messaging_product' => 'whatsapp',
            'to' => $to, 
            'type' => 'text',
            'text' => [
                'body' => $message
            ]
        ]);

        if ($response->failed()) {
            Log::error('WhatsApp Meta API Error (Text): ' . $response->body());
        }
    }

    /**
     * 8. META API: SEND INTERACTIVE BUTTONS
     */
    private function sendWhatsAppButtons($to, $text, $buttons)
    {
        $token = env('WHATSAPP_TOKEN');
        $phoneId = env('WHATSAPP_PHONE_ID');
        
        $formattedButtons = array_map(function($btn) {
            return [
                'type' => 'reply',
                'reply' => ['id' => $btn['id'], 'title' => $btn['title']]
            ];
        }, $buttons);

        $response = Http::withToken($token)->post("https://graph.facebook.com/v19.0/{$phoneId}/messages", [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'interactive',
            'interactive' => [
                'type' => 'button',
                'body' => ['text' => $text],
                'action' => ['buttons' => $formattedButtons]
            ]
        ]);

        if ($response->failed()) {
            Log::error('WhatsApp Meta API Error (Buttons): ' . $response->body());
        }
    }
}