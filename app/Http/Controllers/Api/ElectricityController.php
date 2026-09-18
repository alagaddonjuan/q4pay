<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NinePsbVasService;
use App\Models\VirtualAccount;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ElectricityController extends Controller
{
    protected NinePsbVasService $vasService;
    private $electricityCategoryId = "1";

    public function __construct(NinePsbVasService $vasService)
    {
        $this->vasService = $vasService;
    }

    /**
     * Helper to calculate wholesale commission on electricity
     */
    private function calculateElectricityProfit($amount)
    {
        $percentage = 0.015; // e.g., 1.5% wholesale commission from the provider
        return $amount * $percentage;
    }

    // GET: /api/electricity/billers
    public function getBillers(Request $request)
    {
        if (!$request->_merchant) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        try {
            $response = $this->vasService->getCategoryBillers($this->electricityCategoryId);
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('9PSB Get Electricity Billers Error: ' . $e->getMessage());
            return response()->json(['error' => 'Service connection error.'], 500);
        }
    }

    // GET: /api/electricity/biller/items/{billerId}
    public function getBillerItems(Request $request, $billerId)
    {
        if (!$request->_merchant) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        try {
            $response = $this->vasService->getBillerItems($billerId);
            
            $items = [];
            if (isset($response['data']) && is_array($response['data'])) {
                foreach ($response['data'] as $field) {
                    if (isset($field['isSelectData']) && $field['isSelectData'] === 'Y' && isset($field['items'])) {
                        $items = $field['items'];
                        break;
                    }
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => $items
            ]);
        } catch (\Exception $e) {
            Log::error('9PSB Get Biller Items Error: ' . $e->getMessage());
            return response()->json(['error' => 'Service connection error.'], 500);
        }
    }

    // POST: /api/electricity/validate
    public function validateMeter(Request $request)
    {
        if (!$request->_merchant) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $request->validate([
            'meter_number'   => 'required|string',
            'biller_id'      => 'required|string',
            'meter_type'     => 'nullable|string', // Optional itemId depending on biller
            'amount'         => 'nullable|numeric',
        ]);

        try {
            $apiResult = $this->vasService->validateBiller(
                $request->meter_number,
                $request->biller_id,
                $request->meter_type,
                $request->amount
            );
            
            if (isset($apiResult['status']) && $apiResult['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'customer_name' => $apiResult['data']['customerName'] ?? 'Meter Owner',
                        'address' => $apiResult['data']['otherField'] ?? 'Address Resolved',
                        'other_field' => $apiResult['data']['otherField'] ?? null
                    ]
                ], 200);
            }

            return response()->json([
                'error' => $apiResult['message'] ?? 'Validation Failed',
                'raw_response' => $apiResult
            ], 400);

        } catch (\Exception $e) {
            Log::error('9PSB Validate Electricity Error: ' . $e->getMessage());
            return response()->json(['error' => 'Service connection error.'], 500);
        }
    }

    // POST: /api/electricity/purchase
    public function purchase(Request $request)
    {
        $merchant = $request->_merchant;

        if (!$merchant) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'account_number' => 'required|string', // debit account
            'meter_number'   => 'required|string',
            'biller_id'      => 'required|string',
            'meter_type'     => 'required|string', // Usually VT01 or VT02 based on the biller input fields
            'amount'         => 'required|numeric|min:500', 
            'customer_phone' => 'required|string',
            'customer_name'  => 'required|string',
            'other_field'    => 'nullable|string', // Required by 9psb for some billers from validation
            'pin'            => 'required|digits:4',
        ]);

        if (!$merchant->transaction_pin) {
            return response()->json(['error' => 'Please set a Transaction PIN in your settings.'], 403);
        }
        if (!Hash::check($validated['pin'], $merchant->transaction_pin)) {
            return response()->json(['error' => 'Invalid Transaction PIN.'], 401);
        }

        $purchaseAmount = $validated['amount'];
        $q4iFee = 100; // Flat N100 convenience fee
        $providerCommission = $this->calculateElectricityProfit($purchaseAmount); 
        $totalProfit = $q4iFee + $providerCommission;

        $totalDeduction = $purchaseAmount + $q4iFee;

        $account = VirtualAccount::where('account_number', $validated['account_number'])
            ->whereHas('agent', function($q) use ($merchant) {
                $q->where('merchant_id', $merchant->id);
            })->first();

        if (!$account || $account->ledger_balance < $totalDeduction || $merchant->wallet_balance < $totalDeduction) {
            return response()->json(['error' => "Insufficient funds across virtual account and merchant wallet. Balance must cover ₦{$purchaseAmount} + ₦{$q4iFee} fee."], 400);
        }

        $txnRef = 'Q4I-ELEC-' . time() . '-' . rand(1000, 9999);

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
                'fee_charged' => $q4iFee,
                'settled_amount' => $totalDeduction,
                'balance_before' => $account->ledger_balance + $totalDeduction,
                'balance_after' => $account->ledger_balance,
                'status' => 'pending', 
                'remarks' => "Electricity Token: {$validated['biller_id']} - Meter: {$validated['meter_number']}"
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Local ledger error during electricity purchase: ' . $e->getMessage());
            return response()->json(['error' => 'Database error locking funds.'], 500);
        }

        try {
            $payload = [
                'customerId' => $validated['meter_number'],
                'billerId' => $validated['biller_id'],
                'itemId' => $validated['meter_type'],
                'customerPhone' => $validated['customer_phone'],
                'customerName' => $validated['customer_name'],
                'otherField' => $validated['other_field'] ?? 'Electricity Purchase',
                'debitAccount' => $validated['account_number'],
                'amount' => (string)$purchaseAmount,
                'transactionReference' => $txnRef,
            ];

            $apiResult = $this->vasService->payBill($payload);

            if (!isset($apiResult['status']) || $apiResult['status'] !== 'success') {
                $account->increment('ledger_balance', $totalDeduction);
                $merchant->increment('wallet_balance', $totalDeduction);
                $transaction->update(['status' => 'failed', 'remarks' => 'Provider failed. Refunded.']);
                
                return response()->json(['error' => $apiResult['message'] ?? 'Purchase failed. Funds refunded.'], 400);
            }

            DB::beginTransaction();
            try {
                $transaction->update(['status' => 'successful']);

                if ($totalProfit > 0) {
                    DB::table('system_earnings')->insert([
                        'transaction_ref' => $txnRef,
                        'merchant_id' => $merchant->id,
                        'type' => 'electricity_commission',
                        'amount' => $totalProfit,
                        'created_at' => now()
                    ]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to log Electricity Profit: ' . $e->getMessage());
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Electricity token generated successfully.',
                'data' => [
                    'reference' => $txnRef,
                    'meter_number' => $validated['meter_number'],
                    'amount_funded' => $purchaseAmount,
                    'platform_fee' => $q4iFee,
                    'new_balance' => $account->ledger_balance,
                    'token' => $apiResult['data']['token'] ?? 'PENDING_SMS',
                    'units' => $apiResult['data']['otherField'] ?? null
                ]
            ], 200);

        } catch (\Exception $e) {
            $account->increment('ledger_balance', $totalDeduction);
            $merchant->increment('wallet_balance', $totalDeduction);
            $transaction->update(['status' => 'failed', 'remarks' => 'Timeout. Refunded.']);
            
            Log::error('Electricity Purchase Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Service timeout. Funds refunded.'], 500);
        }
    }
}