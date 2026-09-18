<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SweepPlatformProfits extends Command
{
    // The command you type in the terminal to run this manually
    protected $signature = 'q4i:sweep-profits';
    protected $description = 'Sweeps accumulated N5 and N18 fees to the Q4I Corporate Bank Account';

    public function handle()
    {
        $this->info('Starting Q4I Profit Sweep...');

        // 1. Find all successful transactions that charged a fee, but haven't been swept yet
        $unsweptTransactions = Transaction::where('status', 'successful')
            ->where('fee_charged', '>', 0)
            ->where('is_swept', false)
            ->get();

        if ($unsweptTransactions->isEmpty()) {
            $this->info('No new profits to sweep today.');
            return;
        }

        // 2. Calculate the total profit pool
        $totalProfit = $unsweptTransactions->sum('fee_charged');
        $this->info("Total profit to sweep: NGN {$totalProfit}");

        // If the profit is too small to cover a standard bank transfer fee, skip it until tomorrow
        if ($totalProfit < 50) {
            $this->info('Profit is too low to sweep. Waiting for more volume.');
            return;
        }

        $txnRef = 'Q4I-SWEEP-' . time();

        // 3. Fire the outward transfer using your Master Techvibes Token
        try {
            // Note: In production, add these variables to your .env file!
            $corporateAccount = env('Q4I_CORPORATE_ACCOUNT_NUMBER', '0123456789'); // Your actual GTB/Moniepoint number
            $corporateBankCode = env('Q4I_CORPORATE_BANK_CODE', '058'); // Your actual Bank Code
            $masterToken = env('TECHVIBES_LIVE_TOKEN');

            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $masterToken
                ])
                ->post('https://techvibs.com/waas9/transfer_external_fintech_token.php', [
                    'token' => $masterToken,
                    'transactionReference' => $txnRef,
                    // Q4I's master virtual account number at Techvibes (Where the pool sits)
                    'sourceAccountNumber' => env('Q4I_MASTER_VIRTUAL_ACCOUNT', 'YOUR_MASTER_ACCOUNT'), 
                    'destinationAccountNumber' => $corporateAccount,
                    'destinationBankCode' => $corporateBankCode,
                    'destinationAccountName' => 'Q4I LIMITED',
                    'senderName' => 'Q4I Auto-Sweep',
                    'amount' => $totalProfit,
                    'currency' => 'NGN',
                    'narration' => 'Daily Platform Revenue Sweep',
                    'description' => 'Profit Extraction'
                ]);

            $apiResult = $response->json();

            if ($response->successful() && isset($apiResult['success']) && $apiResult['success'] === true) {
                // 4. Mark all those transactions as successfully swept!
                DB::beginTransaction();
                try {
                    foreach ($unsweptTransactions as $txn) {
                        $txn->update(['is_swept' => true]);
                    }
                    DB::commit();
                    $this->info('Sweep Successful! Money is on the way to Q4I Limited.');
                    Log::info("EOD Sweep Successful: NGN {$totalProfit} transferred to corporate account.");
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Sweep failed to update database: ' . $e->getMessage());
                }
            } else {
                $this->error('Techvibes Transfer Failed: ' . json_encode($apiResult));
                Log::error('EOD Sweep Failed at Bank Level: ' . json_encode($apiResult));
            }

        } catch (\Exception $e) {
            $this->error('System Error during sweep: ' . $e->getMessage());
            Log::error('EOD Sweep Crash: ' . $e->getMessage());
        }
    }
}