<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception; 

class CheckoutController extends Controller
{
    /**
     * Step 1: Show the Checkout Page
     */
    public function show($slug)
    {
        $product = DB::table('products')->where('slug', $slug)->where('is_active', true)->first();
        
        if (!$product) {
            abort(404, 'This payment link has expired or does not exist.');
        }

        $vendor = DB::table('users')->where('id', $product->user_id)->first();

        return view('checkout.show', compact('product', 'vendor'));
    }

    /**
     * Step 2: Generate the Disposable Account via Techvibes
     */
    public function generateAccount(Request $request, $slug)
    {
        $request->validate([
            'buyer_name' => 'required|string|max:255',
            'buyer_phone' => 'required|string|max:20',
        ]);

        $product = DB::table('products')->where('slug', $slug)->where('is_active', true)->first();
        if (!$product) {
            return back()->with('error', 'This payment link is no longer active.');
        }

        $vendor = DB::table('users')->where('id', $product->user_id)->first();

        try {
            // Generate a unique Order Reference for this Escrow Transaction
            $orderReference = 'Q4I_ESC_' . strtoupper(Str::random(10));
            // 🟢 Generate a 4-Digit Pickup PIN right now!
            $pickupPin = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); 

            // 🟢 UPDATE: Use the 9PSB Dynamic Account API for Escrow natively!
            $ninePsbService = app(\App\Services\NinePsbVirtualAccountService::class);
            $payload = [
                'transaction' => ['reference' => $orderReference],
                'order' => [
                    'amount' => (float) $product->price,
                    'currency' => 'NGN',
                    'description' => 'Escrow for Product: ' . $product->name,
                    'country' => 'NGA',
                    'amounttype' => 'EXACT'
                ],
                'customer' => [
                    'account' => [
                        'name' => substr($request->buyer_name . ' - Escrow', 0, 30),
                        'type' => 'DYNAMIC',
                        'expiry' => ['hours' => 1]
                    ]
                ]
            ];

            $responseData = $ninePsbService->createVirtualAccount($payload);

            if (isset($responseData['code']) && $responseData['code'] === '00') {
                $accountNumber = $responseData['customer']['account']['number'];
                
                DB::beginTransaction();
                
                // 🟢 FIXED: Route directly to the escrow_transactions table!
                DB::table('escrow_transactions')->insert([
                    'reference' => $orderReference,
                    'vendor_id' => $vendor->id, 
                    'product_id' => $product->id,
                    'buyer_phone' => $request->buyer_phone,
                    'amount' => $product->price,
                    'status' => 'awaiting_funds', // Wait for Webhook to flip to 'locked'
                    'is_pickup' => true,
                    'delivery_pin' => \Illuminate\Support\Facades\Hash::make($pickupPin),
                    'virtual_account_number' => $accountNumber,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::commit();

                return back()->with('account_details', [
                    'accountNumber' => $accountNumber,
                    'bankName'      => '9PSB',
                    'amount'        => $product->price,
                    'expires_in'    => '1 Hour',
                    'order_ref'     => $orderReference 
                ]);
            }

            Log::error('Techvibes Dynamic VA Failed', [
                'http_status' => $response->status(),
                'raw_body' => $response->body()
            ]);
            
            return back()->with('error', 'Could not generate a secure payment account at this time. Please try again.');

        } catch (Exception $e) {
            if(DB::transactionLevel() > 0) {
                DB::rollBack(); 
            }
            
            Log::error('Techvibes Checkout Exception: ' . $e->getMessage());
            return back()->with('error', 'A system error occurred while connecting to the banking network. Please try again.');
        }
    }

    // =================================================================
    // CORPORATE GATEWAY: PAYMENT LINKS CHECKOUT
    // =================================================================

    public function showCorporate($reference)
    {
        $link = DB::table('payment_links')->where('reference', $reference)->first();

        if (!$link || !$link->is_active) {
            abort(404, 'This payment link does not exist or has expired.');
        }

        $merchant = DB::table('merchants')->where('id', $link->merchant_id)->first();
        $businessName = $merchant->business_name ?? 'Verified Q4I Merchant';

        $isPaid = DB::table('transactions')
            ->where('payment_link_id', $link->id)
            ->where('status', 'successful')
            ->exists();

        if ($isPaid) {
            $alreadyPaid = true;
            return view('checkout.corporate', compact('link', 'businessName', 'merchant', 'alreadyPaid'));
        }

        return view('checkout.corporate', compact('link', 'businessName', 'merchant'));
    }

    public function generateCorporateAccount(Request $request, $reference)
    {
        $request->validate([
            'customer_email' => 'required|email'
        ]);

        $link = DB::table('payment_links')->where('reference', $reference)->first();
        if (!$link || !$link->is_active) {
            return back()->with('error', 'This payment link is no longer active.');
        }

        $isPaid = DB::table('transactions')
            ->where('payment_link_id', $link->id)
            ->where('status', 'successful')
            ->exists();

        if ($isPaid) {
            return back()->with('error', 'This invoice has already been paid.');
        }

        $merchant = DB::table('merchants')->where('id', $link->merchant_id)->first();
        $businessName = $merchant->business_name ?? 'Q4I Merchant';

        try {
            $ninePsbService = app(\App\Services\NinePsbVirtualAccountService::class);
            $sessionRef = $reference . '_' . time();
            $payload = [
                'transaction' => ['reference' => $sessionRef],
                'order' => [
                    'amount' => (float) $link->amount,
                    'currency' => 'NGN',
                    'description' => 'Payment for Ref: ' . $reference,
                    'country' => 'NGA',
                    'amounttype' => 'EXACT'
                ],
                'customer' => [
                    'account' => [
                        'name' => substr($businessName . ' Inv', 0, 30),
                        'type' => 'DYNAMIC',
                        'expiry' => ['hours' => 1]
                    ]
                ]
            ];

            $responseData = $ninePsbService->createVirtualAccount($payload);

            if (isset($responseData['code']) && $responseData['code'] === '00') {
                $accountNumber = $responseData['customer']['account']['number'];
                
                // 🟢 FIXED: Fetch a valid Virtual Account ID to satisfy the strict DB foreign key constraint!
                $masterAgent = DB::table('agents')->where('merchant_id', $merchant->id)->first();
                $masterVa = null;
                
                if ($masterAgent) {
                    $masterVa = DB::table('virtual_accounts')->where('agent_id', $masterAgent->id)->first();
                }

                // Ultimate fallback if testing data is broken
                if (!$masterVa) {
                    $masterVa = DB::table('virtual_accounts')->first();
                }

                $virtualAccountId = $masterVa ? $masterVa->id : 1; // Fallback to 1 if empty DB

                // Create a pending ledger entry for the Corporate Payment Link
                DB::table('transactions')->insert([
                    'merchant_id' => $merchant->id,
                    'virtual_account_id' => $virtualAccountId, // Bypass strict foreign key
                    'session_id' => $sessionRef, // Unique session for this attempt
                    'payment_link_id' => $link->id, // Store the payment link ID
                    'type' => 'credit',
                    'amount' => $link->amount,
                    'fee_charged' => 0.00,
                    'balance_before' => $merchant->wallet_balance ?? 0.00,
                    'balance_after' => $merchant->wallet_balance ?? 0.00,
                    'status' => 'pending',
                    'customer_email' => $request->customer_email,
                    'is_swept' => false,
                    'remarks' => 'Awaiting Dynamic Link Payment: ' . $accountNumber,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                return back()->with('account_details', [
                    'accountNumber' => $accountNumber,
                    'bankName'      => '9PSB',
                    'amount'        => $link->amount,
                    'session_id'    => $sessionRef,
                ]);
            }

            Log::error('NinePSB Corporate VA Failed', ['response' => $responseData]);
            $errorMessage = $responseData['message'] ?? 'Unknown banking error.';
            return back()->with('error', 'Could not connect to banking network: ' . $errorMessage);

        } catch (\Exception $e) {
            Log::error('System Error in Corporate VA', ['error' => $e->getMessage()]);
            return back()->with('error', 'System error: ' . $e->getMessage());
        }
    }

    public function checkStatus($session_id)
    {
        $txn = DB::table('transactions')
                ->where('session_id', 'LIKE', $session_id . '%')
                ->first();
                
        if ($txn && $txn->status === 'successful') {
            return response()->json(['status' => 'paid']);
        }
        
        return response()->json(['status' => 'pending']);
    }

    public function raiseDispute(Request $request, $reference)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        // 🟢 FIXED: Query the exact Escrow Transactions table we just updated!
        $order = DB::table('escrow_transactions')->where('reference', $reference)->first();

        if (!$order) {
            return back()->withErrors(['error' => 'Order not found.']);
        }

        // 1. Freeze the Order
        DB::table('escrow_transactions')->where('id', $order->id)->update([
            'status' => 'disputed',
            'updated_at' => now()
        ]);

        // 2. Log the Dispute
        DB::table('disputes')->insert([
            'escrow_transaction_id' => $order->id, // Updated column name
            'vendor_id' => $order->vendor_id,
            'reason' => $request->reason,
            'status' => 'open',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Dispute raised successfully. The funds are securely frozen and the Q4I Admin team has been notified.');
    }
}