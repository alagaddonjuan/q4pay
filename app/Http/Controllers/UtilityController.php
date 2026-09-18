<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VirtualAccount;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UtilityController extends Controller
{
    /**
     * Helper to calculate wholesale commission on utilities (if 9PSB offers it)
     * e.g., 1.5% commission on electricity purchases.
     */
    private function calculateUtilityProfit($amount)
    {
        $percentage = 0.015; // 1.5% example
        return $amount * $percentage;
    }

    public function getProviders(Request $request)
    {
        $merchant = \App\Models\Merchant::current();
        $router = new \App\Services\SmartRoutingService();
        $apiResult = $router->getElectricityBillers($merchant);
        
        return response()->json($apiResult);
    }

    public function verifyMeter(Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        $validated = $request->validate([
            'meter_number' => 'required|string',
            'disco' => 'required|string', 
            'meter_type' => 'required|string'
        ]);

        try {
            $router = new \App\Services\SmartRoutingService();
            
            // Standard Operation: Pull the merchant's first available account for validation routing
            $account = VirtualAccount::whereHas('agent', function($q) use ($merchant) {
                $q->where('merchant_id', $merchant->id);
            })->first();
            $validationAccount = $account ? $account->account_number : '0000000000';

            $apiResult = $router->validateMeter(
                $merchant, 
                $validationAccount, 
                $validated['meter_number'], 
                $validated['disco'], 
                $validated['meter_type'],
                5000 // Test amount for validation
            );

            Log::info('9PSB Power Verify:', (array)$apiResult);

            if (isset($apiResult['success']) && $apiResult['success'] === true) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'customer_name' => $apiResult['data']['customer_name'] ?? 'Meter Owner',
                        'address' => $apiResult['data']['address'] ?? 'Address Resolved'
                    ]
                ], 200);
            }

            $errorMessage = $apiResult['data']['error'] ?? $apiResult['message'] ?? 'Validation Failed';
            return response()->json(['error' => $errorMessage, 'raw_response' => $apiResult], 400);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Network error.', 'raw_response' => null], 500);
        }
    }

    public function purchaseElectricity(Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        $validated = $request->validate([
            'meter_number' => 'required|string',
            'disco' => 'required|string',
            'meter_type' => 'required|string',
            'amount' => 'required|numeric|min:1000', 
            'sourceAccountNumber' => 'required|string',
            'pin' => 'required|digits:4' 
        ]);

        if (!$merchant->transaction_pin) {
            return response()->json(['error' => 'Please set a Transaction PIN in your settings.'], 403);
        }
        if (!Hash::check($validated['pin'], $merchant->transaction_pin)) {
            return response()->json(['error' => 'Invalid Transaction PIN.'], 401);
        }

        // ==========================================
        // 🟢 Q4I REVENUE CALCULATIONS
        // ==========================================
        $purchaseAmount = $validated['amount'];
        $q4iConvenienceFee = 100; // Flat fee charged to merchant
        $ninePsbCommission = $this->calculateUtilityProfit($purchaseAmount); // Wholesale discount
        $totalProfit = $q4iConvenienceFee + $ninePsbCommission; // Total earnings for Q4I
        
        $totalDeduction = $purchaseAmount + $q4iConvenienceFee;

        $account = VirtualAccount::where('account_number', $validated['sourceAccountNumber'])
            ->whereHas('agent', function($q) use ($merchant) {
                $q->where('merchant_id', $merchant->id);
            })->first();

        if (!$account || $account->ledger_balance < $totalDeduction || $merchant->wallet_balance < $totalDeduction) {
            return response()->json(['error' => 'Insufficient funds in virtual account or merchant wallet.'], 400);
        }

        $txnRef = 'Q4I-ELEC-' . time() . '-' . rand(1000, 9999);

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
                'amount' => $purchaseAmount,
                'fee_charged' => $q4iConvenienceFee, 
                'settled_amount' => $totalDeduction,
                'balance_before' => $account->ledger_balance + $totalDeduction,
                'balance_after' => $account->ledger_balance,
                'status' => 'pending', 
                'remarks' => "Electricity: {$validated['disco']} - {$validated['meter_number']}"
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Database Error.'], 500);
        }

        // CALL API
        try {
            $router = new \App\Services\SmartRoutingService();

            $apiResult = $router->processElectricityPurchase(
                $merchant,
                $validated['sourceAccountNumber'],
                $validated['meter_number'],
                $validated['disco'],
                $validated['meter_type'],
                $purchaseAmount
            );
            
            if (!isset($apiResult['success']) || $apiResult['success'] === false) {
                // Auto-Reverse
                $account->increment('ledger_balance', $totalDeduction);
                $merchant->increment('wallet_balance', $totalDeduction);
                
                $transaction->update(['status' => 'failed', 'remarks' => 'Vendor failed']);
                return response()->json(['error' => $apiResult['data']['error'] ?? 'Purchase failed. Refunded.'], 400);
            }

            // ==========================================
            // 🟢 LOG SUCCESS & CAPTURE REVENUE
            // ==========================================
            DB::beginTransaction();
            try {
                $transaction->update(['status' => 'successful']);
                
                // Push total earnings (Fee + Commission) to System Earnings Ledger
                if ($totalProfit > 0) {
                    DB::table('system_earnings')->insert([
                        'transaction_ref' => $txnRef,
                        'merchant_id' => $merchant->id,
                        'type' => 'utility_electricity_profit',
                        'amount' => $totalProfit,
                        'created_at' => now()
                    ]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to log Utility Profit: ' . $e->getMessage());
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Electricity token generated successfully.',
                'data' => [
                    'reference' => $apiResult['data']['transaction_reference'] ?? $txnRef,
                    'token' => $apiResult['data']['token'] ?? '0000 0000 0000 0000',
                    'units' => $apiResult['data']['units'] ?? '0.0',
                    'new_balance' => $account->ledger_balance
                ]
            ], 200);

        } catch (\Exception $e) {
            $account->increment('ledger_balance', $totalDeduction);
            $merchant->increment('wallet_balance', $totalDeduction);
            $transaction->update(['status' => 'failed', 'remarks' => 'Timeout Refund']);
            return response()->json(['error' => 'Timeout. Funds refunded.'], 500);
        }
    }
}
