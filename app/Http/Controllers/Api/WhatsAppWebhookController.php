<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EscrowTransaction;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WhatsAppWebhookController extends Controller
{
    /**
     * 1. Meta requires a GET request to verify the webhook URL initially.
     */
    public function verifyWebhook(Request $request)
    {
        if ($request->input('hub_verify_token') === env('META_WEBHOOK_TOKEN')) {
            return response($request->input('hub_challenge'), 200);
        }
        return response('Invalid Token', 403);
    }

    /**
     * 2. THE TRAFFIC COP: Handles WhatsApp, Instagram, and Facebook.
     */
    public function handleIncomingMessage(Request $request)
    {
        try {
            $platform = 'whatsapp'; 
            $senderId = null;
            $text = '';

            // ROUTE A: IS IT WHATSAPP?
            if ($request->has('entry.0.changes.0.value.messages.0')) {
                $messageData = $request->input('entry.0.changes.0.value.messages.0');
                if (!$messageData) return response()->json(['status' => 'ignored']);
                
                $senderId = $messageData['from']; 
                $platform = 'whatsapp';

                if ($messageData['type'] === 'text') {
                    $text = trim($messageData['text']['body']);
                    $this->processCommand($platform, $senderId, $text);
                } 
                elseif ($messageData['type'] === 'interactive') {
                    $this->processInteractiveResponse($platform, $senderId, $messageData);
                }
            } 
            
            // ROUTE B: IS IT FACEBOOK MESSENGER OR INSTAGRAM?
            elseif ($request->has('entry.0.messaging.0')) {
                $messageData = $request->input('entry.0.messaging.0');
                if (!$messageData) return response()->json(['status' => 'ignored']);

                $senderId = $messageData['sender']['id']; 
                $platform = $request->input('object') === 'instagram' ? 'instagram' : 'facebook';

                if (isset($messageData['message']['text'])) {
                    $text = trim($messageData['message']['text']);
                    $this->processCommand($platform, $senderId, $text);
                }
                elseif (isset($messageData['postback']['payload'])) {
                    $payload = $messageData['postback']['payload'];
                    
                    if (str_starts_with($payload, 'buy_product_')) {
                        $productId = str_replace('buy_product_', '', $payload);
                        $this->processProductPurchase($platform, $senderId, $productId);
                    }
                }
            }

            return response()->json(['status' => 'success']);

        } catch (\Throwable $e) {
            Log::error('Meta Webhook Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * 3. THE MASTER ROUTER: Processes text commands from ANY platform
     */
    private function processCommand($platform, $senderId, $text)
    {
        $lowerText = strtolower(trim($text));

        // ==========================================
        // 🚨 1. THE ESCAPE HATCH (MUST BE FIRST) 🚨
        // ==========================================
        if (in_array($lowerText, ['cancel', 'exit', 'home', 'menu', 'restart', 'quit'])) {
            Cache::forget("wa_state_{$senderId}");
            Cache::forget("wa_cart_{$senderId}");
            Cache::forget("wa_active_shop_{$senderId}");
            Cache::forget("wa_pending_product_{$senderId}");

            EscrowTransaction::where('platform', $platform)
                ->where(function($q) use ($senderId) {
                    $q->where('buyer_phone', $senderId)
                      ->orWhere('platform_sender_id', $senderId);
                })
                ->where('status', 'awaiting_funds')
                ->whereNull('delivery_address')
                ->delete(); 

            $vendorUser = User::where('phone', 'like', "%" . substr($senderId, -10))->first();
            if ($vendorUser && in_array($lowerText, ['menu', 'home'])) {
                return $this->sendMessage($platform, $senderId, "👋 Welcome back, Vendor!\n\nReply with:\n*Wallet* - Check balance\n*Escrow* - Create manual escrow");
            }

            $reply = "🔄 Session cleared. You are back at the main menu!\n\n🛒 *To Shop:*\nReply with 'Shop [Store Name]'.\n\n💼 *To Sell:*\nVisit q4iltd.com/vendor/register";
            return $this->sendMessage($platform, $senderId, $reply);
        }

        // ==========================================
        // 2. ACTIVE SHOP CATALOG TRIGGER
        // ==========================================
        $activeShopId = Cache::get("wa_active_shop_{$senderId}");
        if ($activeShopId && in_array($lowerText, ['catalog', 'products'])) {
            $vendor = User::find($activeShopId);
            if ($vendor) {
                $products = Product::where('user_id', $vendor->id)->where('is_active', true)->limit(10)->get();
                if ($products->isNotEmpty()) {
                    return $this->sendProductList($senderId, $vendor, $products);
                }
            }
        }

        // ==========================================
        // 3. STATE INTERCEPTORS (Address, Quantity, Ratings)
        // ==========================================
        $botState = Cache::get("wa_state_{$senderId}");
        if ($botState) {
            if (str_starts_with($botState, 'waiting_for_rating_')) {
                return $this->processRatingInput($platform, $senderId, $text, $botState);
            }
            if (str_starts_with($botState, 'waiting_for_review_')) {
                return $this->processReviewInput($platform, $senderId, $text, $botState);
            }
            if ($botState === 'waiting_for_quantity') {
                return $this->processQuantityInput($platform, $senderId, $text);
            }
            if ($botState === 'waiting_for_cart_address') {
                return $this->processCartAddressInput($platform, $senderId, $text);
            }
        }

        $draftEscrow = EscrowTransaction::where('platform', $platform)
            ->where(function($q) use ($senderId) {
                $q->where('buyer_phone', $senderId)
                  ->orWhere('platform_sender_id', $senderId);
            })
            ->where('status', 'awaiting_funds')
            ->whereNull('delivery_address') 
            ->orderBy('created_at', 'desc') 
            ->first();

        if ($draftEscrow) {
            return $this->processAddressInput($platform, $senderId, $text, $draftEscrow);
        }

        // ==========================================
        // 4. MAIN COMMANDS
        // ==========================================
        if (str_starts_with($lowerText, 'shop')) {
            $shopName = trim(substr($text, 4)); 
            if (!empty($shopName)) {
                $this->handleShopCommand($platform, $senderId, $shopName);
            } else {
                $this->sendMessage($platform, $senderId, "To view a merchant's catalog, please send: Shop [Store Name]\nExample: Shop ML Kicks");
            }
        } 
        elseif (str_starts_with($lowerText, 'status')) {
            $this->handleStatusCheck($platform, $senderId, $text);
        } 
        elseif ($lowerText === 'wallet' || $lowerText === 'balance') {
            $this->handleWalletCheck($platform, $senderId);
        }
        elseif (str_starts_with($lowerText, 'escrow')) {
            $this->processEscrowCommand($platform, $senderId, $text);
        }
        elseif ($lowerText === 'accept') {
            $this->handleAcceptDelivery($platform, $senderId);
        }
        elseif ($lowerText === 'dispute') {
            $this->handleDisputeDelivery($platform, $senderId);
        }
        elseif (str_starts_with($lowerText, 'dev pay')) {
            // DEV BYPASS FOR REXPAY TIMEOUTS
            $reference = strtoupper(trim(substr($text, 7))); // "dev pay" is 7 chars
            
            if (empty($reference)) {
                // If they just typed "dev pay", grab their latest unpaid order
                $escrow = EscrowTransaction::where('platform', $platform)
                    ->where(function($q) use ($senderId) {
                        $q->where('buyer_phone', $senderId)
                          ->orWhere('platform_sender_id', $senderId);
                    })
                    ->where('status', 'awaiting_funds')
                    ->orderBy('created_at', 'desc')
                    ->first();
                    
                if (!$escrow) {
                    return $this->sendMessage($platform, $senderId, "⚠️ Developer Bypass Failed: You have no pending unpaid orders.");
                }
                $reference = $escrow->reference;
            } else {
                $escrow = EscrowTransaction::where('reference', $reference)->first();
            }
            
            if (!$escrow) {
                return $this->sendMessage($platform, $senderId, "⚠️ Developer Bypass Failed: Invoice $reference not found.");
            }
            if ($escrow->status !== 'awaiting_funds') {
                return $this->sendMessage($platform, $senderId, "⚠️ Developer Bypass Failed: Invoice $reference is already processed.");
            }
            
            $this->sendMessage($platform, $senderId, "🛠️ *DEV BYPASS ACTIVATED*\nForcing payment success for $reference...");
            
            $totalExpected = $escrow->amount + $escrow->shipping_fee;
            
            // Bypass logic (same as successful RexPay webhook)
            $escrow->update(['status' => 'funded_locked']);
            $escrowService = new \App\Services\EscrowService();
            $escrowService->lockEscrowFunds($escrow, $totalExpected);
        }
        else {
            $reply = "Welcome to *Q4I Social Commerce*! 🚀\n\n🛒 *To Shop:*\nReply with 'Shop [Store Name]' (e.g., 'Shop Bussy Sneaks').\n\n💼 *To Sell:*\nVisit q4iltd.com/vendor/register";
            $this->sendMessage($platform, $senderId, $reply);
        }
    }

    /**
     * 4. THE SINGLE ITEM CHECKOUT
     */
    private function processProductPurchase($platform, $buyerId, $productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return $this->sendMessage($platform, $buyerId, "Sorry, this item is no longer available.");
        }

        $escrow = EscrowTransaction::create([
            'reference' => 'ESC-' . strtoupper(uniqid()),
            'vendor_id' => $product->user_id,
            'buyer_phone' => $platform === 'whatsapp' ? $buyerId : null,
            'platform' => $platform,
            'platform_sender_id' => $platform !== 'whatsapp' ? $buyerId : null,
            'amount' => $product->price,
            'shipping_fee' => 0, 
            'item_description' => $product->name,
            'virtual_account_number' => '1234567890',
            'virtual_account_bank' => 'Wema Bank',
            'status' => 'awaiting_funds'
        ]);



        if ($platform === 'whatsapp') {
            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $buyerId,
                'type' => 'interactive',
                'interactive' => [
                    'type' => 'button',
                    'body' => ['text' => "Great choice! How would you like to receive *{$product->name}*?"],
                    'action' => [
                        'buttons' => [
                            ['type' => 'reply', 'reply' => ['id' => 'delivery_pickup_single_' . $escrow->id, 'title' => '🏪 Store Pickup']],
                            ['type' => 'reply', 'reply' => ['id' => 'delivery_ship_single_' . $escrow->id, 'title' => '🚚 Delivery']]
                        ]
                    ]
                ]
            ];
            \Illuminate\Support\Facades\Http::withoutVerifying()->withToken(env('META_ACCESS_TOKEN'))->post('https://graph.facebook.com/v25.0/' . env('META_PHONE_NUMBER_ID') . '/messages', $payload);
        } else {
            $this->sendMessage($platform, $buyerId, "Great choice! To calculate your shipping and generate your secure invoice for *{$product->name}*, please reply with your full delivery address and State.\n\nExample: *15 Allen Avenue, Ikeja, Lagos*");
        }
    }

    /**
     * 4B. PROCESS THE ADDRESS FOR SINGLE ITEM
     */
    private function processAddressInput($platform, $senderId, $address, $escrow)
    {
        $vendor = User::find($escrow->vendor_id);

        if ($address === 'pickup') {
            $shippingFee = 0;
            $address = 'Store Pickup: ' . $vendor->address . ', ' . $vendor->city . ', ' . $vendor->state;
        } else {
            $shipbubble = new \App\Services\ShipbubbleService();
            $shippingFee = $shipbubble->getCheapestRate($address, $vendor); 

            if ($shippingFee === null) {
                $errorMessage = "⚠️ *We couldn't verify that delivery address.*\n\n";
                $errorMessage .= "To calculate your exact shipping fee, please reply with a highly detailed address including your *Street Name, City, and State*.\n\n";
                $errorMessage .= "Example: _15 Allen Avenue, Ikeja, Lagos_";
                
                return $this->sendMessage($platform, $senderId, $errorMessage);
            }
        }

        // 🟢 THE NAIRA TRICK: Add ₦1 to ₦15 for webhook reconciliation
        $randomNaira = rand(1, 15);
        $newEscrowAmount = $escrow->amount + $randomNaira;
        $grandTotal = $newEscrowAmount + $shippingFee;

        // 🟢 Fetch Static Agent 0 Account
        $agentZeroData = $this->getVendorAgentZero($escrow->vendor_id);

        $escrow->update([
            'amount' => $newEscrowAmount,
            'delivery_address' => $address,
            'shipping_fee' => $shippingFee,
            'is_pickup' => ($shippingFee === 0 && str_starts_with($address, 'Store Pickup')),
            'virtual_account_number' => $agentZeroData['account_number'],
            'virtual_account_bank' => $agentZeroData['bank_name'],
        ]);

        $product = Product::where('name', $escrow->item_description)
                          ->where('user_id', $escrow->vendor_id)
                          ->first();

        $vendorPhone = $vendor ? $vendor->phone : '2348000000000';
        $vendorPhoneFormatted = $this->formatPhoneForMeta($vendorPhone);
        
        $this->sendMessage('whatsapp', $vendorPhoneFormatted, "🎉 A buyer from *" . ucfirst($platform) . "* is purchasing *{$escrow->item_description}*. They have successfully entered their delivery address and are proceeding to payment!");

        $this->sendInvoiceToBuyer($platform, $senderId, $escrow, $product);
    }

    /**
     * ==========================================
     * 5. THE NEW WHATSAPP CART SYSTEM
     * ==========================================
     */
    private function processInteractiveResponse($platform, $senderId, $messageData)
    {
        if (isset($messageData['interactive']['button_reply'])) {
            $buttonId = $messageData['interactive']['button_reply']['id'];

            if ($buttonId === 'checkout_now') {
                $cart = Cache::get("wa_cart_{$senderId}", []);
                if (empty($cart)) {
                    return $this->sendMessage($platform, $senderId, "Your cart is empty! Type 'catalog' to start browsing.");
                }
                
                $payload = [
                    'messaging_product' => 'whatsapp',
                    'to' => $senderId,
                    'type' => 'interactive',
                    'interactive' => [
                        'type' => 'button',
                        'body' => ['text' => "How would you like to receive your order?"],
                        'action' => [
                            'buttons' => [
                                ['type' => 'reply', 'reply' => ['id' => 'delivery_pickup_cart', 'title' => '🏪 Store Pickup']],
                                ['type' => 'reply', 'reply' => ['id' => 'delivery_ship_cart', 'title' => '🚚 Delivery']]
                            ]
                        ]
                    ]
                ];
                return \Illuminate\Support\Facades\Http::withoutVerifying()->withToken(env('META_ACCESS_TOKEN'))->post('https://graph.facebook.com/v25.0/' . env('META_PHONE_NUMBER_ID') . '/messages', $payload);
            } 
            elseif ($buttonId === 'keep_shopping') {
                Cache::forget("wa_state_{$senderId}");
                Cache::forget("wa_pending_product_{$senderId}");
                
                $activeShopId = Cache::get("wa_active_shop_{$senderId}");
                if ($activeShopId) {
                    $vendor = User::find($activeShopId);
                    if ($vendor) {
                        $products = Product::where('user_id', $vendor->id)->where('is_active', true)->limit(10)->get();
                        if ($products->isNotEmpty()) {
                            return $this->sendProductList($senderId, $vendor, $products);
                        }
                    }
                }
                return $this->sendMessage($platform, $senderId, "Please type 'Catalog' to bring up the products again.");
            }
            elseif ($buttonId === 'cancel_action') {
                Cache::forget("wa_state_{$senderId}");
                Cache::forget("wa_pending_product_{$senderId}");
                return $this->sendMessage($platform, $senderId, "❌ Cancelled. Tap 'Browse More' or type 'Catalog' to view products again.");
            }
            elseif ($buttonId === 'empty_cart') {
                Cache::forget("wa_cart_{$senderId}");
                Cache::forget("wa_state_{$senderId}");
                Cache::forget("wa_pending_product_{$senderId}");
                return $this->sendMessage($platform, $senderId, "🗑️ Your cart has been emptied.");
            }

            // --- DELIVERY / PICKUP SELECTION ---
            if ($buttonId === 'delivery_ship_cart') {
                Cache::put("wa_state_{$senderId}", 'waiting_for_cart_address', now()->addMinutes(15));
                return $this->sendMessage($platform, $senderId, "Great! 📍 Please type your full delivery address and State (e.g., 15 Allen Avenue, Ikeja, Lagos) so we can calculate your final shipping fee.");
            }
            if ($buttonId === 'delivery_pickup_cart') {
                return $this->processCartAddressInput($platform, $senderId, 'pickup');
            }
            if (str_starts_with($buttonId, 'delivery_ship_single_')) {
                Cache::put("wa_state_{$senderId}", 'waiting_for_single_address', now()->addMinutes(15));
                return $this->sendMessage($platform, $senderId, "Great! 📍 Please type your full delivery address and State (e.g., 15 Allen Avenue, Ikeja, Lagos) so we can calculate your final shipping fee.");
            }
            if (str_starts_with($buttonId, 'delivery_pickup_single_')) {
                $escrowId = str_replace('delivery_pickup_single_', '', $buttonId);
                $escrow = EscrowTransaction::find($escrowId);
                if ($escrow) {
                    return $this->processAddressInput($platform, $senderId, 'pickup', $escrow);
                }
                return $this->sendMessage($platform, $senderId, "⚠️ Order not found.");
            }

            // --- REXPAY MANUAL PAYMENT CHECK LOGIC ---
            if (str_starts_with($buttonId, 'check_payment_')) {
                $reference = str_replace('check_payment_', '', $buttonId);
                $escrow = EscrowTransaction::where('reference', $reference)->first();

                if (!$escrow) {
                    return $this->sendMessage($platform, $senderId, "⚠️ We couldn't find that invoice in our system.");
                }

                if ($escrow->status !== 'awaiting_funds') {
                    return $this->sendMessage($platform, $senderId, "✅ This order's payment has already been verified and processed!");
                }

                $this->sendMessage($platform, $senderId, "⏳ Checking payment status with RexPay...");

                try {
                    $verifyResp = \Illuminate\Support\Facades\Http::timeout(10)
                        ->withBasicAuth(env('REXPAY_USERNAME'), env('REXPAY_SECRET_KEY'))
                        ->withHeaders([
                            'Content-Type' => 'application/json',
                            'Accept'       => 'application/json',
                        ])
                        ->post(env('REXPAY_CPS_BASE_URL') . '/api/cps/v1/getTransactionStatus', [
                            'transactionReference' => (string) $reference
                        ]);

                    if ($verifyResp->successful()) {
                        $data = $verifyResp->json();
                        $responseCode = (string) ($data['responseCode'] ?? $data['data']['responseCode'] ?? '');
                        $status = strtoupper($data['responseDescription'] ?? $data['data']['responseDescription'] ?? $data['status'] ?? '');
                        $amountPaid = (float) ($data['amount'] ?? $data['data']['amount'] ?? 0);

                        if ($responseCode === '00' || in_array($status, ['SUCCESS', 'SUCCESSFUL', 'APPROVED', 'COMPLETED', 'PAID', 'TRANSACTION SUCCESSFUL'])) {
                            
                            $totalExpected = $escrow->amount + $escrow->shipping_fee;
                            if ($amountPaid >= $totalExpected) {
                                $escrow->update(['status' => 'funded_locked']);
                                $escrowService = new \App\Services\EscrowService();
                                $escrowService->lockEscrowFunds($escrow, $amountPaid);
                                
                                return; 
                            } else {
                                $escrow->update(['status' => 'partially_paid']);
                                return $this->sendMessage($platform, $senderId, "⚠️ *Partial Payment Detected*\n\nWe received ₦" . number_format($amountPaid) . ", but your order total was ₦" . number_format($totalExpected) . ". Your order is currently on hold.");
                            }
                        }
                        
                        return $this->sendMessage($platform, $senderId, "⚠️ We haven't received the transfer yet.\n\nBank networks can take a few minutes. If you have already transferred the exact amount, please try tapping the button again shortly!");
                    } else {
                        \Illuminate\Support\Facades\Log::error('RexPay Check Failed: ' . $verifyResp->body());
                        return $this->sendMessage($platform, $senderId, "🚨 RexPay responded with an error. Please try again in a minute.");
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('RexPay Timeout/Crash: ' . $e->getMessage());
                    return $this->sendMessage($platform, $senderId, "⏳ RexPay's server is taking too long to respond. Please wait 1-2 minutes and tap the button again.");
                }
            }

            // --- EXISTING ESCROW RELEASE LOGIC ---
            if (str_starts_with($buttonId, 'release_funds_')) {
                $escrowId = str_replace('release_funds_', '', $buttonId);
                $escrow = EscrowTransaction::find($escrowId);

                if ($escrow && $escrow->status !== 'released') {
                    
                    // 🟢 FIXED: Extract Q4I Profit and Update Ledgers Securely
                    DB::beginTransaction();
                    try {
                        $vendorUser = User::find($escrow->vendor_id);
                        $platformFee = $escrow->amount * 0.02;
                        $netPayout = $escrow->amount - $platformFee;

                        if ($vendorUser) {
                            $vendorUser->increment('wallet_balance', $netPayout);
                        }
                        
                        $escrow->update(['status' => 'released']);
                        
                        DB::table('system_earnings')->insert([
                            'transaction_ref' => $escrow->reference,
                            'merchant_id' => $escrow->vendor_id,
                            'type' => 'escrow_manual_release_commission',
                            'amount' => $platformFee,
                            'created_at' => now()
                        ]);

                        $cartItems = json_decode($escrow->cart_items, true);
                        if ($cartItems && is_array($cartItems)) {
                            foreach($cartItems as $item) {
                                $product = Product::find($item['id']);
                                if ($product) {
                                    $product->increment('total_sold', $item['quantity']); 
                                    if ($product->stock >= $item['quantity']) {
                                        $product->decrement('stock', $item['quantity']);
                                    } else {
                                        $product->update(['stock' => 0]); 
                                    }
                                }
                            }
                        }
                        DB::commit();

                        $vendorPhoneFormatted = $vendorUser ? $this->formatPhoneForMeta($vendorUser->phone) : null;
                        
                        Cache::put("wa_state_{$senderId}", 'waiting_for_rating_' . $escrow->id, now()->addMinutes(15));

                        $successMsg = "✅ *Funds Released!*\n\nThank you for confirming your delivery. The funds have been successfully credited to the vendor.\n\n";
                        $successMsg .= "⭐ *How was your experience?*\n";
                        $successMsg .= "Please rate the vendor by replying with a number from *1* (Poor) to *5* (Excellent).";

                        $this->sendMessage($platform, $senderId, $successMsg);

                        if ($vendorPhoneFormatted) {
                            $this->sendMessage('whatsapp', $vendorPhoneFormatted, "💰 *Payment Received!*\n\nThe buyer confirmed receipt of their items and released the funds.\n\n₦" . number_format($netPayout, 2) . " has been successfully added to your available wallet balance!");
                        }

                    } catch (\Throwable $e) {
                        DB::rollBack();
                        Log::error('Manual Release Error: ' . $e->getMessage());
                    }
                }
            }
            elseif (str_starts_with($buttonId, 'dispute_')) {
                $escrowId = str_replace('dispute_', '', $buttonId);
                $escrow = EscrowTransaction::find($escrowId);

                if ($escrow && $escrow->status !== 'disputed') {
                    $escrow->update(['status' => 'disputed']);

                    $vendorPhoneFormatted = $escrow->vendor ? $this->formatPhoneForMeta($escrow->vendor->phone) : null;

                    $this->sendMessage($platform, $senderId, "⚠️ *Dispute Opened*\n\nYour funds have been strictly frozen and will NOT be released to the vendor. A Q4I support agent has been notified and will contact you shortly.");
                    if ($vendorPhoneFormatted) {
                        $this->sendMessage('whatsapp', $vendorPhoneFormatted, "⚠️ *Dispute Opened*\n\nThe buyer reported an issue with the delivery of *{$escrow->item_description}*. The funds have been frozen. Our administrative team will review the transaction and reach out to you.");
                    }
                }
            }
        }
        
        // B. WhatsApp List Selection (Catalog Add To Cart)
        elseif (isset($messageData['interactive']['list_reply'])) {
            $listId = $messageData['interactive']['list_reply']['id']; 
            if (str_starts_with($listId, 'buy_product_')) {
                $productId = str_replace('buy_product_', '', $listId);
                $this->addToCart($platform, $senderId, $productId);
            }
        }
    }

    /**
     * 5B. THE INTERACTIVE PRODUCT CARD
     */
    private function addToCart($platform, $senderId, $productId)
    {
        try {
            $product = \App\Models\Product::find($productId);
            
            if (!$product) {
                return $this->sendMessage($platform, $senderId, "Sorry, we couldn't locate that item. ID: " . $productId);
            }

            if ($product->stock <= 0) {
                return $this->sendMessage($platform, $senderId, "Sorry, *{$product->name}* is currently out of stock!");
            }

            // Secure the session state
            Cache::put("wa_pending_product_{$senderId}", $product->id, now()->addMinutes(10));
            Cache::put("wa_state_{$senderId}", 'waiting_for_quantity', now()->addMinutes(10));

            $messageText = "You selected *{$product->name}* at ₦" . number_format($product->price) . ".\n\n📦 *{$product->stock} units available.*\n\nHow many would you like to buy? \n_Please reply with a number (e.g. 1, 2, 5)_";

            // 🚀 STRIPPED-DOWN TEXT-ONLY BUTTON PAYLOAD (Bypasses Image Restrictions)
            $token = env('META_ACCESS_TOKEN');
            $url = 'https://graph.facebook.com/v25.0/' . env('META_PHONE_NUMBER_ID') . '/messages';
            
            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $senderId,
                'type' => 'interactive',
                'interactive' => [
                    'type' => 'button',
                    'body' => [
                        'text' => $messageText
                    ],
                    'action' => [
                        'buttons' => [
                            ['type' => 'reply', 'reply' => ['id' => 'keep_shopping', 'title' => 'Browse More']],
                            ['type' => 'reply', 'reply' => ['id' => 'cancel_action', 'title' => 'Cancel']]
                        ]
                    ]
                ]
            ];
            
            $response = Http::withoutVerifying()->withToken($token)->post($url, $payload);
            
            if ($response->failed()) {
                // If Meta rejects the button structure, text the raw JSON error directly to your phone!
                $this->sendMessage($platform, $senderId, "🚨 META API REJECTION:\n\n" . $response->body());
            }

        } catch (\Throwable $e) {
            // If Laravel crashes internally, text the exact PHP crash log to your phone!
            $this->sendMessage($platform, $senderId, "🚨 PHP CRASHED:\n" . $e->getMessage() . "\nLine: " . $e->getLine());
        }
    }

    /**
     * 5B-2. PROCESS THE QUANTITY AND ADD TO CART
     */
    private function processQuantityInput($platform, $senderId, $text)
    {
        $qty = (int) trim($text);
        
        if ($qty <= 0) {
            return $this->sendMessage($platform, $senderId, "Please enter a valid number (e.g. 1).");
        }

        $productId = Cache::get("wa_pending_product_{$senderId}");
        $product = Product::find($productId);

        if (!$product) {
            Cache::forget("wa_state_{$senderId}");
            return $this->sendMessage($platform, $senderId, "Session expired. Please type 'shop' to start again.");
        }

        if ($qty > $product->stock) {
            return $this->sendMessage($platform, $senderId, "Oops! We only have *{$product->stock}* units left in stock. Please reply with a smaller number.");
        }

        $cart = Cache::get("wa_cart_{$senderId}", []);
        $found = false;
        
        foreach ($cart as &$item) {
            if ($item['id'] == $product->id) {
                $existingQty = $item['quantity'] ?? 1;
                $item['quantity'] = $existingQty + $qty; 
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'vendor_id' => $product->user_id,
                'quantity' => $qty 
            ];
        }

        Cache::put("wa_cart_{$senderId}", $cart, now()->addHours(2));
        Cache::forget("wa_state_{$senderId}");
        Cache::forget("wa_pending_product_{$senderId}");

        $subtotal = collect($cart)->sum(function($item) {
            $itemQty = $item['quantity'] ?? 1; 
            return $item['price'] * $itemQty;
        });
        
        $itemCount = collect($cart)->sum(function($item) {
            return $item['quantity'] ?? 1;
        });

        $message = "🛒 *Cart Updated!*\n\nAdded: {$qty}x {$product->name}\nTotal Items: {$itemCount}\nSubtotal: ₦" . number_format($subtotal, 2) . "\n\nWould you like to checkout now or add more items?";

        $token = env('META_ACCESS_TOKEN');
        $url = 'https://graph.facebook.com/v25.0/' . env('META_PHONE_NUMBER_ID') . '/messages';
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $senderId,
            'type' => 'interactive',
            'interactive' => [
                'type' => 'button',
                'body' => ['text' => $message],
                'action' => [
                    'buttons' => [
                        ['type' => 'reply', 'reply' => ['id' => 'checkout_now', 'title' => '💳 Checkout']],
                        ['type' => 'reply', 'reply' => ['id' => 'keep_shopping', 'title' => '🛍️ Add More']],
                        ['type' => 'reply', 'reply' => ['id' => 'empty_cart', 'title' => '🗑️ Empty Cart']]
                    ]
                ]
            ]
        ];
        Http::withoutVerifying()->withToken($token)->post($url, $payload);
    }

    /**
     * 5C. PROCESS THE ADDRESS FOR THE ENTIRE CART (REXPAY DVA INTEGRATION)
     */
    private function processCartAddressInput($platform, $senderId, $address)
    {
        $cart = Cache::get("wa_cart_{$senderId}", []);
        if (empty($cart)) {
            Cache::forget("wa_state_{$senderId}");
            return $this->sendMessage($platform, $senderId, "Your cart expired. Please type 'shop' to start again.");
        }

        $this->sendMessage($platform, $senderId, "⏳ Calculating shipping rates...");

        try {
            $vendorId = $cart[0]['vendor_id'];
            $vendor = User::find($vendorId);

            // ==========================================
            // 1. THE EXTERNAL LOGISTICS CALL (DIAGNOSTIC VIEW)
            // ==========================================
            // Check if the vendor has a pickup location in this database instance
            if (!$vendor || empty($vendor->address) || empty($vendor->city) || empty($vendor->state)) {
                \Illuminate\Support\Facades\Cache::forget("wa_state_{$senderId}");
                $vendorName = $vendor ? $vendor->name : 'Unknown';
                return $this->sendMessage($platform, $senderId, "🚨 LOGISTICS ERROR:\n\nVendor *{$vendorName}* (ID: {$vendorId}) does not have a pickup address, city, or state configured inside the new database yet! Go to your admin panel/database and fill out the merchant profile data.");
            }

            try {
                if ($address === 'pickup') {
                    $shippingFee = 0;
                    $address = 'Store Pickup: ' . $vendor->address . ', ' . $vendor->city . ', ' . $vendor->state;
                } else {
                    $shipbubble = new \App\Services\ShipbubbleService();
                    $shippingFee = $shipbubble->getCheapestRate($address, $vendor); 
                }
            } catch (\Throwable $shippingError) {
                \Illuminate\Support\Facades\Cache::forget("wa_state_{$senderId}");
                return $this->sendMessage($platform, $senderId, "🚨 SHIPBUBBLE API CRASH:\n\n" . $shippingError->getMessage());
            }

            if ($shippingFee === null) {
                \Illuminate\Support\Facades\Cache::forget("wa_state_{$senderId}");
                return $this->sendMessage($platform, $senderId, "⚠️ *Logistics Warning:*\n\nShipbubble returned a null rate for this address. Ensure your SHIPBUBBLE_API_KEY is correctly set in your new .env file, or check that the address is recognized.");
            }

            // 2. THE NAIRA TRICK & PRICING AGGREGATION
            $randomNaira = rand(1, 15);
            $subtotal = collect($cart)->sum(function($item) {
                return $item['price'] * ($item['quantity'] ?? 1);
            }) + $randomNaira;

            $grandTotal = $subtotal + $shippingFee;

            $itemNames = collect($cart)->pluck('name')->implode(', ');
            $itemDescription = strlen($itemNames) > 255 ? substr($itemNames, 0, 250) . '...' : $itemNames;

            // ==========================================
            // 3A. STEP ONE: INITIATE WITH REXPAY PGS SERVER
            // ==========================================
            $reference = 'ESC' . strtoupper(uniqid());
            $customerName = $vendor->business_name ?? 'Q4I Merchant';
            $customerEmail = $vendor->email ?? 'admin@q4iltd.com';

            $initResponse = \Illuminate\Support\Facades\Http::timeout(15)
                ->withBasicAuth(env('REXPAY_USERNAME'), env('REXPAY_SECRET_KEY'))
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ])
                ->post(env('REXPAY_PGS_BASE_URL') . '/api/pgs/payment/v2/createPayment', [
                    'reference'       => (string) $reference, 
                    'userId'          => (string) env('REXPAY_USERNAME'),
                    'amount'          => (float) $grandTotal, // 🔴 STRICTLY NUMERIC FOR PGS
                    'currency'        => 'NGN',
                    'paymentChannel'  => 'ACCOUNT', // 🔴 STRICTLY STRING "ACCOUNT"
                    'callbackUrl'     => url('/'), 
                    'webhookUrl'      => url('/api/webhooks/rexpay-dva'),
                    'notificationUrl' => url('/api/webhooks/rexpay-dva'),
                    'metadata'        => [
                        'email'        => (string) $customerEmail,
                        'customerName' => (string) $customerName
                    ]
                ]);

            if (!$initResponse->successful()) {
                \Illuminate\Support\Facades\Log::error('RexPay Init Failed: ' . $initResponse->body());
                \Illuminate\Support\Facades\Cache::forget("wa_state_{$senderId}");
                return $this->sendMessage($platform, $senderId, "🚨 REXPAY STEP 1 (PGS) FAILED:\n\n" . $initResponse->body());
            }

            // ==========================================
            // 3B. STEP TWO: GENERATE ACCOUNT VIA CPS SERVER
            // ==========================================
            $dvaResponse = \Illuminate\Support\Facades\Http::timeout(15)
                ->withBasicAuth(env('REXPAY_USERNAME'), env('REXPAY_SECRET_KEY'))
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ])
                ->post(env('REXPAY_CPS_BASE_URL') . '/api/cps/v1/initiateBankTransfer', [
                    'customerName' => (string) $customerName,
                    'reference'    => (string) $reference, 
                    'amount'       => (string) $grandTotal, // 🔴 STRICTLY STRING FOR CPS
                    'customerId'   => (string) $customerEmail,
                ]);

            if (!$dvaResponse->successful()) {
                \Illuminate\Support\Facades\Log::error('RexPay DVA Generation Failed: ' . $dvaResponse->body());
                \Illuminate\Support\Facades\Cache::forget("wa_state_{$senderId}");
                return $this->sendMessage($platform, $senderId, "🚨 REXPAY STEP 2 (CPS) FAILED:\n\n" . $dvaResponse->body());
            }

            $rexpayData = $dvaResponse->json();
            
            // Extract the generated bank details from Step 2
            $bankName = $rexpayData['bankName'] ?? $rexpayData['data']['bankName'] ?? 'Q4I Partner Bank';
            $accountNumber = $rexpayData['accountNumber'] ?? $rexpayData['data']['accountNumber'] ?? 'Pending...';
            $accountName = $rexpayData['accountName'] ?? $rexpayData['data']['accountName'] ?? 'Q4I Escrow';
            
            // ==========================================
            // 3C. SAVE TO DATABASE (THE MISSING STEP!)
            // ==========================================
            \App\Models\EscrowTransaction::create([
                'reference' => $reference,
                'vendor_id' => $vendorId,
                'buyer_phone' => $platform === 'whatsapp' ? $senderId : null,
                'platform' => $platform,
                'platform_sender_id' => $platform !== 'whatsapp' ? $senderId : null,
                'amount' => $subtotal,
                'shipping_fee' => $shippingFee,
                'item_description' => $itemDescription,
                'cart_items' => json_encode($cart),
                'delivery_address' => $address,
                'is_pickup' => ($shippingFee === 0 && str_starts_with($address, 'Store Pickup')),
                'virtual_account_number' => $accountNumber,
                'virtual_account_bank' => $bankName,
                'status' => 'awaiting_funds'
            ]);

            // ==========================================
            // 4. GENERATE INVOICE WITH LIVE REXPAY ACCOUNT
            // ==========================================
            $invoice = "🧾 *YOUR SECURE INVOICE*\n\n";
            foreach($cart as $item) {
                $itemTotal = $item['price'] * $item['quantity'];
                $invoice .= "▪️ {$item['quantity']}x {$item['name']} - ₦" . number_format($itemTotal, 2) . "\n";
            }
            $invoice .= "\n📍 Delivery to: _{$address}_\n";
            $invoice .= "📦 Delivery Fee: *₦" . number_format($shippingFee, 2) . "*\n";
            $invoice .= "💰 Grand Total: *₦" . number_format($grandTotal, 2) . "*\n\n";
            $invoice .= "⚠️ _To secure this order, you MUST transfer the exact Grand Total (including the extra Naira) to:_\n\n";
            $invoice .= "🏦 Bank: *{$bankName}*\n";
            $invoice .= "🔢 Account: *{$accountNumber}*\n";
            $invoice .= "👤 Name: *{$accountName}*\n\n";
            $invoice .= "⏳ _This account number expires in 30 minutes._\n";
            $invoice .= "🔒 _Your money is 100% protected in the Q4I Vault._";

            // 5. SEND THE INVOICE & CLEAN UP
            if ($platform === 'whatsapp') {
                $payload = [
                    'messaging_product' => 'whatsapp',
                    'to' => $senderId,
                    'type' => 'interactive',
                    'interactive' => [
                        'type' => 'button',
                        'body' => ['text' => substr($invoice, 0, 1024)],
                        'action' => [
                            'buttons' => [
                                ['type' => 'reply', 'reply' => ['id' => 'check_payment_' . $reference, 'title' => '✅ I Have Paid']]
                            ]
                        ]
                    ]
                ];
                \Illuminate\Support\Facades\Http::withoutVerifying()->withToken(env('META_ACCESS_TOKEN'))->post('https://graph.facebook.com/v25.0/' . env('META_PHONE_NUMBER_ID') . '/messages', $payload);
            } else {
                $this->sendMessage($platform, $senderId, $invoice);
            }
            Cache::forget("wa_state_{$senderId}");
            Cache::forget("wa_cart_{$senderId}");

        } catch (\Throwable $e) {
            Cache::forget("wa_state_{$senderId}");
            Log::error("Checkout error: " . $e->getMessage());
            $this->sendMessage($platform, $senderId, "🚨 CHECKOUT CRASHED:\n" . $e->getMessage());
        }
    }

    /**
     * ==========================================
     * 6. EXISTING SHOP CATALOG RENDERING METHODS
     * ==========================================
     */
    private function handleShopCommand($platform, $buyerId, $shopName)
    {
        $vendor = User::where('store_name', 'LIKE', "%{$shopName}%")->first();

        if (!$vendor) {
            return $this->sendMessage($platform, $buyerId, "We couldn't find a shop named *{$shopName}*. Please check the spelling and try again.");
        }

        Cache::put("wa_active_shop_{$buyerId}", $vendor->id, now()->addHours(2));

        $products = Product::where('user_id', $vendor->id)->where('is_active', true)->limit(10)->get();

        if ($products->isEmpty()) {
            return $this->sendMessage($platform, $buyerId, "This merchant doesn't have any active products at the moment.");
        }

        if ($platform === 'whatsapp') {
            return $this->sendProductList($buyerId, $vendor, $products); 
        } else {
            return $this->sendProductCarousel($platform, $buyerId, $vendor, $products);
        }
    }

    private function sendProductList($buyerPhone, $vendor, $products)
    {
        $sections = [];
        $groupedProducts = $products->groupBy(function($item) {
            return $item->category ?? 'other'; 
        });

        $categoryLabels = [
            'fashion' => '👗 Clothing & Fashion',
            'electronics' => '📱 Electronics',
            'beauty' => '💄 Health & Beauty',
            'home' => '🛋️ Home & Furniture',
            'services' => '💻 Digital Services',
            'other' => '🛍️ Other Items'
        ];

        foreach ($groupedProducts as $categoryKey => $items) {
            $rows = [];
            foreach ($items as $product) {
                $rows[] = [
                    'id' => 'buy_product_' . $product->id,
                    'title' => substr($product->name, 0, 24),
                    'description' => '₦' . number_format($product->price, 2)
                ];
            }
            $sections[] = [
                'title' => substr($categoryLabels[$categoryKey] ?? '🛍️ ' . ucfirst($categoryKey), 0, 24),
                'rows' => $rows
            ];
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $buyerPhone,
            'type' => 'interactive',
            'interactive' => [
                'type' => 'list',
                'header' => [
                    'type' => 'text',
                    'text' => '🛍️ ' . substr($vendor->store_name ?? $vendor->name, 0, 60)
                ],
                'body' => [
                    'text' => "Tap the button below to view their available products. Selecting an item will add it to your cart."
                ],
                'footer' => [
                    'text' => 'Secure Checkout via Q4I Gateway'
                ],
                'action' => [
                    'button' => 'View Catalog',
                    'sections' => $sections 
                ]
            ]
        ];

        Http::withoutVerifying()
            ->withToken(env('META_ACCESS_TOKEN'))
            ->post('https://graph.facebook.com/v25.0/' . env('META_PHONE_NUMBER_ID') . '/messages', $payload);
    }

    private function sendProductCarousel($platform, $buyerId, $vendor, $products)
    {
        $elements = [];
        foreach ($products->take(10) as $product) {
            $primaryImage = null;
            if ($product->image) {
                $primaryImage = is_array($product->image) ? ($product->image[0] ?? null) : $product->image;
            }
            $imageUrl = $primaryImage ? asset('storage/' . $primaryImage) : 'https://via.placeholder.com/600x600.png?text=No+Image';

            $elements[] = [
                'title' => substr($product->name, 0, 80),
                'subtitle' => '₦' . number_format($product->price, 2) . ' | ' . substr($product->description ?? 'Secure Escrow Checkout', 0, 50),
                'image_url' => $imageUrl,
                'buttons' => [
                    [
                        'type' => 'postback',
                        'title' => '🛍️ Buy Now',
                        'payload' => 'buy_product_' . $product->id 
                    ]
                ]
            ];
        }

        $payload = [
            'recipient' => ['id' => $buyerId],
            'message' => [
                'attachment' => [
                    'type' => 'template',
                    'payload' => [
                        'template_type' => 'generic',
                        'elements' => $elements
                    ]
                ]
            ]
        ];

        Http::withoutVerifying()->post('https://graph.facebook.com/v25.0/me/messages?access_token=' . env('META_PAGE_ACCESS_TOKEN'), $payload);
    }

    /**
     * MANUAL ESCROW CREATION
     */
    private function processEscrowCommand($platform, $senderId, $text)
    {
        $parts = explode(' ', $text);

        if (count($parts) < 4) {
            $this->sendMessage($platform, $senderId, "❌ Invalid format. Please use: Escrow [Amount] [Item] [BuyerPhone]");
            return;
        }

        // 🟢 THE NAIRA TRICK
        $amount = $parts[1] + rand(1, 15);
        $item = $parts[2]; 
        $buyerPhone = $parts[3];

        $formattedBuyerPhone = $this->formatPhoneForMeta($buyerPhone);
        $reference = 'ESC' . strtoupper(uniqid());
        $vendorId = $this->getUserIdByPhone($senderId);
        
        $agentZeroData = $this->getVendorAgentZero($vendorId);
        $deliveryPin = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        $escrow = EscrowTransaction::create([
            'reference' => $reference,
            'vendor_id' => $vendorId,
            'buyer_phone' => $formattedBuyerPhone,
            'platform' => 'whatsapp', 
            'amount' => $amount,
            'shipping_fee' => 0,
            'item_description' => $item,
            'virtual_account_number' => $agentZeroData['account_number'],
            'virtual_account_bank' => $agentZeroData['bank_name'],
            'status' => 'awaiting_funds',
            'delivery_pin' => Hash::make($deliveryPin),
        ]);

        $this->sendMessage($platform, $senderId, "✅ Escrow created! I am sending the payment details to the buyer now.");
        $this->sendInvoiceToBuyer('whatsapp', $formattedBuyerPhone, $escrow);
    }

    private function sendInvoiceToBuyer($platform, $buyerId, $escrow, $product = null)
    {
        $message = "🔒 *Q4I Secure Escrow Invoice*\n\n";
        
        if ($product) {
            $message .= "📸 *" . $product->name . "*\n";
            if ($product->description) {
                $message .= "_" . substr($product->description, 0, 100) . "..._\n\n"; 
            }
        }

        $total = $escrow->amount + $escrow->shipping_fee;

        if ($escrow->delivery_address) {
            $message .= "📍 Delivery to: _{$escrow->delivery_address}_\n\n";
        }
        $message .= "Item Price: *₦" . number_format($escrow->amount, 2) . "*\n";
        $message .= "Shipping Fee: *₦" . number_format($escrow->shipping_fee, 2) . "*\n";
        $message .= "Grand Total: *₦" . number_format($total, 2) . "*\n\n";
        $message .= "To securely pay and trigger delivery, please transfer exactly ₦" . number_format($total) . " to:\n\n";
        $message .= "🏦 Bank: *{$escrow->virtual_account_bank}*\n";
        $message .= "🔢 Account: *{$escrow->virtual_account_number}*\n";
        $message .= "👤 Name: *Q4I Escrow*\n\n"; 
        $message .= "_Your money is 100% protected in the Q4I Vault until you receive your item._";

        if ($platform !== 'whatsapp') {
            return $this->sendMessage($platform, $buyerId, $message);
        }

        $metaApiUrl = 'https://graph.facebook.com/v25.0/' . env('META_PHONE_NUMBER_ID') . '/messages';

        $primaryImage = null;
        if ($product && $product->image) {
            $primaryImage = is_array($product->image) ? ($product->image[0] ?? null) : $product->image;
        }

        if ($primaryImage) {
            $imageUrl = asset('storage/' . $primaryImage);
            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $buyerId,
                'type' => 'interactive',
                'interactive' => [
                    'type' => 'button',
                    'header' => [
                        'type' => 'image',
                        'image' => ['link' => $imageUrl]
                    ],
                    'body' => ['text' => substr($message, 0, 1024)],
                    'action' => [
                        'buttons' => [
                            ['type' => 'reply', 'reply' => ['id' => 'check_payment_' . $escrow->reference, 'title' => '✅ I Have Paid']]
                        ]
                    ]
                ]
            ];
        } else {
            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $buyerId,
                'type' => 'interactive',
                'interactive' => [
                    'type' => 'button',
                    'body' => ['text' => substr($message, 0, 1024)],
                    'action' => [
                        'buttons' => [
                            ['type' => 'reply', 'reply' => ['id' => 'check_payment_' . $escrow->reference, 'title' => '✅ I Have Paid']]
                        ]
                    ]
                ]
            ];
        }

        $response = Http::withoutVerifying()->withToken(env('META_ACCESS_TOKEN'))->post($metaApiUrl, $payload);
        if ($response->failed()) { Log::error('WhatsApp Invoice Error: ' . $response->body()); }
    }

    /**
     * ==========================================
     * EXTRA FEATURES (STATUS & WALLET)
     * ==========================================
     */
    private function handleStatusCheck($platform, $senderId, $text)
    {
        $parts = explode(' ', $text);
        
        if (count($parts) < 2) {
            return $this->sendMessage($platform, $senderId, "🔍 To check your order, reply with 'Status' followed by your Order ID.\n\nExample: *Status ESC-12345*");
        }

        $reference = strtoupper($parts[1]);
        $escrow = EscrowTransaction::where('reference', $reference)->first();

        if (!$escrow) {
            return $this->sendMessage($platform, $senderId, "❌ We couldn't find an order with the ID: *{$reference}*. Please check the ID and try again.");
        }

        $message = "📦 *Order Status: {$reference}*\n\n";
        $message .= "Item: *{$escrow->item_description}*\n";
        $message .= "Amount: *₦" . number_format($escrow->amount, 2) . "*\n\n";

        $paymentStatus = match($escrow->status) {
            'awaiting_funds' => '🟡 Awaiting Payment',
            'funded', 'funded_locked' => '🟢 Funds Secured in Vault',
            'released' => '✅ Payment Released to Vendor',
            'disputed' => '🛑 Disputed / Frozen',
            default => '⚪ Unknown'
        };

        $shippingStatus = match($escrow->shipping_status) {
            'pending' => '⏳ Waiting for Dispatch',
            'shipped' => '🚚 In Transit',
            'delivered' => '📍 Delivered',
            default => '⚪ Unknown'
        };

        $message .= "💰 Payment: {$paymentStatus}\n";
        $message .= "🚀 Logistics: {$shippingStatus}\n\n";

        if ($escrow->tracking_link) {
            $message .= "🔗 *Track Live:* {$escrow->tracking_link}\n";
        }

        $this->sendMessage($platform, $senderId, $message);
    }

    private function handleWalletCheck($platform, $vendorPhone)
    {
        $userId = $this->getUserIdByPhone($vendorPhone);
        
        $availableBalance = EscrowTransaction::where('vendor_id', $userId)
                                ->where('status', 'released')
                                ->sum('amount');
                                
        $lockedBalance = EscrowTransaction::where('vendor_id', $userId)
                                ->whereIn('status', ['funded_locked', 'in_transit'])
                                ->sum('amount');

        $message = "👛 *Your Q4I Wallet Balance*\n\n";
        $message .= "✅ *Available Balance:*\n₦" . number_format($availableBalance, 2) . "\n_(Ready for withdrawal)_\n\n";
        $message .= "🔒 *Locked in Escrow:*\n₦" . number_format($lockedBalance, 2) . "\n_(Pending buyer confirmation)_";

        $this->sendMessage($platform, $vendorPhone, $message);
    }

    /**
     * ==========================================
     * OMNICHANNEL MESSENGER HELPER
     * ==========================================
     */
    private function sendMessage($platform, $to, $message)
    {
        if ($platform === 'whatsapp') {
            $token = env('META_ACCESS_TOKEN');
            $url = 'https://graph.facebook.com/v25.0/' . env('META_PHONE_NUMBER_ID') . '/messages';
            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'text',
                'text' => ['body' => $message]
            ];
        } else {
            $token = env('META_PAGE_ACCESS_TOKEN');
            $url = 'https://graph.facebook.com/v25.0/me/messages?access_token=' . $token;
            $payload = [
                'recipient' => ['id' => $to],
                'message' => ['text' => $message]
            ];
        }

        $response = Http::withoutVerifying()->withToken($token)->post($url, $payload);

        if ($response->failed()) {
            Log::error(ucfirst($platform) . ' API Rejection: ' . $response->body());
        }
    }

    /**
     * ==========================================
     * UTILITY FUNCTIONS
     * ==========================================
     */
    private function formatPhoneForMeta($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            return '234' . substr($phone, 1);
        }
        return $phone;
    }

    private function getUserIdByPhone($phone)
    {
        $user = User::where('phone', $phone)
                    ->orWhere('phone', '0' . substr($phone, 3)) 
                    ->first();
        
        return $user ? $user->id : 1; 
    }

    /**
     * ==========================================
     * 🟢 FALLBACK UTILITY (Restored for Manual Escrow)
     * ==========================================
     */
    private function getVendorAgentZero($vendorId)
    {
        try {
            $merchant = DB::table('merchants')->where('id', $vendorId)->first() 
                     ?? DB::table('merchants')->first();
            
            $merchantId = $merchant ? $merchant->id : 1;
            $businessName = $merchant ? $merchant->business_name : 'Q4I Master';

            $bankAccount = DB::table('merchant_bank_accounts')
                ->where('merchant_id', $merchantId)
                ->where('is_default', 1)
                ->first() 
                ?? DB::table('merchant_bank_accounts')->where('merchant_id', $merchantId)->first();
            
            return [
                'account_number' => $bankAccount ? $bankAccount->account_number : env('DEFAULT_ESCROW_ACCOUNT', '1234567890'),
                'bank_name'      => $bankAccount ? $bankAccount->bank_name : '9PSB',
                'account_name'   => $bankAccount ? $bankAccount->account_name : $businessName . ' Escrow'
            ];
        } catch (\Throwable $e) {
            return [
                'account_number' => '1234567890',
                'bank_name'      => '9PSB',
                'account_name'   => 'Q4I Master Escrow'
            ];
        }
    }

    /**
     * 🟢 THE GHOST WEBHOOK (Simulates a successful payment)
     */
    public function mockPaymentWebhook($escrow_id)
    {
        $escrow = EscrowTransaction::find($escrow_id);

        if (!$escrow) {
            return response()->json(['error' => 'Escrow transaction not found!'], 404);
        }

        if ($escrow->status === 'funded_locked') {
            return response()->json(['message' => 'This transaction is already paid!'], 200);
        }

        // Just call the centralized service!
        $escrowService = new \App\Services\EscrowService();
        $escrowService->lockEscrowFunds($escrow, $escrow->amount);

        return response()->json([
            'status' => 'success',
            'message' => 'Ghost Webhook Fired! Vendor notified, Buyer received PIN, and Logistics Booked!',
            'escrow_id' => $escrow->id
        ], 200);
    }

    /**
     * THE LISTENING STATION: Catches Shipbubble tracking updates
     */
    public function handleShipbubbleWebhook(Request $request)
    {
        $orderId = $request->input('order_id');
        $status = $request->input('status'); 

        $escrow = EscrowTransaction::where('tracking_code', $orderId)->first();

        if (!$escrow) {
            return response()->json(['status' => 'success', 'message' => 'Order ignored'], 200);
        }

        $vendor = User::find($escrow->vendor_id);
        $buyerPhoneFormatted = $this->formatPhoneForMeta($escrow->buyer_phone);
        $vendorPhoneFormatted = $vendor ? $this->formatPhoneForMeta($vendor->phone) : null;

        if ($status === 'picked_up' || $status === 'in_transit') {
            if ($escrow->status === 'funded_locked') {
                $escrow->update([
                    'status' => 'in_transit',        
                    'shipping_status' => 'shipped'   
                ]);
                
                $this->sendMessage('whatsapp', $buyerPhoneFormatted, "🚚 *PACKAGE ON THE MOVE!*\n\nThe dispatch rider has successfully picked up your *{$escrow->item_description}* from the vendor. It is now heading your way!");
            }
        }
        elseif ($status === 'completed' || $status === 'delivered') {
            if ($escrow->status !== 'released' && $escrow->status !== 'disputed') { 
                $escrow->update([
                    'shipping_status' => 'delivered', 
                    'delivered_at' => now(), 
                ]); 

                $buyerMsg = "📦 *PACKAGE DELIVERED!*\n\nShipbubble just confirmed your *{$escrow->item_description}* has been delivered.\n\n⚠️ *ACTION REQUIRED:*\nPlease open and inspect your items. Are you satisfied?";
                
                $payload = [
                    'messaging_product' => 'whatsapp',
                    'to' => $buyerPhoneFormatted,
                    'type' => 'interactive',
                    'interactive' => [
                        'type' => 'button',
                        'body' => ['text' => $buyerMsg],
                        'action' => [
                            'buttons' => [
                                ['type' => 'reply', 'reply' => ['id' => 'release_funds_' . $escrow->id, 'title' => '✅ ACCEPT']],
                                ['type' => 'reply', 'reply' => ['id' => 'dispute_' . $escrow->id, 'title' => '🛑 DISPUTE']]
                            ]
                        ]
                    ]
                ];
                Http::withoutVerifying()->withToken(env('META_ACCESS_TOKEN'))->post('https://graph.facebook.com/v25.0/' . env('META_PHONE_NUMBER_ID') . '/messages', $payload);

                if ($vendorPhoneFormatted) {
                    $vendorMsg = "*(Vendor Copy)* 📦 *DELIVERY CONFIRMED*\n\nYour buyer has received the *{$escrow->item_description}*. They now have 24 hours to inspect it. \n\nIf no disputes are raised, your funds will be released automatically tomorrow!";
                    $this->sendMessage('whatsapp', $buyerPhoneFormatted, $vendorMsg); 
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * ==========================================
     * 7. RATING & REVIEW PROCESSING
     * ==========================================
     */
    private function processRatingInput($platform, $senderId, $text, $botState)
    {
        $rating = (int) trim($text);
        
        if ($rating < 1 || $rating > 5) {
            return $this->sendMessage($platform, $senderId, "⚠️ Please reply with a single number between 1 and 5.");
        }

        $escrowId = str_replace('waiting_for_rating_', '', $botState);
        $escrow = EscrowTransaction::find($escrowId);

        if ($escrow) {
            // 🟢 FIXED: Verify the rater actually owns the transaction!
            if ($this->formatPhoneForMeta($escrow->buyer_phone) === $this->formatPhoneForMeta($senderId)) {
                $escrow->update(['rating' => $rating]);
            }
        }

        Cache::put("wa_state_{$senderId}", 'waiting_for_review_' . $escrowId, now()->addMinutes(15));

        $stars = str_repeat('⭐', $rating);
        $message = "You rated this order {$stars}.\n\n💬 Would you like to leave a short text review for this vendor? \n\n_(Just type your review, or reply *SKIP* to finish)_";
        
        $this->sendMessage($platform, $senderId, $message);
    }

    private function processReviewInput($platform, $senderId, $text, $botState)
    {
        $reviewText = trim($text);
        
        if (strtoupper($reviewText) !== 'SKIP') {
            $escrowId = str_replace('waiting_for_review_', '', $botState);
            $escrow = EscrowTransaction::find($escrowId);

            if ($escrow && $this->formatPhoneForMeta($escrow->buyer_phone) === $this->formatPhoneForMeta($senderId)) {
                $escrow->update(['review' => htmlspecialchars($reviewText)]);
            }
        }

        Cache::forget("wa_state_{$senderId}");
        $this->sendMessage($platform, $senderId, "🎉 All done! Thank you for your feedback. It helps keep the Q4I community safe and reliable. Type 'shop' anytime you want to buy something new!");
    }

    /**
     * ==========================================
     * REXPAY OUT-OF-BAND PAYMENT LISTENER
     * ==========================================
     */
    public function handleRexpayDvaWebhook(\Illuminate\Http\Request $request)
    {
        \Illuminate\Support\Facades\Log::info('RexPay DVA Webhook Intercepted: ', $request->all());
        
        // Safely extract the reference depending on how RexPay nests their webhook payload
        $reference = $request->input('reference') ?? $request->input('data.reference') ?? $request->input('transactionReference');
        
        if (!$reference) {
            return response()->json(['status' => 'error', 'message' => 'No reference provided'], 400);
        }

        // 1. Server-to-Server Double Check (Fraud Prevention)
        // 🔴 UPDATED: We generated this via CPS, so we MUST verify via the CPS server!
        $verifyResp = \Illuminate\Support\Facades\Http::timeout(30)
            ->withBasicAuth(env('REXPAY_USERNAME'), env('REXPAY_SECRET_KEY'))
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ])
            ->post(env('REXPAY_CPS_BASE_URL') . '/api/cps/v1/getTransactionStatus', [
                'transactionReference' => (string) $reference
            ]);

        if (!$verifyResp->successful()) {
            \Illuminate\Support\Facades\Log::error('RexPay Webhook Verification Failed: ' . $verifyResp->body());
            return response()->json(['status' => 'error', 'message' => 'Verification step failed'], 400);
        }

        $data = $verifyResp->json();
        
        // 🔴 UPDATED: Extracting CPS-specific response codes
        $responseCode = (string) ($data['responseCode'] ?? $data['data']['responseCode'] ?? '');
        $status = strtoupper($data['responseDescription'] ?? $data['data']['responseDescription'] ?? $data['status'] ?? '');
        $amountPaid = (float) ($data['amount'] ?? $data['data']['amount'] ?? 0);
        
        // RexPay CPS uses responseCode "00" for successful bank transfers
        if ($responseCode === '00' || in_array($status, ['SUCCESS', 'SUCCESSFUL', 'APPROVED', 'COMPLETED', 'PAID', 'TRANSACTION SUCCESSFUL'])) {
            
            $escrow = \App\Models\EscrowTransaction::where('reference', $reference)->first();

            if ($escrow && $escrow->status === 'awaiting_funds') {
                
                $totalExpected = $escrow->amount + $escrow->shipping_fee;
                
                // 2. Strict Amount Validation
                if ($amountPaid >= $totalExpected) {
                    
                    // Transaction is perfect! Lock the vault.
                    $escrow->update(['status' => 'funded_locked']);
                    
                    // 3. Trigger Internal Q4I Fulfillment Engine
                    $escrowService = new \App\Services\EscrowService();
                    $escrowService->lockEscrowFunds($escrow, $amountPaid);

                } else {
                    // Underpayment detected! Alert the buyer and freeze fulfillment.
                    $escrow->update(['status' => 'partially_paid']);
                    
                    $buyerPhoneFormatted = $this->formatPhoneForMeta($escrow->buyer_phone);
                    $this->sendMessage('whatsapp', $buyerPhoneFormatted, "⚠️ *Partial Payment Detected*\n\nWe received ₦" . number_format($amountPaid) . ", but your order total was ₦" . number_format($totalExpected) . ". Your order is currently on hold. Please contact Q4I support to resolve this.");
                }
                
                return response()->json(['status' => 'success', 'message' => 'State processed cleanly.']);
            }
            return response()->json(['status' => 'success', 'message' => 'Transaction was already logged.']);
        }
        
        \Illuminate\Support\Facades\Log::error('RexPay Webhook Ignored - Status not successful: ', $data);
        return response()->json(['status' => 'ignored', 'message' => 'Payment state returned failure code.']);
    }
}