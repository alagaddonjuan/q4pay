<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\AuditLogger;

class MerchantDashboardController extends Controller
{
    use AuditLogger;
    // ========================================================================
    // Helper to get the correct merchant instance
    // ========================================================================
    private function resolveMerchant($request = null)
    {
        return \App\Models\Merchant::current();
    }

    // ========================================================================
    // 1. Get Merchant Overview (Omnichannel: Web & API)
    // ========================================================================
    public function getOverview(\Illuminate\Http\Request $request)
    {
        $merchant = $this->resolveMerchant($request);

        if (!$merchant) {
            abort(403, 'Merchant association not found.');
        }

        $activeAgentsCount = DB::table('agents')->where('merchant_id', $merchant->id)->count();

        $availableBalance = $merchant->wallet_balance;

        $todayCollections = DB::table('transactions')
            ->join('virtual_accounts', 'transactions.virtual_account_id', '=', 'virtual_accounts.id')
            ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
            ->where('agents.merchant_id', $merchant->id)
            ->where('transactions.type', 'credit')
            ->where('transactions.status', 'successful')
            ->whereDate('transactions.created_at', Carbon::today())
            ->sum('transactions.amount');

        $recentActivities = DB::table('transactions')
            ->join('virtual_accounts', 'transactions.virtual_account_id', '=', 'virtual_accounts.id')
            ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
            ->where('agents.merchant_id', $merchant->id)
            ->select('transactions.*', 'virtual_accounts.account_number')
            ->orderBy('transactions.created_at', 'desc')
            ->limit(5)
            ->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'business_name' => $merchant->business_name,
                    'contact_email' => $merchant->email,
                    'wallet_balance' => $availableBalance,
                    'total_agents' => $activeAgentsCount,
                    'today_collections' => $todayCollections,
                    'webhook_url' => $merchant->webhook_url ?? 'Not Configured',
                ]
            ], 200);
        }

        return view('merchant.dashboard', compact(
            'merchant', 
            'availableBalance', 
            'todayCollections', 
            'activeAgentsCount', 
            'recentActivities'
        ));
    }

    // ========================================================================
    // 2. Get All Agents (API)
    // ========================================================================
    public function getAgents(Request $request)
    {
        $merchant = $this->resolveMerchant($request);

        $agents = Agent::with('virtualAccount')
                       ->where('merchant_id', $merchant->id)
                       ->latest()
                       ->paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => $agents
        ], 200);
    }

    // ========================================================================
    // 3. Get Transaction History (API)
    // ========================================================================
    public function getTransactions(Request $request)
    {
        $merchant = $this->resolveMerchant($request);

        $transactions = Transaction::with('virtualAccount.agent')
                                   ->where('merchant_id', $merchant->id)
                                   ->latest()
                                   ->paginate(20);

        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ], 200);
    }

    // ========================================================================
    // 4. Get 7-Day Chart Data
    // ========================================================================
    public function getChartData(Request $request)
    {
        $merchant = $this->resolveMerchant($request);
        
        $labels = [];
        $series = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('M d'); 

            $dailyVolume = Transaction::where('merchant_id', $merchant->id)
                ->where('type', 'credit')
                ->where('status', 'successful')
                ->whereDate('created_at', $date->toDateString())
                ->sum('amount');
                
            $series[] = $dailyVolume;
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'chart_type' => '7_day_inbound_volume',
                'labels' => $labels,
                'series' => $series
            ]
        ], 200);
    }

    // ========================================================================
    // 5. Virtual Accounts Management Page
    // ========================================================================

    public function virtualAccounts(\Illuminate\Http\Request $request)
    {
        $merchant = $this->resolveMerchant($request);
        
        
        $accounts = DB::table('virtual_accounts')
            ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
            ->where('agents.merchant_id', $merchant->id) 
            ->select('virtual_accounts.*', 'agents.first_name', 'agents.last_name', 'agents.phone_number', 'agents.merchant_reference')
            ->orderBy('virtual_accounts.created_at', 'desc')
            ->get();

        return view('merchant.virtual-accounts.index', compact('accounts'));
    }

    public function storeSingleAccount(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'agent_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'dob' => 'required|date',
            'bvn' => 'required|string|size:11',
            'nin' => 'required|string|size:11',
        ]);

        $merchant = \App\Models\Merchant::current();

        try {
            // --- Dojah BVN Verification ---
            $dojahService = new \App\Services\DojahService();
            $dojahResponse = $dojahService->verifyBvn($request->bvn);

            if ($dojahResponse['status'] !== 'success') {
                \Illuminate\Support\Facades\Log::warning('Dojah Verification bypassed due to error: ' . $dojahResponse['message']);
            }

            $officialName = $dojahResponse['official_name'] ?? $request->agent_name;

            DB::transaction(function () use ($request, $merchant, $officialName) {
                $nameParts = explode(' ', $request->agent_name, 2);
                
                $agent = new Agent();
                $agent->merchant_id = $merchant->id;
                $agent->first_name = $nameParts[0];
                $agent->last_name = $nameParts[1] ?? 'Agent';
                $agent->email = $request->email;
                $agent->phone_number = $request->phone; 
                $agent->date_of_birth = $request->dob;
                $agent->bvn = $request->bvn;
                $agent->nin = $request->nin;
                $agent->save();

                $uniqueRef = 'Q4I_SUB_' . time() . '_' . \Illuminate\Support\Str::random(6);
                $payload = [
                    'transaction' => ['reference' => $uniqueRef],
                    'order' => [
                        'amount' => 0,
                        'currency' => 'NGN',
                        'description' => 'Sub-Agent Collection Account',
                        'country' => 'NGA',
                        'amounttype' => 'ANY'
                    ],
                    'customer' => [
                        'account' => [
                            'name' => substr($officialName, 0, 30),
                            'type' => 'STATIC'
                        ]
                    ]
                ];

                $virtualAccountService = new \App\Services\NinePsbVirtualAccountService();
                $apiData = $virtualAccountService->createVirtualAccount($payload);

                if (!isset($apiData['code']) || $apiData['code'] !== '00') {
                    $errorMessage = $apiData['message'] ?? 'Unknown Gateway Error';
                    throw new \Exception("9PSB API Error: " . $errorMessage);
                }

                $userId = DB::table('users')->value('id') ?? 1;

                DB::table('virtual_accounts')->insert([
                    'user_id' => $userId,
                    'agent_id' => $agent->id,
                    'account_number' => $apiData['customer']['account']['number'], 
                    'bank_name' => $apiData['customer']['account']['bank'] ?? '9PSB',
                    'customer_id' => '9PSB_CUST_' . $agent->id,      
                    'order_ref' => $apiData['transaction']['reference'] ?? $uniqueRef,           
                    'ledger_balance' => 0.00,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

            return redirect()->back()->with('success', 'Sub-Agent account provisioned successfully with 9PSB!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Provisioning Failed: ' . $e->getMessage()]);
        }
    }

    // ========================================================================
    // 7. Download CSV Template for Bulk Upload
    // ========================================================================
    public function downloadCsvTemplate()
    {
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=q4i_sub_agents_template.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $columns = ['Name', 'Email', 'Phone', 'Date of Birth (YYYY-MM-DD)', 'BVN', 'NIN'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['John Doe', 'john@example.com', '08012345678', '1990-01-01', '11111111111', '22222222222']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ========================================================================
    // 8. Process Bulk CSV Upload
    // ========================================================================
    public function storeBulkAccounts(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'file-upload' => 'required|mimes:csv,txt|max:5120', 
        ]);

        $file = $request->file('file-upload');
        $fileHandle = fopen($file->getRealPath(), 'r');
        
        fgetcsv($fileHandle); // Skip header
        
        $merchant = \App\Models\Merchant::current();
        $successCount = 0;
        $failedCount = 0;

        while (($row = fgetcsv($fileHandle, 1000, ',')) !== false) {
            if (count($row) < 6 || empty($row[0])) {
                $failedCount++;
                continue;
            }

            try {
                DB::transaction(function () use ($row, $merchant) {
                    $nameParts = explode(' ', trim($row[0]), 2);
                    
                    $agent = new Agent();
                    $agent->merchant_id = $merchant->id;
                    $agent->first_name = $nameParts[0];
                    $agent->last_name = $nameParts[1] ?? 'Agent';
                    $agent->email = trim($row[1]);
                    $agent->phone_number = trim($row[2]); 
                    $agent->date_of_birth = trim($row[3]);
                    $agent->bvn = trim($row[4]);
                    $agent->nin = trim($row[5]);
                    $agent->save();

                    $officialName = trim($agent->first_name . ' ' . $agent->last_name);
                    $uniqueRef = 'Q4I_BLK_' . time() . '_' . \Illuminate\Support\Str::random(6);
                    $payload = [
                        'transaction' => ['reference' => $uniqueRef],
                        'order' => [
                            'amount' => 0,
                            'currency' => 'NGN',
                            'description' => 'Sub-Agent Bulk Collection Account',
                            'country' => 'NGA',
                            'amounttype' => 'ANY'
                        ],
                        'customer' => [
                            'account' => [
                                'name' => substr($officialName, 0, 30),
                                'type' => 'STATIC'
                            ]
                        ]
                    ];

                    $virtualAccountService = new \App\Services\NinePsbVirtualAccountService();
                    $apiData = $virtualAccountService->createVirtualAccount($payload);

                    if (!isset($apiData['code']) || $apiData['code'] !== '00') {
                        $errorMessage = $apiData['message'] ?? 'Unknown Gateway Error';
                        throw new \Exception("9PSB API Error: " . $errorMessage);
                    }

                    $userId = DB::table('users')->value('id') ?? 1;

                    DB::table('virtual_accounts')->insert([
                        'user_id' => $userId,
                        'agent_id' => $agent->id,
                        'account_number' => $apiData['customer']['account']['number'],
                        'bank_name' => $apiData['customer']['account']['bank'] ?? '9PSB',
                        'customer_id' => '9PSB_CUST_' . $agent->id,
                        'order_ref' => $apiData['transaction']['reference'] ?? $uniqueRef,
                        'ledger_balance' => 0.00,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                });
                
                $successCount++;
            } catch (\Exception $e) {
                $failedCount++;
            }
        }

        fclose($fileHandle);

        $message = "Batch processing complete! Successfully provisioned {$successCount} accounts.";
        if ($failedCount > 0) {
            $message .= " Skipped {$failedCount} invalid or duplicate rows.";
        }

        return redirect()->back()->with('success', $message);
    }

    // ========================================================================
    // 9. View Detailed Account Profile & Ledger
    // ========================================================================
    public function showVirtualAccount($id)
    {
        $merchant = \App\Models\Merchant::current();

        $account = DB::table('virtual_accounts')
            ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
            ->where('virtual_accounts.id', $id)
            ->where('agents.merchant_id', $merchant->id)
            ->select(
                'virtual_accounts.*', 
                'agents.first_name', 'agents.last_name', 'agents.email', 
                'agents.phone_number', 'agents.bvn', 'agents.nin', 'agents.date_of_birth'
            )
            ->first();

        if (!$account) {
            return redirect()->route('merchant.virtual-accounts.index')->withErrors(['Account not found or access denied.']);
        }

        $transactions = [];
        if (\Illuminate\Support\Facades\Schema::hasTable('transactions')) {
            $transactions = DB::table('transactions')
                ->where('virtual_account_id', $account->id)
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
        }

        return view('merchant.virtual-accounts.show', compact('account', 'transactions'));
    }

    // ========================================================================
    // 10. Update Agent Details (Option 1)
    // ========================================================================
    public function updateAgentDetails(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
        ]);

        $account = DB::table('virtual_accounts')->where('id', $id)->first();
        
        DB::table('agents')->where('id', $account->agent_id)->update([
            'email' => $request->email,
            'phone_number' => $request->phone,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Agent contact details updated successfully!');
    }

    // ========================================================================
    // 11. Mock Bank Transfer (Option 2)
    // ========================================================================
    public function mockTransaction($id)
    {
        $amount = rand(1500, 75000); 
        $merchant = \App\Models\Merchant::current();

        DB::transaction(function () use ($id, $amount, $merchant) {
            
            $account = DB::table('virtual_accounts')->where('id', $id)->first();
            
            $balanceBefore = $account->ledger_balance;
            $balanceAfter = $balanceBefore + $amount;

            DB::table('transactions')->insert([
                'virtual_account_id' => $account->id,
                'merchant_id' => $merchant->id,
                'session_id' => 'SESS-' . time() . '-' . strtoupper(Str::random(6)), 
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'type' => 'credit',
                'status' => 'successful',
                'remarks' => 'Mock Funding Transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('virtual_accounts')
                ->where('id', $id)
                ->update([
                    'ledger_balance' => $balanceAfter,
                    'updated_at' => now()
                ]);

            // 🟢 FIXED: Ensure the central merchant wallet is also credited!
            // Otherwise the merchant's wallet_balance remains 0 and goes negative during VAS purchases.
            DB::table('merchants')
                ->where('id', $merchant->id)
                ->increment('wallet_balance', $amount);
        });

        return redirect()->back()->with('success', 'Test transfer of ₦' . number_format($amount, 2) . ' received successfully!');
    }

    // ========================================================================
    // 12. Export Statement to CSV (Option 2)
    // ========================================================================
    public function exportStatement($id)
    {
        $account = DB::table('virtual_accounts')->where('id', $id)->first();
        $transactions = DB::table('transactions')->where('virtual_account_id', $id)->orderBy('created_at', 'desc')->get();

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=Statement_' . $account->account_number . '.csv',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Session ID', 'Type', 'Amount (NGN)', 'Balance After (NGN)', 'Status']);
            
            foreach ($transactions as $trx) {
                fputcsv($file, [
                    Carbon::parse($trx->created_at)->format('Y-m-d H:i:s'),
                    $trx->session_id, 
                    ucfirst($trx->type),
                    $trx->amount,
                    $trx->balance_after,
                    ucfirst($trx->status)
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ========================================================================
    // 13. Sub-Agents CRM Dashboard
    // ========================================================================
    public function subAgentsIndex()
    {
        $merchant = \App\Models\Merchant::current();

        $agents = DB::table('agents')
            ->leftJoin('virtual_accounts', 'agents.id', '=', 'virtual_accounts.agent_id')
            ->where('agents.merchant_id', $merchant->id)
            ->select(
                'agents.id',
                'agents.first_name',
                'agents.last_name',
                'agents.email',
                'agents.phone_number',
                'agents.bvn',
                'agents.nin',
                'agents.kyc_status', 
                DB::raw('COUNT(virtual_accounts.id) as account_count'),
                DB::raw('COALESCE(SUM(virtual_accounts.ledger_balance), 0) as total_balance')
            )
            ->groupBy(
                'agents.id', 
                'agents.first_name', 
                'agents.last_name', 
                'agents.email', 
                'agents.phone_number', 
                'agents.bvn', 
                'agents.nin',
                'agents.kyc_status' 
            )
            ->orderBy('agents.created_at', 'desc')
            ->get();

        return view('merchant.sub-agents.index', compact('agents'));
    }

    // ========================================================================
    // 14. Master Transaction Ledger
    // ========================================================================
    public function transactionLedger()
    {
        $merchant = \App\Models\Merchant::current();

        $transactions = DB::table('transactions')
            ->join('virtual_accounts', 'transactions.virtual_account_id', '=', 'virtual_accounts.id')
            ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
            ->where('agents.merchant_id', $merchant->id)
            ->select(
                'transactions.id',
                'transactions.session_id as reference', 
                'transactions.amount',
                'transactions.type',
                'transactions.status',
                'transactions.created_at',
                'virtual_accounts.account_number',
                'virtual_accounts.bank_name',
                'agents.first_name',
                'agents.last_name'
            )
            ->orderBy('transactions.created_at', 'desc')
            ->paginate(15);

        return view('merchant.ledger.index', compact('transactions'));
    }

    // ========================================================================
    // 15. Settlements & Payouts Dashboard
    // ========================================================================
    public function settlementsIndex()
    {
        $merchant = \App\Models\Merchant::current();

        $availableBalance = DB::table('virtual_accounts')
            ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
            ->where('agents.merchant_id', $merchant->id)
            ->sum('virtual_accounts.ledger_balance');

        try {
            $savedBanks = DB::table('merchant_bank_accounts')
                ->where('merchant_id', $merchant->id)
                ->get();
        } catch (\Exception $e) {
            $savedBanks = collect([]); 
        }

        try {
            $payouts = DB::table('merchant_payouts')
                ->join('merchant_bank_accounts', 'merchant_payouts.bank_account_id', '=', 'merchant_bank_accounts.id')
                ->where('merchant_payouts.merchant_id', $merchant->id)
                ->select('merchant_payouts.*', 'merchant_bank_accounts.bank_name', 'merchant_bank_accounts.account_number')
                ->orderBy('merchant_payouts.created_at', 'desc')
                ->get();
        } catch (\Exception $e) {
            $payouts = collect([]); 
        }

        return view('merchant.settlements.index', compact('availableBalance', 'savedBanks', 'payouts'));
    }

    // ========================================================================
    // 16. Developer API Keys Dashboard
    // ========================================================================
    public function apiKeysIndex()
    {
        $merchant = \App\Models\Merchant::current();

        try {
            $apiKeys = DB::table('api_keys')
                ->where('merchant_id', $merchant->id)
                ->first();
        } catch (\Exception $e) {
            $apiKeys = null;
        }

        try {
            $kycRecord = \App\Models\MerchantKyc::where('user_id', $merchant->id)->first();
        } catch (\Exception $e) {
            $kycRecord = null;
        }

        return view('merchant.api-keys.index', compact('apiKeys', 'kycRecord'));
    }

    // ========================================================================
    // 17. Developer Webhooks Dashboard
    // ========================================================================
    public function webhooksIndex()
    {
        $merchant = \App\Models\Merchant::current();

        try {
            $webhookConfig = DB::table('webhook_endpoints')
                ->where('merchant_id', $merchant->id)
                ->first();
        } catch (\Exception $e) {
            $webhookConfig = null;
        }

        $recentDeliveries = \App\Models\WebhookDelivery::where('merchant_id', $merchant->id)
                                ->orderBy('created_at', 'desc')
                                ->limit(20)
                                ->get();

        return view('merchant.webhooks.index', compact('webhookConfig', 'recentDeliveries'));
    }

    // ========================================================================
    // 18. Handle Webhook Configuration Saving
    // ========================================================================
    public function updateWebhooks(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'live_url' => 'nullable|url|max:255',
            'test_url' => 'nullable|url|max:255',
        ]);

        $merchant = \App\Models\Merchant::current();

        $existingConfig = DB::table('webhook_endpoints')
            ->where('merchant_id', $merchant->id)
            ->first();

        $secret = $existingConfig ? $existingConfig->secret : 'whsec_' . bin2hex(random_bytes(16));

        DB::table('webhook_endpoints')->updateOrInsert(
            ['merchant_id' => $merchant->id],
            [
                'live_url' => $request->live_url,
                'test_url' => $request->test_url,
                'secret' => $secret,
                'updated_at' => now(),
                'created_at' => $existingConfig ? $existingConfig->created_at : now(),
            ]
        );

        $this->logAuditAction('updated_webhooks', 'webhooks', 'Updated webhook configuration', null, [
            'live_url' => $request->live_url,
            'test_url' => $request->test_url
        ]);

        return redirect()->back()->with('success', 'Webhook endpoints updated successfully!');
    }

    public function testWebhook(\Illuminate\Http\Request $request)
    {
        $merchant = \App\Models\Merchant::current();
        
        $config = DB::table('webhook_endpoints')
            ->where('merchant_id', $merchant->id)
            ->first();

        $targetUrl = $request->input('target_url', $config->test_url ?? $config->live_url ?? null);
        
        if (!$targetUrl) {
            return back()->withErrors(['error' => 'No webhook URL configured or provided for testing.']);
        }

        $payload = [
            'event' => 'transaction.successful',
            'data' => [
                'reference' => 'TEST_REF_' . time(),
                'amount' => 5000.00,
                'status' => 'successful',
                'customer' => [
                    'name' => 'John Doe',
                    'email' => 'john.doe@example.com'
                ]
            ]
        ];

        // Ensure we have a secret to sign with, or fake one
        $secret = $config->secret ?? 'test_secret_key';
        $signature = hash_hmac('sha512', json_encode($payload), $secret);

        $start = microtime(true);
        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'x-q4i-signature' => $signature,
                'Content-Type' => 'application/json'
            ])->timeout(10)->post($targetUrl, $payload);
            
            $timeMs = round((microtime(true) - $start) * 1000);
            
            \App\Models\WebhookDelivery::create([
                'merchant_id' => $merchant->id,
                'event' => 'test.transaction.successful',
                'webhook_url' => $targetUrl,
                'payload' => $payload,
                'response_headers' => $response->headers(),
                'response_body' => $response->body(),
                'response_status' => $response->status(),
                'is_successful' => $response->successful(),
                'processing_time_ms' => $timeMs
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Test webhook sent successfully. Server responded with: ' . $response->status());
            } else {
                return back()->withErrors(['error' => 'Webhook test failed. Server responded with: ' . $response->status() . '. Check the delivery logs for details.']);
            }
        } catch (\Exception $e) {
            $timeMs = round((microtime(true) - $start) * 1000);
            
            \App\Models\WebhookDelivery::create([
                'merchant_id' => $merchant->id,
                'event' => 'test.transaction.successful',
                'webhook_url' => $targetUrl,
                'payload' => $payload,
                'response_body' => 'Error: ' . $e->getMessage(),
                'is_successful' => false,
                'processing_time_ms' => $timeMs
            ]);

            return back()->withErrors(['error' => 'Webhook test failed: ' . $e->getMessage()]);
        }
    }

    // ========================================================================
    // 19. API Documentation
    // ========================================================================
    public function apiDocsIndex()
    {
        $merchant = \App\Models\Merchant::current();
        return view('merchant.api-keys.docs', compact('merchant'));
    }

    // ========================================================================
    // 20. Handle API Key Generation & Rolling
    // ========================================================================
    public function generateApiKeys(\Illuminate\Http\Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        $generateKey = function ($prefix) {
            return $prefix . '_' . bin2hex(random_bytes(16));
        };

        $rollLiveSecretOnly = $request->input('action') === 'roll_live_secret';
        $existingKeys = DB::table('api_keys')->where('merchant_id', $merchant->id)->first();

        if ($rollLiveSecretOnly && $existingKeys) {
            DB::table('api_keys')
                ->where('merchant_id', $merchant->id)
                ->update([
                    'live_secret_key' => $generateKey('sk_live'),
                    'updated_at' => now(),
                ]);
            $this->logAuditAction('rolled_live_secret', 'api_keys', 'Rolled Live Secret Key');
            $message = 'Live Secret Key successfully rolled. Your old key is now invalid.';
        } else {
            DB::table('api_keys')->updateOrInsert(
                ['merchant_id' => $merchant->id],
                [
                    'test_public_key' => $existingKeys->test_public_key ?? $generateKey('pk_test'),
                    'test_secret_key' => $existingKeys->test_secret_key ?? $generateKey('sk_test'),
                    'live_public_key' => $existingKeys->live_public_key ?? $generateKey('pk_live'),
                    'live_secret_key' => $existingKeys->live_secret_key ?? $generateKey('sk_live'),
                    'updated_at' => now(),
                    'created_at' => $existingKeys ? $existingKeys->created_at : now(),
                ]
            );
            $this->logAuditAction('generated_api_keys', 'api_keys', 'Generated API Keys');
            $message = 'API Keys generated successfully!';
        }

        return redirect()->back()->with('success', $message);
    }

    // ========================================================================
    // 20. Handle Adding Settlement Bank Accounts
    // ========================================================================
    public function addBankAccount(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'account_name' => 'required|string|max:255',
        ]);

        $merchant = \App\Models\Merchant::current();

        try {
            $isFirstAccount = DB::table('merchant_bank_accounts')
                ->where('merchant_id', $merchant->id)
                ->count() === 0;

            DB::table('merchant_bank_accounts')->insert([
                'merchant_id' => $merchant->id,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'is_default' => $isFirstAccount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return redirect()->back()->with('success', 'Corporate Settlement account added successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Database Error: ' . $e->getMessage()]);
        }
    }

    // ========================================================================
    // 21. Handle Payout Requests
    // ========================================================================
    public function requestPayout(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'bank_account_id' => 'required'
        ]);

        $merchant = \App\Models\Merchant::current();
        $reference = 'PO-' . strtoupper(Str::random(10));

        DB::table('merchant_payouts')->insert([
            'merchant_id' => $merchant->id,
            'bank_account_id' => $request->bank_account_id,
            'reference' => $reference,
            'amount' => $request->amount,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Payout request for ₦' . number_format($request->amount, 2) . ' submitted successfully. It is currently being processed.');
    }

    // ========================================================================
    // 22. Transaction Ledger Dashboard (WITH FILTERS)
    // ========================================================================
    public function ledgerIndex(\Illuminate\Http\Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        try {
            $query = DB::table('transactions')
                ->join('virtual_accounts', 'transactions.virtual_account_id', '=', 'virtual_accounts.id')
                ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
                ->where('agents.merchant_id', $merchant->id)
                ->select(
                    'transactions.*', 
                    'transactions.session_id as reference', 
                    'agents.first_name', 
                    'agents.last_name', 
                    'virtual_accounts.account_number',
                    'virtual_accounts.bank_name'
                );

            if ($request->filled('type')) {
                $query->where('transactions.type', $request->type);
            }

            if ($request->filled('status')) {
                $query->where('transactions.status', $request->status);
            }

            if ($request->filled('category')) {
                $query->where('transactions.remarks', 'like', '%' . $request->category . '%');
            }

            if ($request->filled('date')) {
                $query->whereDate('transactions.created_at', $request->date);
            }

            $transactions = $query->orderBy('transactions.created_at', 'desc')->paginate(15);
                
        } catch (\Exception $e) {
            dd("Database Error in Ledger: " . $e->getMessage()); 
        }

        return view('merchant.ledger.index', compact('transactions'));
    }

    // ========================================================================
    // 23. Export Transaction Ledger to CSV
    // ========================================================================
    public function exportLedger(\Illuminate\Http\Request $request)
    {
        $merchant = \App\Models\Merchant::current();
        $fileName = 'Q4I_Ledger_' . now()->format('Y_m_d_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        try {
            $query = DB::table('transactions')
                ->join('virtual_accounts', 'transactions.virtual_account_id', '=', 'virtual_accounts.id')
                ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
                ->where('agents.merchant_id', $merchant->id)
                ->select(
                    'transactions.session_id as reference', 
                    'transactions.created_at',
                    'agents.first_name',
                    'agents.last_name',
                    'virtual_accounts.account_number',
                    'transactions.type',
                    'transactions.amount',
                    'transactions.status'
                );

            if ($request->filled('type')) {
                $query->where('transactions.type', $request->type);
            }
            if ($request->filled('status')) {
                $query->where('transactions.status', $request->status);
            }
            if ($request->filled('category')) {
                $query->where('transactions.remarks', 'like', '%' . $request->category . '%');
            }
            if ($request->filled('date')) {
                $query->whereDate('transactions.created_at', $request->date);
            }

            $transactions = $query->orderBy('transactions.created_at', 'desc')->get();
            $columns = ['Date', 'Session ID', 'Sub-Agent', 'Bank Account', 'Type', 'Amount (NGN)', 'Status'];

            $callback = function() use($transactions, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($transactions as $txn) {
                    $row['Date']       = Carbon::parse($txn->created_at)->format('Y-m-d H:i:s');
                    $row['Reference'] = $txn->reference; 
                    $row['Sub-Agent']  = $txn->first_name . ' ' . $txn->last_name;
                    $row['Bank Account'] = '9PSB • ' . $txn->account_number;
                    $row['Type']       = ucfirst($txn->type);
                    $row['Amount']     = $txn->amount;
                    $row['Status']     = ucfirst($txn->status);

                    fputcsv($file, array($row['Date'], $row['Reference'], $row['Sub-Agent'], $row['Bank Account'], $row['Type'], $row['Amount'], $row['Status']));
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Export failed: ' . $e->getMessage()]);
        }
    }

    // ========================================================================
    // 24. Store New Sub-Agent & Provision Virtual Account
    // ========================================================================
    public function storeAgent(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'dob' => 'required|date',
            'bvn' => 'required|string|size:11',
            'nin' => 'required|string|size:11',
        ]);

        $merchant = \App\Models\Merchant::current();

        $nameParts = explode(' ', $request->name, 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? 'Branch';
        
        $merchantReference = 'AGT-' . strtoupper(Str::random(8));

        try {
            DB::transaction(function () use ($merchant, $merchantReference, $firstName, $lastName, $request) {
                // 1. Create the Agent
                $agentId = DB::table('agents')->insertGetId([
                    'merchant_id' => $merchant->id,
                    'merchant_reference' => $merchantReference, 
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $request->email,
                    'phone_number' => $request->phone,
                    'date_of_birth' => $request->dob, 
                    'bvn' => $request->bvn,
                    'nin' => $request->nin,
                    'kyc_status' => 'verified',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 2. Automatically Provision the 9PSB Virtual Account
                $generatedAccountNumber = (string) rand(8000000000, 8999999999);
                $generatedCustomerId = 'CUST-' . strtoupper(Str::random(10));
                $generatedOrderRef = 'ORD-' . strtoupper(Str::random(10)); 

                $userId = DB::table('users')->value('id') ?? 1;

                DB::table('virtual_accounts')->insert([
                    'user_id' => $userId, 
                    'agent_id' => $agentId,
                    'customer_id' => $generatedCustomerId, 
                    'bank_name' => '9PSB',
                    'account_number' => $generatedAccountNumber,
                    'order_ref' => $generatedOrderRef, 
                    'ledger_balance' => 0.00,
                    'is_active' => true, 
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

            return redirect()->back()->with('success', 'Sub-Agent created successfully! 9PSB Virtual Account provisioned.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to provision account: ' . $e->getMessage()]);
        }
    }

    // ========================================================================
    // 25. Show Specific Sub-Agent Profile
    // ========================================================================
    public function showAgent($id)
    {
        $merchant = \App\Models\Merchant::current();

        $agent = DB::table('agents')
            ->where('id', $id)
            ->where('merchant_id', $merchant->id)
            ->first();

        if (!$agent) {
            return redirect()->back()->withErrors(['error' => 'Agent not found or unauthorized.']);
        }

        $virtualAccounts = DB::table('virtual_accounts')
            ->where('agent_id', $agent->id)
            ->get();

        $transactions = DB::table('transactions')
            ->join('virtual_accounts', 'transactions.virtual_account_id', '=', 'virtual_accounts.id')
            ->where('virtual_accounts.agent_id', $agent->id)
            ->select('transactions.*', 'virtual_accounts.account_number')
            ->orderBy('transactions.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('merchant.sub-agents.show', compact('agent', 'virtualAccounts', 'transactions'));
    }

    // ========================================================================
    // 26. Update Existing Sub-Agent Profile (With KYC Safety Locks)
    // ========================================================================
    public function updateAgent(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'dob' => 'required|date',
        ]);

        $merchant = \App\Models\Merchant::current();

        try {
            $agent = DB::table('agents')
                ->where('id', $id)
                ->where('merchant_id', $merchant->id)
                ->first();

            if (!$agent) {
                return redirect()->back()->withErrors(['error' => 'Agent not found.']);
            }

            $identityChanged = false;
            if (
                $agent->first_name !== $request->first_name || 
                $agent->last_name !== $request->last_name || 
                $agent->date_of_birth !== $request->dob
            ) {
                $identityChanged = true;
            }

            DB::table('agents')
                ->where('id', $id)
                ->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone_number' => $request->phone,
                    'date_of_birth' => $request->dob,
                    'kyc_status' => $identityChanged ? 'pending_reverification' : $agent->kyc_status,
                    'updated_at' => now(),
                ]);

            if ($identityChanged) {
                return redirect()->back()->with('success', 'Profile updated! Identity changes detected: KYC re-verification has been automatically queued.');
            }

            return redirect()->back()->with('success', 'Agent contact details updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update profile: ' . $e->getMessage()]);
        }
    }

    // ========================================================================
    // 27. Specific Virtual Account Details
    // ========================================================================
    public function virtualAccountDetails($id)
    {
        $merchant = \App\Models\Merchant::current();

        $account = DB::table('virtual_accounts')
            ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
            ->where('virtual_accounts.id', $id)
            ->where('agents.merchant_id', $merchant->id)
            ->select(
                'virtual_accounts.*', 
                'agents.first_name', 
                'agents.last_name', 
                'agents.email', 
                'agents.phone_number', 
                'agents.merchant_reference',
                'agents.date_of_birth', 
                'agents.bvn',           
                'agents.nin'            
            )
            ->first();

        if (!$account) {
            return redirect('/merchant/virtual-accounts')->withErrors(['error' => 'Account not found or unauthorized.']);
        }

        $transactions = DB::table('transactions')
            ->where('virtual_account_id', $account->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('merchant.virtual-accounts.show', compact('account', 'transactions'));
    }

    // ========================================================================
    // 28. Simulate an Incoming Transfer
    // ========================================================================
    public function mockVirtualAccountTransaction($id)
    {
        $account = DB::table('virtual_accounts')->where('id', $id)->first();
        if (!$account) return back()->withErrors(['error' => 'Account not found.']);

        $amount = rand(5000, 50000); 
        
        DB::table('transactions')->insert([
            'virtual_account_id' => $account->id,
            'session_id' => 'MOCK-' . strtoupper(Str::random(12)),
            'type' => 'credit',
            'amount' => $amount,
            'status' => 'successful',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('virtual_accounts')
            ->where('id', $id)
            ->increment('ledger_balance', $amount);

        return back()->with('success', 'Mock transfer of ₦' . number_format($amount, 2) . ' received successfully!');
    }

    // ========================================================================
    // 29. Export Node Statement
    // ========================================================================
    public function exportVirtualAccountStatement($id)
    {
        $transactions = DB::table('transactions')
            ->where('virtual_account_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $fileName = 'statement_node_' . $id . '_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Date', 'Session ID', 'Type', 'Amount', 'Status'];

        $callback = function() use($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($transactions as $txn) {
                fputcsv($file, [
                    $txn->created_at,
                    $txn->session_id,
                    strtoupper($txn->type),
                    $txn->amount,
                    $txn->status
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ========================================================================
    // 30. Update Contact Details from Modal
    // ========================================================================
    public function updateVirtualAccountContact(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        $account = DB::table('virtual_accounts')->where('id', $id)->first();
        if (!$account) return back()->withErrors(['error' => 'Account not found.']);

        DB::table('agents')->where('id', $account->agent_id)->update([
            'email' => $request->email,
            'phone_number' => $request->phone,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Contact details updated successfully!');
    }

    // ========================================================================
    // 31. Load the VAS & Utility Dashboard UI
    // ========================================================================
    public function vasIndex()
    {
        $merchant = \App\Models\Merchant::current();
        
        $accounts = \App\Models\VirtualAccount::whereHas('agent', function($q) use ($merchant) {
            $q->where('merchant_id', $merchant->id);
        })->where('is_active', true)->get();

        return view('merchant.vas.index', compact('merchant', 'accounts'));
    }

    // ==========================================
    // 32. TEMPORARY VAs & PAYMENT LINKS
    // ==========================================
    public function paymentLinksIndex()
    {
        $merchant = \App\Models\Merchant::current();
        
        $paymentLinks = DB::table('payment_links')
            ->where('merchant_id', $merchant->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('merchant.payment-links.index', compact('merchant', 'paymentLinks'));
    }

    public function createPaymentLink(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:100',
            'customer_email' => 'nullable|email' 
        ]);

        $merchant = $request->user();
        
        $reference = 'Q4I-' . strtoupper(Str::random(8));
        
        try {
            DB::table('payment_links')->insert([
                'merchant_id' => $merchant->id,
                'title' => $validated['title'],
                'amount' => $validated['amount'],
                'reference' => $reference,
                'is_active' => true, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return redirect()->back()->with('success', 'Payment Link generated successfully! Ref: ' . $reference);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Payment Link Error: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Could not generate link: ' . $e->getMessage()]);
        }
    }
}