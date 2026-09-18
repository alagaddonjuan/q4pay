<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VirtualAccount;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Services\NinePsbVasService;

class VasController extends Controller
{
    private $vasService;

    public function __construct(NinePsbVasService $vasService)
    {
        $this->vasService = $vasService;
    }

    /**
     * Internal helper to calculate VAS profit margins.
     */
    private function calculateVasProfit($amount, $type)
    {
        $margins = [
            'airtime' => 0.03, // 3% profit
            'data'    => 0.02, // 2% profit
        ];

        $percentage = $margins[$type] ?? 0;
        return $amount * $percentage;
    }

    public function purchaseAirtime(Request $request)
    {
        $merchant = $request->_merchant;
        if (!$merchant) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        $validated = $request->validate([
            'phone' => 'required|string|min:10|max:15',
            'sourceAccountNumber' => 'required|string',
            'amount' => 'required|numeric|min:50',
            'pin' => 'required|digits:4'
        ]);

        if (!$merchant->transaction_pin) {
            return response()->json(['error' => 'Please set a Transaction PIN in your settings before moving funds.'], 403);
        }
        if (!Hash::check($validated['pin'], $merchant->transaction_pin)) {
            return response()->json(['error' => 'Invalid Transaction PIN.'], 401);
        }

        $purchaseAmount = $validated['amount'];
        $q4iProfit = $this->calculateVasProfit($purchaseAmount, 'airtime');

        $account = VirtualAccount::where('account_number', $validated['sourceAccountNumber'])
            ->whereHas('agent', function($q) use ($merchant) {
                $q->where('merchant_id', $merchant->id);
            })->first();

        if (!$account || $account->ledger_balance < $purchaseAmount || $merchant->wallet_balance < $purchaseAmount) {
            return response()->json(['error' => 'Invalid account or insufficient funds across virtual account and merchant wallet.'], 400);
        }

        // Get network first
        try {
            $networkResp = $this->vasService->getNetwork($validated['phone']);
            if (!isset($networkResp['status']) || $networkResp['status'] !== 'success') {
                return response()->json(['error' => 'Could not determine network for phone number.'], 400);
            }
            $network = $networkResp['data']['network'];
        } catch (\Exception $e) {
            Log::error('9PSB Get Network Error: ' . $e->getMessage());
            return response()->json(['error' => 'Service connection error.'], 500);
        }

        $txnRef = 'Q4I-VAS-' . time() . '-' . rand(1000, 9999);

        DB::beginTransaction();
        try {
            $account->decrement('ledger_balance', $purchaseAmount);
            $merchant->decrement('wallet_balance', $purchaseAmount);

            $transaction = Transaction::create([
                'virtual_account_id' => $account->id,
                'merchant_id' => $merchant->id,
                'session_id' => $txnRef,
                'type' => 'debit',
                'amount' => $purchaseAmount,
                'fee_charged' => 0,
                'settled_amount' => $purchaseAmount, 
                'balance_before' => $account->ledger_balance + $purchaseAmount,
                'balance_after' => $account->ledger_balance,
                'status' => 'pending', 
                'remarks' => 'Airtime Topup: ' . $validated['phone']
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Internal Database Error'], 500);
        }

        try {
            // Initiate 9PSB Airtime Purchase
            $apiResult = $this->vasService->purchaseAirtime(
                $validated['phone'],
                $network,
                $purchaseAmount,
                $validated['sourceAccountNumber'],
                $txnRef
            );

            if (!isset($apiResult['status']) || $apiResult['status'] !== 'success') {
                $account->increment('ledger_balance', $purchaseAmount);
                $merchant->increment('wallet_balance', $purchaseAmount);
                
                $transaction->update([
                    'status' => 'failed',
                    'balance_after' => $account->ledger_balance,
                    'remarks' => 'Failed/Refunded: ' . ($apiResult['message'] ?? 'Network Error')
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Airtime purchase failed. Funds refunded.',
                    'reason' => $apiResult['message'] ?? 'Unknown network error'
                ], 400);
            }

            DB::beginTransaction();
            try {
                $transaction->update(['status' => 'successful']);
                
                if ($q4iProfit > 0) {
                    DB::table('system_earnings')->insert([
                        'transaction_ref' => $txnRef,
                        'merchant_id' => $merchant->id,
                        'type' => 'vas_airtime_commission',
                        'amount' => $q4iProfit, 
                        'created_at' => now()
                    ]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to log VAS Profit: ' . $e->getMessage());
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Airtime purchased successfully.',
                'data' => [
                    'reference' => $txnRef,
                    'phone' => $validated['phone'],
                    'network' => $network,
                    'amount' => $purchaseAmount,
                    'new_balance' => $account->ledger_balance
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('VAS Airtime Exception: ' . $e->getMessage());
            $account->increment('ledger_balance', $purchaseAmount);
            $merchant->increment('wallet_balance', $purchaseAmount);
            $transaction->update(['status' => 'failed', 'remarks' => 'System Timeout Refund']);

            return response()->json(['error' => 'Service unavailable. Funds refunded.'], 500);
        }
    }

    public function fetchDataPlans(Request $request)
    {
        $request->validate(['phone' => 'required|string|min:10|max:15']);

        try {
            $apiResult = $this->vasService->getDataPlans($request->phone);

            if (isset($apiResult['status']) && $apiResult['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'data' => $apiResult['data'] ?? []
                ], 200);
            }

            return response()->json(['error' => 'Could not fetch data plans. Check network.'], 400);
        } catch (\Exception $e) {
            Log::error('9PSB Get Data Plans Error: ' . $e->getMessage());
            return response()->json(['error' => 'Service connection error.'], 500);
        }
    }

    public function purchaseData(Request $request)
    {
        $merchant = $request->_merchant;

        $validated = $request->validate([
            'phone' => 'required|string',
            'sourceAccountNumber' => 'required|string',
            'amount' => 'required|numeric',
            'network' => 'required|string',
            'product_id' => 'required|string',
            'pin' => 'required|digits:4'
        ]);

        if (!$merchant->transaction_pin) {
            return response()->json(['error' => 'Please set a Transaction PIN in your settings before moving funds.'], 403);
        }
        if (!Hash::check($validated['pin'], $merchant->transaction_pin)) {
            return response()->json(['error' => 'Invalid Transaction PIN.'], 401);
        }

        $purchaseAmount = $validated['amount'];
        $q4iProfit = $this->calculateVasProfit($purchaseAmount, 'data');

        $account = VirtualAccount::where('account_number', $validated['sourceAccountNumber'])
            ->whereHas('agent', function($q) use ($merchant) {
                $q->where('merchant_id', $merchant->id);
            })->first();

        if (!$account || $account->ledger_balance < $purchaseAmount || $merchant->wallet_balance < $purchaseAmount) {
            return response()->json(['error' => 'Invalid account or insufficient funds across virtual account and merchant wallet.'], 400);
        }

        $txnRef = 'Q4I-DATA-' . time() . '-' . rand(1000, 9999);

        DB::beginTransaction();
        try {
            $account->decrement('ledger_balance', $purchaseAmount);
            $merchant->decrement('wallet_balance', $purchaseAmount);

            $transaction = Transaction::create([
                'virtual_account_id' => $account->id,
                'merchant_id' => $merchant->id,
                'session_id' => $txnRef,
                'type' => 'debit',
                'amount' => $purchaseAmount,
                'fee_charged' => 0,
                'settled_amount' => $purchaseAmount,
                'balance_before' => $account->ledger_balance + $purchaseAmount,
                'balance_after' => $account->ledger_balance,
                'status' => 'pending', 
                'remarks' => "Data Purchase [{$validated['product_id']}] for {$validated['phone']}"
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Database Error'], 500);
        }

        try {
            $apiResult = $this->vasService->purchaseData(
                $validated['phone'], 
                $validated['network'],
                $purchaseAmount, 
                $validated['product_id'],
                $validated['sourceAccountNumber'],
                $txnRef
            );

            if (!isset($apiResult['status']) || $apiResult['status'] !== 'success') {
                $account->increment('ledger_balance', $purchaseAmount);
                $merchant->increment('wallet_balance', $purchaseAmount);
                
                $transaction->update([
                    'status' => 'failed',
                    'balance_after' => $account->ledger_balance,
                    'remarks' => 'Failed/Refunded: ' . ($apiResult['message'] ?? 'Network Error')
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Data purchase failed. Funds refunded.',
                    'reason' => $apiResult['message'] ?? json_encode($apiResult)
                ], 400);
            }

            DB::beginTransaction();
            try {
                $transaction->update(['status' => 'successful']);
                
                if ($q4iProfit > 0) {
                    DB::table('system_earnings')->insert([
                        'transaction_ref' => $txnRef,
                        'merchant_id' => $merchant->id,
                        'type' => 'vas_data_commission',
                        'amount' => $q4iProfit, 
                        'created_at' => now()
                    ]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to log VAS Profit: ' . $e->getMessage());
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data purchased successfully.',
                'data' => [
                    'reference' => $txnRef,
                    'phone' => $validated['phone'],
                    'amount' => $purchaseAmount,
                    'new_balance' => $account->ledger_balance
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('VAS Data Exception: ' . $e->getMessage());
            $account->increment('ledger_balance', $purchaseAmount);
            $merchant->increment('wallet_balance', $purchaseAmount);
            $transaction->update(['status' => 'failed', 'remarks' => 'Data Timeout Refund']);
            return response()->json(['error' => 'Service connection error. Funds auto-refunded.'], 500);
        }
    }
}
