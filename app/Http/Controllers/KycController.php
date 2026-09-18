<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Merchant;
use App\Models\Agent;
use App\Models\Transaction;

class KycController extends Controller
{
    public function upgradeToTierTwo(Request $request)
    {
        // 1. Authenticate the Merchant via API Key
        $apiKey = $request->header('X-Q4I-API-Key');
        $merchant = Merchant::where('q4i_api_key', $apiKey)->where('is_active', true)->first();

        if (!$merchant) {
            return response()->json(['error' => 'Invalid or inactive Merchant API Key.'], 401);
        }

        // 2. Validate the incoming KYC data from the Merchant
        $validated = $request->validate([
            'merchant_reference' => 'required|string',
            'id_document_url' => 'required|url', // E.g., an AWS S3 link to their NIN slip
        ]);

        // 3. Find the Agent and their Virtual Account
        $agent = Agent::with('virtualAccount')
                      ->where('merchant_id', $merchant->id)
                      ->where('merchant_reference', $validated['merchant_reference'])
                      ->first();

        if (!$agent || !$agent->virtualAccount) {
            return response()->json(['error' => 'Agent or Virtual Account not found'], 404);
        }

        // 4. SIMULATE AI VERIFICATION
        $simulatedLivenessScore = 98.50; 
        
        DB::beginTransaction();
        try {
            // 5. Upgrade the Agent's Profile Locally
            $agent->update([
                'kyc_tier' => 2,
                'id_document_url' => $validated['id_document_url'],
                'liveness_score' => $simulatedLivenessScore,
            ]);

            // 6. Upgrade the Account Limits Locally
            $account = $agent->virtualAccount;
            $account->update([
                'wallet_status' => 'active',
                'daily_transfer_limit' => 500000.00, // New CBN Tier 2 Limit
                'max_balance_limit' => 2000000.00,   // New CBN Tier 2 Limit
            ]);

            // ==========================================
            // 🟢 SYNCHRONIZE TIER UPGRADE WITH TECHVIBS
            // ==========================================
            // Ensure the actual banking network lifts the deposit restrictions
            $apiResponse = Http::withoutVerifying()
                ->withToken(env('TECHVIBES_BEARER_TOKEN'))
                ->post('https://techvibs.com/9psb/upgrade_virtual_account_tier.php', [
                    'account_number' => $account->account_number,
                    'bvn' => $agent->bvn,
                    'nin' => $agent->nin,
                    'target_tier' => 2
                ]);

            if (!$apiResponse->successful() || ($apiResponse->json()['status'] ?? '') !== 'success') {
                throw new \Exception('Failed to synchronize tier upgrade with the banking provider.');
            }

            // 7. THE RELEASE ENGINE: Find and unlock all quarantined funds
            $quarantinedTransactions = Transaction::where('virtual_account_id', $account->id)
                                                  ->where('status', 'quarantined')
                                                  ->get();

            $totalReleased = 0;

            foreach ($quarantinedTransactions as $txn) {
                
                $settledAmount = $txn->settled_amount ?? ($txn->amount - $txn->fee_charged);
                $currentLedger = $account->ledger_balance + $totalReleased;
                
                $txn->update([
                    'status' => 'successful',
                    'balance_before' => $currentLedger,
                    'balance_after' => $currentLedger + $settledAmount,
                    'remarks' => $txn->remarks . ' (Released from Quarantine)'
                ]);

                $totalReleased += $settledAmount;

                // ==========================================
                // 🟢 CAPTURE PLATFORM REVENUE
                // ==========================================
                if ($txn->fee_charged > 0) {
                    DB::table('system_earnings')->insert([
                        'transaction_ref' => $txn->session_id,
                        'merchant_id' => $merchant->id,
                        'type' => 'quarantine_release_fee',
                        'amount' => $txn->fee_charged,
                        'created_at' => now()
                    ]);
                }

                // Fire the Webhook to inform the merchant
                try {
                    \App\Jobs\SendMerchantWebhook::dispatch($txn);
                } catch (\Exception $e) {
                    Log::error('Failed to dispatch webhook after quarantine release: ' . $e->getMessage());
                }
            }

            // 8. Credit the Ledgers if any funds were released
            if ($totalReleased > 0) {
                $account->update(['ledger_balance' => $account->ledger_balance + $totalReleased]);
                $merchant->update(['wallet_balance' => $merchant->wallet_balance + $totalReleased]);
                
                Log::info('Quarantined Funds Released', [
                    'account' => $account->account_number, 
                    'total_released' => $totalReleased
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'KYC Upgrade successful. Account unlocked and limits increased globally.',
                'data' => [
                    'merchant_reference' => $agent->merchant_reference,
                    'new_tier' => $agent->kyc_tier,
                    'wallet_status' => $account->wallet_status,
                    'funds_released' => $totalReleased,
                    'new_ledger_balance' => $account->ledger_balance
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('KYC Upgrade Crash: ' . $e->getMessage());
            return response()->json(['error' => 'System Error during KYC upgrade: ' . $e->getMessage()], 500);
        }
    }
}
