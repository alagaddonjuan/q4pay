<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Merchant;
use Illuminate\Support\Facades\DB;
use App\Models\VirtualAccount;
use App\Models\Transaction;
use App\Jobs\SendPayoutWebhook;
use Illuminate\Support\Facades\Hash; // <--- ADDED HASH FACADE FOR PIN

class PayoutController extends Controller
{

    // 1. Fetch the NIBSS Bank List
    public function getBanks(Request $request)
    {
        $merchant = $request->_merchant;

        $query = $request->input('query', '');

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
                'token' => env('TECHVIBES_LIVE_TOKEN') 
            ])->post('https://techvibs.com/bank/api_general/bankList_general_local_db_token_api.php', [
                'query' => $query
            ]);

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            Log::error('Q4I Bank List Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to connect to NIBSS network'], 500);
        }
    }

    // 2. Resolve Account Name (Name Enquiry)
    public function resolveAccount(Request $request)
    {
        $merchant = $request->_merchant;

        $validated = $request->validate([
            'account_number' => 'required|string|size:10',
            'bank_code' => 'required|string'
        ]);

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
                'X-Fintech-Token' => env('TECHVIBES_LIVE_TOKEN') 
            ])->post('https://techvibs.com/waas9/validate_destination_account_external_fintech_token.php', [
                'account_number' => $validated['account_number'],
                'bank_code' => $validated['bank_code']
            ]);

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            Log::error('Q4I Name Enquiry Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to resolve account on NIBSS network'], 500);
        }
    }

   // 3. Process Outward Transfer (Payout)
    public function processPayout(Request $request)
    {
        $merchant = $request->_merchant;

        // Validate Request (Added PIN)
        $validated = $request->validate([
            'sourceAccountNumber' => 'required|string',
            'destinationAccountNumber' => 'required|string|size:10',
            'destinationBankCode' => 'required|string',
            'destinationAccountName' => 'required|string',
            'amount' => 'required|numeric|min:100',
            'narration' => 'nullable|string',
            'pin' => 'required|digits:4' // <--- REQUIRED PIN
        ]);

        // ==========================================
        // THE PIN SHIELD
        // ==========================================
        if (!$merchant->transaction_pin) {
            return response()->json(['error' => 'Please set a Transaction PIN in your settings before moving funds.'], 403);
        }
        if (!Hash::check($validated['pin'], $merchant->transaction_pin)) {
            return response()->json(['error' => 'Invalid Transaction PIN.'], 401);
        }
        // ==========================================

        $account = \App\Models\VirtualAccount::where('account_number', $validated['sourceAccountNumber'])
            ->whereHas('agent', function($q) use ($merchant) {
                $q->where('merchant_id', $merchant->id);
            })->first();

        if (!$account) {
            return response()->json(['error' => 'Invalid source account number or unauthorized'], 404);
        }

        // ==========================================
        // Q4I COMMISSION ENGINE (OUTFLOW)
        // ==========================================
        $payoutAmount = $validated['amount'];
        $q4iFee = 100.00; // Flat fee charged to merchant
        $techvibsCost = 13.00; // Cost paid by Q4I to provider
        $q4iProfit = $q4iFee - $techvibsCost; // N87 Net Profit
        
        $totalDeduction = $payoutAmount + $q4iFee;

        if ($account->ledger_balance < $totalDeduction) {
            return response()->json([
                'error' => 'Insufficient funds.', 
                'message' => "Balance must cover: Transfer (₦{$payoutAmount}) + Platform Fee (₦{$q4iFee}) = ₦{$totalDeduction}"
            ], 400);
        }

        $txnRef = 'Q4I-OUT-' . time() . '-' . rand(1000, 9999);

        // 5. LOCK THE FUNDS (Pending State)
        DB::beginTransaction();
        try {
            $account->update(['ledger_balance' => $account->ledger_balance - $totalDeduction]);
            $merchant->update(['wallet_balance' => $merchant->wallet_balance - $totalDeduction]);

            $transaction = \App\Models\Transaction::create([
                'virtual_account_id' => $account->id,
                'merchant_id' => $merchant->id,
                'session_id' => $txnRef,
                'type' => 'debit',
                'amount' => $payoutAmount,
                'fee_charged' => $q4iFee,
                'bank_fee' => $techvibsCost, // Log provider cost for auditing
                'settled_amount' => $totalDeduction, 
                'balance_before' => $account->ledger_balance + $totalDeduction,
                'balance_after' => $account->ledger_balance,
                'status' => 'pending', 
                'remarks' => $validated['narration'] ?? 'Outward Transfer'
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Database error locking funds: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Database Error locking funds'], 500);
        }

        // 6. CALL THE TECHVIBES BANKING NETWORK
        try {
            // Using your master FinTech Token to execute the transfer
            $activeToken = env('TECHVIBES_LIVE_TOKEN'); 
            
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $activeToken
                ])
                ->post('https://techvibs.com/waas9/transfer_external_fintech_token.php', [
                    'token' => $activeToken,
                    'transactionReference' => $txnRef,
                    'sourceAccountNumber' => $validated['sourceAccountNumber'],
                    'destinationAccountNumber' => $validated['destinationAccountNumber'],
                    'destinationBankCode' => $validated['destinationBankCode'],
                    'destinationAccountName' => $validated['destinationAccountName'],
                    'senderName' => $account->account_name ?? $merchant->business_name,
                    'amount' => $payoutAmount,
                    'currency' => 'NGN',
                    'narration' => $validated['narration'] ?? 'Q4I Payout',
                    'description' => 'Transfer payment'
                ]);

            $apiResult = $response->json();

            // Check if TechVibes returned an error
            if (!$response->successful() || (isset($apiResult['success']) && $apiResult['success'] === false)) {
                $errorData = $apiResult['data'] ?? $apiResult;
                $errorMessage = $errorData['error'] ?? $errorData['message'] ?? 'Unknown error from banking network';
                
                // Triggers your auto-reversal method
                return $this->reverseTransaction(
                    $transaction, 
                    $account, 
                    $merchant, 
                    $totalDeduction, 
                    $errorMessage, 
                    $apiResult,
                    $response->status()
                );
            }

            // 7. HANDLE SUCCESS RESPONSE & LOG PROFIT
            if (isset($apiResult['success']) && $apiResult['success'] === true) {
                
                DB::beginTransaction();
                try {
                    $transaction->update(['status' => 'successful']);
                    
                    // 🟢 LOG Q4I NET PROFIT ONLY ON SUCCESS
                    DB::table('system_earnings')->insert([
                        'transaction_ref' => $txnRef,
                        'merchant_id' => $merchant->id,
                        'type' => 'outflow_profit',
                        'amount' => $q4iProfit, // Logs exactly ₦87
                        'created_at' => now()
                    ]);
                    
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Failed to log profit on successful transfer: ' . $e->getMessage());
                }

                \App\Jobs\SendPayoutWebhook::dispatch($transaction);
                
                return response()->json([
                    'status' => 'success',
                    'message' => $apiResult['data']['message'] ?? 'Transfer processed successfully',
                    'data' => [
                        'reference' => $txnRef,
                        'techvibes_reference' => $apiResult['data']['reference'] ?? null,
                        'amount_sent' => $payoutAmount,
                        'platform_fee' => $q4iFee,
                        'total_deducted' => $totalDeduction,
                        'new_balance' => $account->ledger_balance,
                        'processor' => $apiResult['data']['processor'] ?? 'waas9',
                        'transfer_details' => $apiResult['data']['transfer_details'] ?? null
                    ]
                ], 200);
            }

            throw new \Exception('Unexpected response format from banking network');

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Techvibes Connection Timeout: ' . $e->getMessage());
            return response()->json([
                'status' => 'pending',
                'message' => 'Transfer is processing. Network timeout occurred - please verify status later.',
                'reference' => $txnRef,
                'action_required' => 'Use getTransactionStatus endpoint to verify final status'
            ], 202);
            
        } catch (\Exception $e) {
            Log::error('Techvibes Transfer Exception: ' . $e->getMessage());
            return $this->reverseTransaction(
                $transaction, 
                $account, 
                $merchant, 
                $totalDeduction, 
                'Transfer processing error: ' . $e->getMessage(), 
                null,
                500
            );
        }
    }

    /**
     * Auto-reverse transaction funds on explicit failure
     */
    private function reverseTransaction($transaction, $account, $merchant, $totalDeduction, $reason, $apiResult = null, $originalHttpCode = 400)
    {
        DB::beginTransaction();
        try {
            $account->update(['ledger_balance' => $account->ledger_balance + $totalDeduction]);
            $merchant->update(['wallet_balance' => $merchant->wallet_balance + $totalDeduction]);
            
            $transaction->update([
                'status' => 'failed',
                'balance_after' => $account->ledger_balance,
                'remarks' => 'Failed/Refunded: ' . substr($reason, 0, 200) 
            ]);
            
            DB::commit();
            \App\Jobs\SendPayoutWebhook::dispatch($transaction);
            
            $response = [
                'status' => 'error',
                'message' => 'Transfer failed. Funds have been refunded.',
                'reference' => $transaction->session_id,
                'refund_amount' => $totalDeduction,
                'reason' => $reason,
                'refunded' => true
            ];
            
            if ($apiResult && isset($apiResult['data'])) {
                $errorData = $apiResult['data'];
                
                if (isset($errorData['tier_details'])) {
                    $response['tier_details'] = $errorData['tier_details'];
                    $response['action_required'] = $errorData['action_required'] ?? null;
                    $response['available_tiers'] = $errorData['available_tiers'] ?? null;
                }
                
                if (isset($errorData['transfer_amount'])) {
                    $response['transfer_amount'] = $errorData['transfer_amount'];
                    $response['tier_limit'] = $errorData['tier_limit'] ?? null;
                    $response['daily_limit'] = $errorData['daily_limit'] ?? null;
                    $response['today_total'] = $errorData['today_total'] ?? null;
                    $response['remaining'] = $errorData['remaining'] ?? null;
                }
                
                if (isset($errorData['current_balance'])) {
                    $response['current_balance'] = $errorData['current_balance'];
                    $response['transfer_amount'] = $errorData['transfer_amount'] ?? $transaction->amount;
                    $response['fee'] = $errorData['fee'] ?? null;
                    $response['total_required'] = $errorData['total_required'] ?? null;
                }
                
                if (isset($errorData['support_action'])) {
                    $response['support_action'] = $errorData['support_action'];
                    $response['account_number'] = $errorData['account_number'] ?? null;
                }
                
                $response['original_error'] = $errorData;
            }
            
            $httpCode = $originalHttpCode;
            if (str_contains($reason, 'tier') || str_contains($reason, 'limit')) {
                $httpCode = 403;
            } elseif (str_contains($reason, 'Authentication') || str_contains($reason, 'Unauthorized')) {
                $httpCode = 401;
            } elseif (str_contains($reason, 'configuration') || str_contains($reason, 'incomplete')) {
                $httpCode = 500;
            }
            
            return response()->json($response, $httpCode);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CRITICAL: Auto-reversal failed: ' . $e->getMessage());
            \App\Jobs\SendPayoutWebhook::dispatch($transaction);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Transfer failed and refund encountered an error.',
                'reference' => $transaction->session_id,
                'system_error' => $e->getMessage()
            ], 500);
        }
    }

    // 4. Transaction Requery (Check Status)
    public function getTransactionStatus(Request $request, $sessionId)
    {
        $merchant = $request->_merchant;

        $transaction = \App\Models\Transaction::where('session_id', $sessionId)
            ->where('merchant_id', $merchant->id)
            ->first();

        if (!$transaction) return response()->json(['status' => 'error', 'message' => 'Transaction not found.'], 404);

        return response()->json([
            'status' => 'success',
            'data' => [
                'reference' => $transaction->session_id,
                'type' => $transaction->type,
                'amount' => $transaction->amount,
                'platform_fee' => $transaction->fee_charged,
                'total_deducted' => $transaction->settled_amount,
                'transaction_status' => $transaction->status,
                'remarks' => $transaction->remarks,
                'created_at' => $transaction->created_at,
            ]
        ], 200);
    }

    public function processInternalTransfer(Request $request)
    {
        $merchant = $request->_merchant;

        $validated = $request->validate([
            'source_account' => 'required|string',
            'destination_account' => 'required|string|different:source_account',
            'amount' => 'required|numeric|min:1',
            'remarks' => 'nullable|string',
            'pin' => 'required|digits:4'
        ]);

        // 2. THE PIN SHIELD: Check if they even have a PIN set
        if (!$merchant->transaction_pin) {
            return response()->json(['error' => 'Please set a Transaction PIN in your settings before moving funds.'], 403);
        }

        // 3. Verify the PIN mathematically matches the hash in the database
        if (!Hash::check($validated['pin'], $merchant->transaction_pin)) {
            return response()->json(['error' => 'Invalid Transaction PIN.'], 401);
        }

        $amount = $validated['amount'];

        // 1. Verify Sender (Must belong to the logged-in Merchant)
        $sourceAccount = VirtualAccount::where('account_number', $validated['source_account'])
            ->whereHas('agent', function($q) use ($merchant) {
                $q->where('merchant_id', $merchant->id);
            })->first();

        if (!$sourceAccount || $sourceAccount->ledger_balance < $amount) {
            return response()->json(['error' => 'Invalid source account or insufficient funds.'], 400);
        }

        // 2. Verify Receiver (Can be ANY virtual account in the Q4I system)
        $destinationAccount = VirtualAccount::with('agent.merchant')->where('account_number', $validated['destination_account'])->first();

        if (!$destinationAccount) {
            return response()->json(['error' => 'Destination Q4I account not found.'], 404);
        }

        $destinationMerchant = $destinationAccount->agent->merchant;

        // 3. THE LEDGER ENGINE (Double-Entry Accounting)
        DB::beginTransaction();
        try {
            // A. Debit the Sender
            $sourceAccount->decrement('ledger_balance', $amount);
            $merchant->decrement('wallet_balance', $amount);

            $debitTxn = Transaction::create([
                'virtual_account_id' => $sourceAccount->id,
                'merchant_id' => $merchant->id,
                'session_id' => 'Q4I-INT-OUT-' . time() . '-' . rand(1000, 9999),
                'type' => 'debit',
                'amount' => $amount,
                'fee_charged' => 0, // ZERO FEE!
                'settled_amount' => $amount,
                'balance_before' => $sourceAccount->ledger_balance + $amount,
                'balance_after' => $sourceAccount->ledger_balance,
                'status' => 'successful',
                'remarks' => $validated['remarks'] ?? 'Internal Transfer Out'
            ]);

            // B. Credit the Receiver
            $destinationAccount->increment('ledger_balance', $amount);
            $destinationMerchant->increment('wallet_balance', $amount);

            $creditTxn = Transaction::create([
                'virtual_account_id' => $destinationAccount->id,
                'merchant_id' => $destinationMerchant->id,
                'session_id' => 'Q4I-INT-IN-' . time() . '-' . rand(1000, 9999),
                'type' => 'credit',
                'amount' => $amount,
                'fee_charged' => 0,
                'settled_amount' => $amount,
                'balance_before' => $destinationAccount->ledger_balance - $amount,
                'balance_after' => $destinationAccount->ledger_balance,
                'status' => 'successful',
                'remarks' => $validated['remarks'] ?? 'Internal Transfer In'
            ]);

            DB::commit();

            // 4. Alert the Receiver's Server that money has arrived!
            \App\Jobs\SendMerchantWebhook::dispatch($creditTxn);

            return response()->json([
                'status' => 'success',
                'message' => 'Internal transfer successful.',
                'data' => [
                    'reference' => $debitTxn->session_id,
                    'amount' => $amount,
                    'destination_account' => $destinationAccount->account_number,
                    'source_new_balance' => $sourceAccount->ledger_balance
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Transfer failed due to system error.'], 500);
        }
    }
}