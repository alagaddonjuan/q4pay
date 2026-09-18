<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ProcessAgentBulkImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     * Set high because API calls and large CSVs take time.
     */
    public $timeout = 3600; // 1 hour

    protected $merchantId;
    protected $filePath;
    protected $batchId;

    public function __construct($merchantId, $filePath, $batchId)
    {
        $this->merchantId = $merchantId;
        $this->filePath = $filePath;
        $this->batchId = $batchId;
    }

    public function handle(): void
    {
        $fullPath = Storage::disk('local')->path($this->filePath);
        
        if (!file_exists($fullPath)) {
            Log::error("Bulk Import Failed: File not found at {$fullPath}");
            DB::table('bulk_imports')->where('batch_id', $this->batchId)->update(['status' => 'failed']);
            return;
        }

        $file = fopen($fullPath, 'r');
        
        // Count total rows quickly for the progress bar (subtract 1 for header)
        $totalRows = count(file($fullPath)) - 1; 
        
        DB::table('bulk_imports')->where('batch_id', $this->batchId)->update([
            'total_rows' => $totalRows
        ]);

        $header = fgetcsv($file); // Skip headers

        $successCount = 0;
        $failCount = 0;
        $processedCount = 0;

        while (($row = fgetcsv($file, 1000, ',')) !== FALSE) {
            
            // Expected CSV Format: ['Name', 'Email', 'Phone', 'Date of Birth (YYYY-MM-DD)', 'BVN', 'NIN']
            if (count($row) < 6 || empty(trim($row[0]))) {
                $failCount++;
                $this->updateProgress($processedCount++, $successCount, $failCount);
                continue; 
            }

            try {
                DB::transaction(function () use ($row) {
                    $nameParts = explode(' ', trim($row[0]), 2);
                    $firstName = $nameParts[0];
                    $lastName = $nameParts[1] ?? 'Agent';
                    $email = trim($row[1]);
                    $phone = trim($row[2]); 
                    $dob = trim($row[3]);
                    $bvn = trim($row[4]);
                    $nin = trim($row[5]);

                    // 1. Create the Agent Profile
                    $agentId = DB::table('agents')->insertGetId([
                        'merchant_id' => $this->merchantId,
                        'merchant_reference' => 'AGT-' . strtoupper(Str::random(8)), 
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'phone_number' => $phone, 
                        'date_of_birth' => $dob,
                        'bvn' => $bvn,
                        'nin' => $nin,
                        'kyc_status' => 'verified',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // 2. Call 9PSB to provision the Virtual Account
                    $txnReference = 'Q4I_BULK_' . time() . rand(100, 999);
                    
                    $virtualAccountService = new \App\Services\NinePsbVirtualAccountService();
                    $apiData = $virtualAccountService->createVirtualAccount([
                        "transaction" => ["reference" => $txnReference],
                        "order" => ["amount" => 0, "currency" => "NGN", "description" => "Sub-Agent Collection Account", "country" => "NGA", "amounttype" => "ANY"],
                        "customer" => ["account" => ["name" => $firstName . ' ' . $lastName, "type" => "STATIC"]]
                    ]);

                    if (!isset($apiData['message']) || strtolower($apiData['message']) !== 'success' || !isset($apiData['customer']['account']['number'])) {
                        throw new \Exception("Banking API rejected account creation for {$phone}. " . ($apiData['message'] ?? ''));
                    }

                    // 3. Save the Virtual Account
                    $userId = DB::table('users')->value('id') ?? 1;

                    DB::table('virtual_accounts')->insert([
                        'user_id' => $userId,
                        'agent_id' => $agentId,
                        'account_number' => $apiData['customer']['account']['number'], 
                        'bank_name' => '9PSB',
                        'customer_id' => $apiData['customer']['id'] ?? null,      
                        'order_ref' => $txnReference,           
                        'ledger_balance' => 0.00,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                });

                $successCount++;
                
                // Rate Limiting: Sleep for 0.5 seconds between API calls to prevent 9PSB from banning your server IP
                usleep(500000); 

            } catch (\Exception $e) {
                Log::warning("Bulk Import Row Failed [Batch: {$this->batchId}]: " . $e->getMessage());
                $failCount++;
            }

            // Update DB progress every 10 rows to prevent database thrashing
            $processedCount++;
            if ($processedCount % 10 === 0) {
                $this->updateProgress($processedCount, $successCount, $failCount);
            }
        }

        fclose($file);
        
        // Final update and cleanup
        DB::table('bulk_imports')->where('batch_id', $this->batchId)->update([
            'successful_rows' => $successCount,
            'failed_rows' => $failCount,
            'status' => 'completed',
            'updated_at' => now()
        ]);

        Storage::disk('local')->delete($this->filePath); 
        Log::info("Bulk import [{$this->batchId}] completed. Success: {$successCount}, Failed: {$failCount}");
    }

    /**
     * Helper to update the tracking ledger
     */
    private function updateProgress($processed, $success, $failed)
    {
        DB::table('bulk_imports')->where('batch_id', $this->batchId)->update([
            'successful_rows' => $success,
            'failed_rows' => $failed,
            'updated_at' => now()
        ]);
    }
}