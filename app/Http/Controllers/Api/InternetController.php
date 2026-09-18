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

class InternetController extends Controller
{
    protected NinePsbVasService $vasService;

    // Inject the engine we just built
    public function __construct(NinePsbVasService $vasService)
    {
        $this->vasService = $vasService;
    }

    /**
     * Helper to calculate wholesale commission on Internet subscriptions
     */
    private function calculateInternetProfit($amount)
    {
        $percentage = 0.01; // 1% wholesale commission from the provider
        return $amount * $percentage;
    }

    public function getBillers(Request $request)
    {
        if (!$request->_merchant) return response()->json(['error' => 'Unauthenticated.'], 401);
        try {
            $categories = $this->vasService->getCategories();
            $internetCategoryId = "3"; // Default for Internet Services
            if (isset($categories['data']) && is_array($categories['data'])) {
                foreach($categories['data'] as $cat) {
                    if (stripos($cat['name'], 'internet') !== false || stripos($cat['name'], 'data') !== false || stripos($cat['name'], 'broadband') !== false) {
                        $internetCategoryId = $cat['id'];
                        break;
                    }
                }
            }
            $response = $this->vasService->getCategoryBillers($internetCategoryId);
            
            if (!isset($response['data']) || empty($response['data'])) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'No billers found in category',
                    'debug_category_id' => $internetCategoryId,
                    'debug_categories' => $categories
                ], 404);
            }
            
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Fetch Internet Billers Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch Internet billers.'], 500);
        }
    }

    public function getBillerItems(Request $request, $billerId)
    {
        if (!$request->_merchant) return response()->json(['error' => 'Unauthenticated.'], 401);
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
                
                if (!empty($items)) {
                    return response()->json([
                        'status' => 'success',
                        'data' => $items
                    ]);
                }
            }
            
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Fetch Internet Packages Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch Internet packages.'], 500);
        }
    }

    public function validateAccount(Request $request)
    {
        if (!$request->_merchant) return response()->json(['error' => 'Unauthenticated.'], 401);
        $request->validate([
            'phone' => 'required|string',
            'biller_id' => 'required|string',
            'package_code' => 'nullable|string',
            'amount' => 'nullable|numeric'
        ]);

        try {
            $response = $this->vasService->validateBiller(
                $request->phone,
                $request->biller_id,
                $request->package_code ?? '',
                $request->amount
            );

            if (isset($response['status']) && $response['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'customer_name' => $response['data']['customerName'] ?? 'Validated Customer',
                        'address' => $response['data']['address'] ?? '',
                        'other_field' => $response['data']['otherField'] ?? ''
                    ]
                ]);
            }
            return response()->json([
                'error' => $response['message'] ?? 'Unable to validate account',
                'raw_response' => $response
            ], 400);

        } catch (\Exception $e) {
            Log::error('Internet Validation Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Service timeout. Try again.'], 500);
        }
    }

    public function purchase(Request $request)
    {
        $merchant = $request->_merchant;

        if (!$merchant) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // 1. Strict Validation
        $validated = $request->validate([
            'source_account' => 'required|string',
            'phone' => 'required|string',
            'amount' => 'required|numeric|min:500|max:50000',
            'biller_id' => 'required|string',
            'package_code' => 'required|string',
            'customer_name' => 'nullable|string',
            'pin' => 'required|digits:4',
        ]);

        // 2. PIN Security Check
        if (!$merchant->transaction_pin) {
            return response()->json(['error' => 'Please set a Transaction PIN in your settings.'], 403);
        }
        if (!Hash::check($validated['pin'], $merchant->transaction_pin)) {
            return response()->json(['error' => 'Invalid Transaction PIN.'], 401);
        }

        // 3. Q4I Revenue Calculations
        $purchaseAmount = $validated['amount'];
        $q4iFee = 50; // Flat N50 convenience fee for Internet subs
        $providerCommission = $this->calculateInternetProfit($purchaseAmount); 
        $totalProfit = $q4iFee + $providerCommission;

        $totalDeduction = $purchaseAmount + $q4iFee;

        // 4. Ledger Validation (Verify Account Ownership & Balance)
        $account = VirtualAccount::where('account_number', $validated['source_account'])
            ->whereHas('agent', function($q) use ($merchant) {
                $q->where('merchant_id', $merchant->id);
            })->first();

        if (!$account || $account->ledger_balance < $totalDeduction || $merchant->wallet_balance < $totalDeduction) {
            return response()->json(['error' => "Insufficient funds across virtual account and merchant wallet. Balance must cover ₦{$purchaseAmount} + ₦{$q4iFee} fee."], 400);
        }

        $txnRef = 'Q4I-INT-' . time() . '-' . rand(1000, 9999);

        // 5. Lock Funds Locally
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
                'remarks' => "Internet: {$validated['biller_id']} - Phone: {$validated['phone']}"
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Local ledger error during Internet purchase: ' . $e->getMessage());
            return response()->json(['error' => 'Database error locking funds.'], 500);
        }

        // 6. Fire the request through the Engine
        try {
            $payload = [
                'customerId' => $validated['phone'],
                'billerId' => $validated['biller_id'],
                'itemId' => $validated['package_code'],
                'customerPhone' => $validated['phone'],
                'customerName' => $validated['customer_name'] ?? 'Verified Customer',
                'otherField' => 'Internet Subscription',
                'debitAccount' => $validated['source_account'],
                'amount' => (string)$purchaseAmount,
                'transactionReference' => $txnRef,
            ];

            $result = $this->vasService->payBill($payload);

            // 7. Handle Provider Failure & Auto-Reversal
            if (!isset($result['status']) || $result['status'] !== 'success') {
                $account->increment('ledger_balance', $totalDeduction);
                $merchant->increment('wallet_balance', $totalDeduction);
                $transaction->update(['status' => 'failed', 'remarks' => 'Provider failed. Refunded.']);
                
                return response()->json([
                    'status' => 'failed',
                    'error' => $result['message'] ?? 'Transaction failed at provider level. Funds refunded.',
                    'error_code' => $result['code'] ?? 'UNKNOWN_ERROR',
                    'techvibs_raw_response' => $result 
                ], 400);
            }

            // 8. Log Success & Capture Profit
            DB::beginTransaction();
            try {
                $transaction->update(['status' => 'successful']);

                if ($totalProfit > 0) {
                    DB::table('system_earnings')->insert([
                        'transaction_ref' => $txnRef,
                        'merchant_id' => $merchant->id,
                        'type' => 'internet_commission',
                        'amount' => $totalProfit,
                        'created_at' => now()
                    ]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to log Internet Profit: ' . $e->getMessage());
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Internet subscription successful',
                'data' => [
                    'reference' => $txnRef,
                    'phone' => $validated['phone'],
                    'amount_funded' => $purchaseAmount,
                    'platform_fee' => $q4iFee,
                    'new_balance' => $account->ledger_balance,
                    'provider_data' => $result['data'] ?? []
                ]
            ], 200);

        } catch (\Exception $e) {
            // Auto-reverse on Timeout/Crash
            $account->increment('ledger_balance', $totalDeduction);
            $merchant->increment('wallet_balance', $totalDeduction);
            $transaction->update(['status' => 'failed', 'remarks' => 'Timeout. Refunded.']);
            
            Log::error('Internet Purchase Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Service timeout. Funds refunded.'], 500);
        }
    }
}
