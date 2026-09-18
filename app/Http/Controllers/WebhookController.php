<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\VirtualAccount;
use App\Models\Transaction;
use App\Jobs\SendMerchantWebhook;

class WebhookController extends Controller
{
    // ==========================================
    // 1. MERCHANT SETTINGS (OUTBOUND CONFIG)
    // ==========================================
    
    public function index(Request $request)
    {
        $merchant = $request->user();

        // Auto-generate a secure signing secret if they don't have one
        if (!$merchant->webhook_secret) {
            $merchant->webhook_secret = 'whsec_q4i_' . Str::random(32);
            $merchant->save();
        }

        return view('merchant.webhooks.index', compact('merchant'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'live_webhook_url' => 'nullable|url',
            'test_webhook_url' => 'nullable|url',
        ]);

        $merchant = $request->user();

        // Write directly to the merchants table to bypass any Eloquent Model restrictions
        \Illuminate\Support\Facades\DB::table('merchants')
            ->where('id', $merchant->id)
            ->update([
                'live_webhook_url' => $validated['live_webhook_url'],
                'test_webhook_url' => $validated['test_webhook_url'],
            ]);

        return redirect()->back()->with('success', 'Webhook endpoints updated successfully. Your endpoints are now live.');
    }

    // ==========================================
    // 2. 9PSB RECEIVER (INBOUND MONEY)
    // ==========================================

