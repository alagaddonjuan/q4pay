<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VirtualAccount;
use App\Models\Transaction;
use App\Services\NinePsbVasService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class BettingController extends Controller
{
    protected NinePsbVasService $vasService;
    private $bettingCategoryId = "2"; // Assumption for Betting category

    public function __construct(NinePsbVasService $vasService)
    {
        $this->vasService = $vasService;
        $this->bettingCategoryId = "2"; // 2 is betting, 1 is electricity, 4 is TV
    }

    private function calculateBettingProfit($amount)
    {
        $percentage = 0.015; // 1.5% example
        return $amount * $percentage;
    }

    public function verifyCustomer(Request $request)
    {
        $merchant = $request->user();

        $validated = $request->validate([
            'customer_id' => 'required|string',
            'provider' => 'required|string',
        ]);

        try {
            // Note: Some billers require itemId or amount for validation in 9psb, but betting usually only needs customer ID and Biller ID.
            $apiResult = $this->vasService->validateBiller(
                $validated['customer_id'],
                $validated['provider']
            );

            Log::info('9PSB Betting Verify Response:', (array)$apiResult);

            if (isset($apiResult['status']) && $apiResult['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'customer_name' => $apiResult['data']['customerName'] ?? 'Verified Customer',
                        'customer_id' => $validated['customer_id'],
                        'provider' => $validated['provider'],
                        'other_field' => $apiResult['data']['otherField'] ?? '' 
                    ]
                ], 200);
            }

            $errorMessage = $apiResult['message'] ?? 'Unknown API Error';
            
            return response()->json([
                'error' => $errorMessage,
                'raw_response' => $apiResult
            ], 400);

        } catch (\Exception $e) {
            Log::error('Betting Verification Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Network Exception: ' . $e->getMessage(),
                'raw_response' => null
            ], 500);
        }
    }

    public function fundWallet(Request $request)
    {
        $merchant = $request->user();

        $validated = $request->validate([
            'customer_id' => 'required|string',
            'provider' => 'required|string',
            'amount' => 'required|numeric|min:100',
            'sourceAccountNumber' => 'required|string',
            'pin' => 'required|digits:4',
            'other_field' => 'nullable|string' 
        ]);

        if (!$merchant->transaction_pin) {
            return response()->json(['error' => 'Please set a Transaction PIN in your settings.'], 403);
        }
        if (!Hash::check($validated['pin'], $merchant->transaction_pin)) {
            return response()->json(['error' => 'Invalid Transaction PIN.'], 401);
        }

        $fundingAmount = $validated['amount'];
        $q4iFee = 50; 
        $providerCommission = $this->calculateBettingProfit($fundingAmount);
        $totalProfit = $q4iFee + $providerCommission;

        $totalDeduction = $fundingAmount + $q4iFee;

        $account = VirtualAccount::where('account_number', $validated['sourceAccountNumber'])
            ->whereHas('agent', function($q) use ($merchant) {
                $q->where('merchant_id', $merchant->id);
            })->first();

        // 🟢 GLOBAL BALANCE PROTECTION
        if (!$account || $account->ledger_balance < $totalDeduction || $merchant->wallet_balance < $totalDeduction) {
            return response()->json(['error' => 'Insufficient funds in virtual account or merchant wallet.'], 400);
        }

        $txnRef = 'Q4I-BET-' . time() . '-' . rand(1000, 9999);

        // LOCK FUNDS
        DB::beginTransaction();
        try {
            $account->decrement('ledger_balance', $totalDeduction);
            $merchant->decrement('wallet_balance', $totalDeduction);

            $transaction = Transaction::create([
                'virtual_account_id' => $account->id,
                'merchant_id' => $merchant->id,
                'session_id' => $txnRef,
                'type' => 'debit',
                'amount' => $fundingAmount,
                'fee_charged' => $q4iFee,
                'settled_amount' => $totalDeduction,
                'balance_before' => $account->ledger_balance + $totalDeduction,
                'balance_after' => $account->ledger_balance,
                'status' => 'pending', 
                'remarks' => "Betting Deposit: {$validated['provider']} - {$validated['customer_id']}"
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Database Error locking funds.'], 500);
        }

        // CALL API
        try {
            $payload = [
                'customerId' => $validated['customer_id'],
                'billerId' => $validated['provider'],
                'customerPhone' => '08000000000',
                'customerName' => 'Betting User',
                'otherField' => $validated['other_field'] ?? 'Betting Wallet Funding',
                'debitAccount' => $validated['sourceAccountNumber'],
                'amount' => (string)$fundingAmount,
                'transactionReference' => $txnRef,
            ];

            $apiResult = $this->vasService->payBill($payload);

            if (!isset($apiResult['status']) || $apiResult['status'] !== 'success') {
                // Auto-reverse
                $account->increment('ledger_balance', $totalDeduction);
                $merchant->increment('wallet_balance', $totalDeduction);
                $transaction->update(['status' => 'failed', 'remarks' => 'Provider failed. Refunded.']);
                
                return response()->json(['error' => $apiResult['message'] ?? 'Funding failed. Funds refunded.'], 400);
            }

            DB::beginTransaction();
            try {
                $transaction->update(['status' => 'successful']);

                if ($totalProfit > 0) {
                    DB::table('system_earnings')->insert([
                        'transaction_ref' => $txnRef,
                        'merchant_id' => $merchant->id,
                        'type' => 'betting_funding_profit',
                        'amount' => $totalProfit,
                        'created_at' => now()
                    ]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to log Betting Profit: ' . $e->getMessage());
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Betting wallet funded successfully.',
                'data' => [
                    'reference' => $txnRef,
                    'customer_id' => $validated['customer_id'],
                    'provider' => $validated['provider'],
                    'amount_funded' => $fundingAmount,
                    'platform_fee' => $q4iFee,
                    'new_balance' => $account->ledger_balance
                ]
            ], 200);

        } catch (\Exception $e) {
            $account->increment('ledger_balance', $totalDeduction);
            $merchant->increment('wallet_balance', $totalDeduction);
            $transaction->update(['status' => 'failed', 'remarks' => 'Timeout. Refunded.']);
            return response()->json(['error' => 'Service timeout. Funds refunded.'], 500);
        }
    }

    public function getProviders(Request $request)
    {
        try {
            $response = $this->vasService->getCategoryBillers($this->bettingCategoryId);
            
            // If the provider fails or returns empty, give a fallback list so the UI still works.
            if (!isset($response['status']) || $response['status'] !== 'success' || empty($response['data'])) {
                $fallback = [
                    ['biller_id' => 'sportybet', 'biller_name' => 'SportyBet'],
                    ['biller_id' => 'bet9ja', 'biller_name' => 'Bet9ja'],
                    ['biller_id' => 'betking', 'biller_name' => 'BetKing'],
                    ['biller_id' => '1xbet', 'biller_name' => '1xBet']
                ];
                return response()->json([
                    'status' => 'success',
                    'data' => $fallback
                ]);
            }

            return response()->json($response);
        } catch (\Exception $e) {
            $fallback = [
                ['biller_id' => 'sportybet', 'biller_name' => 'SportyBet'],
                ['biller_id' => 'bet9ja', 'biller_name' => 'Bet9ja'],
                ['biller_id' => 'betking', 'biller_name' => 'BetKing'],
                ['biller_id' => '1xbet', 'biller_name' => '1xBet']
            ];
            return response()->json([
                'status' => 'success',
                'data' => $fallback
            ]);
        }
    }
}