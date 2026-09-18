<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Merchant;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProcessAutoSweeps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-auto-sweeps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process automated withdrawals for merchants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting automated sweeps processing...');
        Log::info('ProcessAutoSweeps: Starting execution');

        // Fetch merchants with auto_sweep enabled
        $merchants = Merchant::where('auto_sweep_enabled', true)
            ->whereNotNull('auto_sweep_bank_account_id')
            ->get();

        $processedCount = 0;

        foreach ($merchants as $merchant) {
            $shouldSweep = false;
            $frequency = $merchant->auto_sweep_frequency;
            $balance = $merchant->wallet_balance;

            // Check if already swept today (to prevent multiple daily sweeps)
            $alreadySweptToday = \App\Models\Transaction::where('merchant_id', $merchant->id)
                ->where('type', 'debit')
                ->where('remarks', 'LIKE', 'Auto-Sweep%')
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            // Determine if sweep condition is met
            if ($frequency === 'daily' && !$alreadySweptToday) {
                $shouldSweep = true; 
            } elseif ($frequency === 'weekly' && now()->isFriday() && !$alreadySweptToday) {
                $shouldSweep = true;
            } elseif ($frequency === 'threshold' && $balance >= $merchant->auto_sweep_threshold) {
                $shouldSweep = true;
            }

            // Execute sweep if condition met and balance is > 100 (for fee)
            if ($shouldSweep && $balance > 100) {
                try {
                    // Create dummy request to reuse SettlementController logic, or extract logic to a Service class
                    // Since it's better to use a service, I'll instantiate SettlementController for now 
                    // However, we can't easily mock the Request with Auth without complications.
                    
                    // We'll write the direct logic here or extract to a service later. 
                    $withdrawalAmount = $balance - 100; // Deduct N100 fee
                    
                    if ($withdrawalAmount >= 100) { // Minimum withdrawal amount
                        $this->info("Processing sweep for Merchant {$merchant->id}, Amount: {$withdrawalAmount}");
                        
                        $bank = \Illuminate\Support\Facades\DB::table('merchant_bank_accounts')->where('id', $merchant->auto_sweep_bank_account_id)->first();
                        
                        if (!$bank) {
                            Log::warning("Auto-Sweep: Bank account not found for merchant {$merchant->id}");
                            continue;
                        }

                        // Emulate the controller logic
                        $q4iFee = 100.00;
                        $techvibsCost = 13.00;
                        $q4iProfit = $q4iFee - $techvibsCost;
                        $totalDeduction = $withdrawalAmount + $q4iFee;
                        
                        $txnRef = 'Q4I-SWEEP-' . time() . '-' . rand(1000, 9999);
                        
                        $account = \App\Models\VirtualAccount::whereHas('agent', function($q) use ($merchant) {
                            $q->where('merchant_id', $merchant->id);
                        })->first();

                        $balanceBefore = $merchant->wallet_balance;
                        $balanceAfter = $balanceBefore - $totalDeduction;

                        \Illuminate\Support\Facades\DB::beginTransaction();
                        
                        $merchant->decrement('wallet_balance', $totalDeduction);

                        $transaction = \App\Models\Transaction::create([
                            'virtual_account_id' => $account ? $account->id : null,
                            'merchant_id' => $merchant->id,
                            'session_id' => $txnRef,
                            'type' => 'debit',
                            'amount' => $withdrawalAmount,
                            'fee_charged' => $q4iFee,
                            'settled_amount' => $totalDeduction,
                            'balance_before' => $balanceBefore,
                            'balance_after' => $balanceAfter,
                            'status' => 'pending', 
                            'remarks' => "Auto-Sweep to {$bank->bank_name} ({$bank->account_number})"
                        ]);
                        
                        \Illuminate\Support\Facades\DB::table('system_earnings')->insert([
                            'transaction_ref' => $txnRef,
                            'merchant_id' => $merchant->id,
                            'type' => 'merchant_outflow_profit',
                            'amount' => $q4iProfit,
                            'created_at' => now()
                        ]);
                        
                        \Illuminate\Support\Facades\DB::commit();

                        $merchant->notify(new \App\Notifications\SecurityAlert(
                            'Automated Withdrawal Initiated',
                            'An automated withdrawal of ₦' . number_format($withdrawalAmount) . ' to ' . $bank->bank_name . ' (' . $bank->account_number . ') has been initiated.',
                            'outflow'
                        ));

                        try {
                            $transferService = new \App\Services\NinePsbTransferService();
                            $transferResponse = $transferService->transferToOtherBank([
                                'bank_code' => $bank->bank_code,
                                'account_number' => $bank->account_number,
                                'account_name' => $bank->account_name,
                                'amount' => $withdrawalAmount,
                                'reference' => $txnRef,
                                'narration' => "Auto-Sweep to {$bank->bank_name} ({$bank->account_number}) from {$merchant->business_name}"
                            ]);

                            if (isset($transferResponse['code']) && $transferResponse['code'] === '00') {
                                $transaction->update(['status' => 'successful']);
                                $this->info("Sweep successful for Merchant {$merchant->id}");
                            } else {
                                Log::warning('Auto-Sweep 9PSB Transfer Pending/Failed: ', ['response' => $transferResponse]);
                                $this->error("Sweep pending/failed for Merchant {$merchant->id}");
                            }

                        } catch (\Exception $e) {
                            Log::error("Auto-Sweep 9PSB Error: " . $e->getMessage());
                            $this->error("Sweep error for Merchant {$merchant->id}: " . $e->getMessage());
                        }

                        $processedCount++;
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\DB::rollBack();
                    Log::error("Auto-Sweep Crash for Merchant {$merchant->id}: " . $e->getMessage());
                }
            }
        }

        $this->info("Automated sweeps completed. Processed: {$processedCount}");
        Log::info("ProcessAutoSweeps: Completed execution. Processed: {$processedCount}");
    }
}