    public function handleNinePsbWebhook(Request $request)
    {
        Log::channel('single')->info('WEBHOOK RECEIVED', $request->all());

        $validated = $request->validate([
            'accountNumber' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'sessionId' => 'required|string',
            'tranRemarks' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Check for duplicate transaction
            if (Transaction::where('session_id', $validated['sessionId'])->exists()) {
                return response()->json(['status' => 'success', 'message' => 'Transaction already processed'], 200);
            }

            // ==========================================
            // 🟢 NEW: ESCROW PAYMENT INTERCEPTOR
            // ==========================================
            // Note: If you saved checkout orders to 'orders' instead of 'escrow_transactions', change the table name below!
            $escrowOrder = DB::table('escrow_transactions') 
                ->where('disposable_account', $validated['accountNumber'])
                ->where('status', 'pending')
                ->first();

            if ($escrowOrder) {
                // Ensure the payment matches or exceeds the product price
                if ($validated['amount'] >= $escrowOrder->amount) {
                    
                    $deliveryPin = null;

                    // Generate the 4-digit PIN if it is a local pickup
                    // Adjust the column check depending on how you saved the pickup method at checkout
                    if (isset($escrowOrder->is_pickup) && $escrowOrder->is_pickup == true) {
                        $deliveryPin = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
                    }

                    // Lock the funds and save the PIN
                    DB::table('escrow_transactions')
                        ->where('id', $escrowOrder->id)
                        ->update([
                            'status' => 'locked',
                            'delivery_pin' => $deliveryPin,
                            'updated_at' => now(),
                        ]);

                    // Save the transaction record for the Escrow Payment
                    Transaction::create([
                        'session_id' => $validated['sessionId'],
                        'type' => 'credit',
                        'amount' => $validated['amount'],
                        'status' => 'successful',
                        'remarks' => 'Escrow Vault Lock: ' . $escrowOrder->order_ref,
                    ]);

                    DB::commit();

                    // ==========================================
// 🟢 WHATSAPP PIN DELIVERY (META CLOUD API)
// ==========================================

// Format the phone number to international standard (e.g., 080... becomes 23480...)
$buyerPhone = $escrowOrder->buyer_phone;
if (str_starts_with($buyerPhone, '0')) {
    $buyerPhone = '234' . ltrim($buyerPhone, '0');
}
// Strip out any plus signs or spaces
$buyerPhone = preg_replace('/[^0-9]/', '', $buyerPhone);

$metaToken = env('META_WA_TOKEN');
$phoneId = env('META_PHONE_ID');

// Construct the secure message
$waMessage = "🔒 *Q4I Escrow Secured*\n\n"
           . "Your funds (*₦" . number_format($escrowOrder->amount, 2) . "*) are safely locked in the Q4I Vault.\n\n"
           . "Your Secure Pickup PIN is: *{$deliveryPin}*\n\n"
           . "⚠️ *CRITICAL:* Only give this PIN to the vendor AFTER you have inspected and received your item.";

try {
    // Send standard text message (Requires an active 24-hour chat window with the user)
    $waResponse = \Illuminate\Support\Facades\Http::withToken($metaToken)
        ->post("https://graph.facebook.com/v25.0/{$phoneId}/messages", [
            'messaging_product' => 'whatsapp',
            'to' => $buyerPhone,
            'type' => 'text',
            'text' => [
                'body' => $waMessage
            ]
        ]);

    if (!$waResponse->successful()) {
        Log::error("WhatsApp PIN Delivery Failed for Order {$escrowOrder->id}", ['response' => $waResponse->json()]);
    } else {
        Log::info("Escrow Locked & PIN Delivered via WhatsApp for Order {$escrowOrder->id}");
    }
} catch (\Exception $e) {
    // We catch this so a WhatsApp failure doesn't crash the actual money transfer
    Log::error("Meta API Exception: " . $e->getMessage());
}

                    return response()->json(['status' => 'success', 'message' => 'Escrow locked successfully'], 200);
                }
            }


            // ==========================================
            // 🟡 EXISTING: CORPORATE WALLET LOGIC
            // ==========================================
            $account = VirtualAccount::with('agent.merchant')->where('account_number', $validated['accountNumber'])->first();

            if (!$account) {
                Log::error('Webhook Rejected: Account not found', ['account' => $validated['accountNumber']]);
                return response()->json(['status' => 'error', 'message' => 'Account not found'], 404);
            }

            $isQuarantined = false;
            $transactionStatus = 'successful';
            $newBalance = $account->ledger_balance + $validated['amount'];

            if ($account->wallet_status !== 'active' || $newBalance > $account->max_balance_limit) {
                $isQuarantined = true;
                $transactionStatus = 'quarantined'; 
                
                Log::warning('Funds Quarantined: Limit Exceeded or Wallet Inactive', [
                    'account' => $account->account_number, 
                    'amount' => $validated['amount']
                ]);
                
                $account->update(['wallet_status' => 'restricted_pending_kyc']);
            }

            $merchant = $account->agent->merchant;
            $q4iFee = $merchant->inbound_flat_fee; 
            
            if ($validated['amount'] <= $q4iFee) {
                $q4iFee = $validated['amount']; 
            }
            
            $settledAmount = $validated['amount'] - $q4iFee; 

            $transaction = Transaction::create([
                'virtual_account_id' => $account->id,
                'merchant_id' => $merchant->id,
                'session_id' => $validated['sessionId'],
                'type' => 'credit',
                'amount' => $validated['amount'],
                'fee_charged' => $q4iFee,               
                'settled_amount' => $settledAmount,     
                'balance_before' => $account->ledger_balance,
                'balance_after' => $isQuarantined ? $account->ledger_balance : ($account->ledger_balance + $settledAmount), 
                'status' => $transactionStatus,
                'remarks' => $validated['tranRemarks'] ?? 'Inbound Transfer',
            ]);

            if (!$isQuarantined) {
                $account->update(['ledger_balance' => $account->ledger_balance + $settledAmount]);
                $merchant->update(['wallet_balance' => $merchant->wallet_balance + $settledAmount]);
            }

            DB::commit();

            // Fire the Outbound Webhook Job to the Merchant
            try {
                SendMerchantWebhook::dispatch($transaction);
            } catch (\Exception $e) {
                Log::error('Failed to dispatch webhook job: ' . $e->getMessage());
            }

            return response()->json(['status' => 'success', 'message' => 'Webhook processed successfully'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Webhook Crash: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
        }
    }
}
