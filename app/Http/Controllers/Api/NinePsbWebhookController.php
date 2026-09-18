<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\VirtualAccount;
use App\Models\Agent;
use App\Services\NinePsbVirtualAccountService;
use App\Services\FeeCalculationService;

class NinePsbWebhookController extends Controller
{
    protected FeeCalculationService $feeService;

    public function __construct(FeeCalculationService $feeService)
    {
        $this->feeService = $feeService;
    }

    /**
     * Universal Webhook Listener for Incoming Payments & Commission Engine from 9PSB
     */
    public function handleWebhook(Request $request)
    {
        // 1. Log the exact payload from 9PSB
        Log::info('9PSB Webhook Received:', $request->all());

        // 2. Validate Authentication Hash
        $payload = $request->getContent();
        $authHeader = $request->header('auth');

        $publicKey = env('NINEPSB_WAAS_PUBLIC_KEY');
        $privateKey = env('NINEPSB_WAAS_PRIVATE_KEY');

        // Re-generate hash
        $expectedHash = hash('sha512', $publicKey . $privateKey . $payload);

        // Optional: enable strict hash validation
        // if ($authHeader !== $expectedHash) {
        //     Log::warning('9PSB Webhook Hash Mismatch', ['expected' => $expectedHash, 'received' => $authHeader]);
        //     // Return 401 Unauthorized depending on strictness
        //     // return response()->json(['message' => 'Unauthorized'], 401); 
        // }

        $data = json_decode($payload, true);

        if (!$data || !isset($data['transaction'])) {
            return response()->json(['message' => 'Invalid payload format'], 400);
        }

        // 3. Extract the data
        $orderRef = $data['transaction']['reference'] ?? null;
        $amountPaid = isset($data['order']['amount']) ? (float) $data['order']['amount'] : 0;
        $destAccountNumber = $data['customer']['account']['number'] ?? null;
        $sessionID = $data['source']['account']['sessionid'] ?? 'Q4I_TXN_' . strtoupper(Str::random(12));

        // Fee calculation will be performed inside each path, once the merchant is identified.

        // 4. Secure the Database update
        DB::beginTransaction();

        try {
            // ==========================================
            // PATH A: DIRECT VIRTUAL ACCOUNT DEPOSIT (By Account Number)
            // ==========================================
            $virtualAccount = null;
            if ($destAccountNumber) {
                $virtualAccount = VirtualAccount::where('account_number', $destAccountNumber)->first();
            }

            if ($virtualAccount) {
                $agent = Agent::find($virtualAccount->agent_id);
                $merchant = DB::table('merchants')->where('id', $agent->merchant_id)->first();
                
                if (!$merchant) {
                    DB::rollBack();
                    Log::error('Webhook Error: Virtual account agent has no corresponding merchant profile.');
                    return response()->json(['message' => 'Merchant profile not found'], 400);
                }

                $merchantModel = \App\Models\Merchant::find($merchant->id);
                
                // --- Q4I COMMISSION RULES (INFLOW) ---
                $feeDetails = $this->feeService->calculateFee($merchantModel, 'inflow_transfer', $amountPaid);
                $merchantNet = $feeDetails['settled_amount'];
                $q4iFee = $feeDetails['fee_charged'];
                $systemProfit = $feeDetails['system_profit'];

                // Prevent negative balances if someone deposits less than fee
                if ($amountPaid <= $q4iFee) {
                    $q4iFee = $amountPaid;
                    $merchantNet = 0;
                    $systemProfit = $amountPaid; // Take whatever is there as profit
                }

                $balanceBefore = $merchant->wallet_balance ?? 0;
                $balanceAfter = $balanceBefore + $merchantNet; // ADD ONLY THE NET AMOUNT

                // Insert into Transactions Ledger
                DB::table('transactions')->insert([
                    'merchant_id' => $agent->merchant_id,
                    'virtual_account_id' => $virtualAccount->id, 
                    'type' => 'credit',
                    'amount' => $merchantNet,       // What the merchant gets
                    'fee_charged' => $q4iFee,       // What Q4I takes
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'session_id' => $sessionID,
                    'status' => 'successful',
                    'remarks' => 'VA Deposit via 9PSB (Net of ₦50 Fee)',
                    'is_swept' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Top up Merchant's Balance
                DB::table('merchants')->where('id', $agent->merchant_id)->update(['wallet_balance' => $balanceAfter]);

                // 🟢 LOG Q4I PROFIT
                if ($systemProfit > 0) {
                    $this->feeService->recordSystemProfit($sessionID, $merchantModel, 'inflow_fee', $systemProfit);
                }

                // 🟢 DISPATCH WEBHOOK TO MERCHANT
                $webhookPayload = [
                    'reference' => $sessionID,
                    'amount' => $amountPaid,
                    'status' => 'successful',
                    'customer' => [
                        'account_number' => $destAccountNumber
                    ]
                ];
                \App\Jobs\DispatchMerchantWebhookJob::dispatch($merchantModel->id, 'transaction.successful', $webhookPayload);

                DB::commit();
                return response()->json(['message' => 'Virtual Account Webhook processed successfully'], 200);
            }

            // ==========================================
            // PATH B: ESCROW PAYMENT (DYNAMIC ACCOUNT)
            // ==========================================
            if ($destAccountNumber) {
                $pendingOrder = DB::table('escrow_transactions')
                    ->where('virtual_account_number', $destAccountNumber)
                    ->where('status', 'awaiting_funds')
                    ->first(); 
                
                if ($pendingOrder) {
                    $vendor = DB::table('users')->where('id', $pendingOrder->vendor_id)->first();
                    
                    if ($vendor) {
                        // Lock the funds in Escrow using EscrowService
                        $escrowModel = \App\Models\EscrowTransaction::find($pendingOrder->id);
                        if ($escrowModel) {
                            $escrowService = new \App\Services\EscrowService();
                            $escrowService->lockEscrowFunds($escrowModel, $amountPaid);
                        }

                        DB::commit();
                        return response()->json(['message' => 'Escrow Webhook processed successfully'], 200);
                    }
                }
            }

            // ==========================================
            // PATH C: CORPORATE GATEWAY (DYNAMIC PAYMENT LINKS)
            // ==========================================
            if ($orderRef) {
                // Find the pending transaction created by CheckoutController
                $pendingTxn = DB::table('transactions')
                    ->where('session_id', 'LIKE', $orderRef . '%') // Use LIKE to match testing and production variations
                    ->where('status', 'pending')
                    ->first();
                
                // Fallback: Try finding by account number in remarks if reference didn't match
                if (!$pendingTxn && $destAccountNumber) {
                    $pendingTxn = DB::table('transactions')
                        ->where('remarks', 'LIKE', '%Awaiting Dynamic Link Payment: ' . $destAccountNumber . '%')
                        ->where('status', 'pending')
                        ->first();
                }

                if ($pendingTxn) {
                    
                    // Top up Merchant's Master Balance
                    $merchantModel = \App\Models\Merchant::find($pendingTxn->merchant_id);
                    
                    // --- Q4I COMMISSION RULES (CORPORATE LINK) ---
                    $feeDetails = $this->feeService->calculateFee($merchantModel, 'inflow_transfer', $amountPaid);
                    $merchantNet = $feeDetails['settled_amount'];
                    $q4iFee = $feeDetails['fee_charged'];
                    $systemProfit = $feeDetails['system_profit'];

                    // Prevent negative balances if someone deposits less than fee
                    if ($amountPaid <= $q4iFee) {
                        $q4iFee = $amountPaid;
                        $merchantNet = 0;
                        $systemProfit = $amountPaid;
                    }

                    $balanceBefore = $merchantModel->wallet_balance ?? 0;
                    $balanceAfter = $balanceBefore + $merchantNet; 

                    // Update the pending transaction to success
                    DB::table('transactions')->where('id', $pendingTxn->id)->update([
                        'amount' => $merchantNet,
                        'fee_charged' => $q4iFee,
                        'balance_before' => $balanceBefore,
                        'balance_after' => $balanceAfter,
                        'status' => 'successful',
                        'remarks' => 'Corporate Link Payment Successful (Ref: ' . $pendingTxn->session_id . ')',
                        'updated_at' => now(),
                    ]);

                    // Top up Merchant's Master Balance
                    DB::table('merchants')->where('id', $merchantModel->id)->update(['wallet_balance' => $balanceAfter]);
                    
                    // 🟢 LOG Q4I PROFIT
                    if ($systemProfit > 0) {
                        $this->feeService->recordSystemProfit($pendingTxn->session_id, $merchantModel, 'inflow_fee', $systemProfit);
                    }

                    // 🟢 SEND NOTIFICATIONS & EMAILS
                    // Re-fetch the updated transaction
                    $updatedTxn = DB::table('transactions')->where('id', $pendingTxn->id)->first();
                    
                    try {
                        if (!empty($updatedTxn->customer_email)) {
                            \Illuminate\Support\Facades\Mail::to($updatedTxn->customer_email)->send(new \App\Mail\PaymentReceiptToCustomer($updatedTxn, $merchantModel->business_name));
                        }

                        if (!empty($merchantModel->contact_email)) {
                            \Illuminate\Support\Facades\Mail::to($merchantModel->contact_email)->send(new \App\Mail\PaymentReceivedToMerchant($updatedTxn, $merchantModel->business_name));
                        }

                        $merchantModel->notify(new \App\Notifications\PaymentReceivedNotification($updatedTxn));
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Failed to send webhook notifications: ' . $e->getMessage());
                        // We do not throw here, so the DB transaction still commits successfully.
                    }

                    // 🟢 DISPATCH WEBHOOK TO MERCHANT
                    $webhookPayload = [
                        'reference' => $updatedTxn->session_id,
                        'payment_link_id' => $updatedTxn->payment_link_id,
                        'amount' => $amountPaid,
                        'status' => 'successful',
                        'customer' => [
                            'email' => $updatedTxn->customer_email
                        ]
                    ];
                    \App\Jobs\DispatchMerchantWebhookJob::dispatch($merchantModel->id, 'transaction.successful', $webhookPayload);

                    DB::commit();
                    return response()->json(['message' => 'Corporate Payment Link Webhook processed successfully'], 200);
                }
            }

            // Reference does not exist inside system
            DB::rollBack();
            Log::warning('9PSB Webhook: Virtual account not found for account number: ' . $destAccountNumber);
            return response()->json(['message' => 'Virtual Account not found in Q4I DB'], 200); 

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('9PSB Webhook Processing Failed: ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in ' . $e->getFile());
            return response()->json([
                'error' => 'Internal Server Error processing webhook', 
                'details' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }
}
