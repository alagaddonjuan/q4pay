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

class TvSubscriptionController extends Controller
{
    protected NinePsbVasService $vasService;

    // Inject the engine we just built
    public function __construct(NinePsbVasService $vasService)
    {
        $this->vasService = $vasService;
    }

    /**
     * Helper to calculate wholesale commission on TV subscriptions
     */
    private function calculateTvProfit($amount)
    {
        $percentage = 0.01; // e.g., 1% wholesale commission from the provider
        return $amount * $percentage;
    }

    public function getBillers(Request $request)
    {
        if (!$request->_merchant) return response()->json(['error' => 'Unauthenticated.'], 401);
        try {
            // TV Category ID is usually 2 on 9PSB
            $categories = $this->vasService->getCategories();
            $tvCategoryId = "2"; 
            if (isset($categories['data']) && is_array($categories['data'])) {
                foreach($categories['data'] as $cat) {
                    if (stripos($cat['name'], 'tv') !== false || stripos($cat['name'], 'cable') !== false) {
                        $tvCategoryId = $cat['id'];
                        break;
                    }
                }
            }
            $response = $this->vasService->getCategoryBillers($tvCategoryId);
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Fetch TV Billers Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch TV billers.'], 500);
        }
    }

    public function getBillerItems(Request $request, $billerId)
    {
        if (!$request->_merchant) return response()->json(['error' => 'Unauthenticated.'], 401);
        try {
            $response = $this->vasService->getBillerItems($billerId);
            
            // Similar to Electricity, items are often inside a Field where isSelectData = 'Y'
            $items = [];
            if (isset($response['data']) && is_array($response['data'])) {
                foreach ($response['data'] as $field) {
                    if (isset($field['isSelectData']) && $field['isSelectData'] === 'Y' && isset($field['items'])) {
                        $items = $field['items'];
                        break;
                    }
                }
                
                // If items were found, we wrap them in a successful structure for the frontend
                if (!empty($items)) {
                    return response()->json([
                        'status' => 'success',
                        'data' => $items
                    ]);
                }
            }
            
            // Fallback to original response
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Fetch TV Packages Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch TV packages.'], 500);
        }
    }

    public function validateSmartcard(Request $request)
    {
        if (!$request->_merchant) return response()->json(['error' => 'Unauthenticated.'], 401);
        $request->validate([
            'smartcard_number' => 'required|string',
            'biller_id' => 'required|string',
            'package_code' => 'nullable|string',
            'amount' => 'nullable|numeric'
        ]);

        try {
            $response = $this->vasService->validateBiller(
                $request->smartcard_number,
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
                'error' => $response['message'] ?? 'Unable to validate smartcard',
                'raw_response' => $response
            ], 400);

        } catch (\Exception $e) {
            Log::error('TV Validation Exception: ' . $e->getMessage());
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
            'smartcard_number' => 'required|string',
            'amount' => 'required|numeric|min:500|max:50000',
            'biller_id' => 'required|string',
            'package_code' => 'required|string', // Equivalent to itemId for 9psb
            'customer_phone' => 'required|string',
            'customer_name' => 'required|string',
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
        $q4iFee = 50; // Flat N50 convenience fee for TV subs
        $providerCommission = $this->calculateTvProfit($purchaseAmount); 
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

        $txnRef = 'Q4I-TV-' . time() . '-' . rand(1000, 9999);

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
                'remarks' => "TV Subscription: {$validated['biller_id']} - Smartcard: {$validated['smartcard_number']}"
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Local ledger error during TV purchase: ' . $e->getMessage());
            return response()->json(['error' => 'Database error locking funds.'], 500);
        }

        // 6. Fire the request through the Engine
        try {
            $payload = [
                'customerId' => $validated['smartcard_number'],
                'billerId' => $validated['biller_id'],
                'itemId' => $validated['package_code'],
                'customerPhone' => $validated['customer_phone'],
                'customerName' => $validated['customer_name'],
                'otherField' => 'TV Subscription',
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
                        'type' => 'tv_commission',
                        'amount' => $totalProfit,
                        'created_at' => now()
                    ]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to log TV Profit: ' . $e->getMessage());
            }

            return response()->json([
                'status' => 'success',
                'message' => 'TV subscription successful',
                'data' => [
                    'reference' => $txnRef,
                    'smartcard_number' => $validated['smartcard_number'],
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
            
            Log::error('TV Purchase Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Service timeout. Funds refunded.'], 500);
        }
    }
}
