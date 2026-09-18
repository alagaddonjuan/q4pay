<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class SendMerchantWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaction;

    // 🟢 ENTERPRISE RETRY LOGIC: Try 3 times. Wait 1 min, then 5 mins, then 15 mins if they fail.
    public $tries = 3;
    public $backoff = [60, 300, 900]; 

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function handle(): void
    {
        // 1. Get the merchant ID securely
        $merchantId = $this->transaction->merchant_id;
        if (!$merchantId) return;

        // 2. 🟢 FIXED: Query the correct 'webhook_endpoints' table
        $endpointConfig = DB::table('webhook_endpoints')->where('merchant_id', $merchantId)->first();
        
        if (!$endpointConfig || (empty($endpointConfig->live_url) && empty($endpointConfig->test_url))) {
            Log::info("Webhook skipped: Merchant [ID: {$merchantId}] has no webhook URL configured in DB.");
            return;
        }

        // Use Live URL primarily, fallback to Test URL
        $url = $endpointConfig->live_url ?? $endpointConfig->test_url;
        $secret = $endpointConfig->secret ?? '';

        // 3. Prepare the exact custom payload
        $payload = [
            'event' => 'charge.success',
            'data' => [
                'merchant_reference' => $this->transaction->virtualAccount?->agent?->merchant_reference,
                'amount' => $this->transaction->amount,
                'session_id' => $this->transaction->session_id,
                'status' => $this->transaction->status,
                'remarks' => $this->transaction->remarks,
                'account_number' => $this->transaction->virtualAccount?->account_number,
                'timestamp' => $this->transaction->created_at->toIso8601String(),
            ]
        ];

        // 4. Create the Enterprise Signature
        $payloadJson = json_encode($payload);
        $signature = hash_hmac('sha256', $payloadJson, $secret);

        // 5. Fire the POST request and Log to the Delivery Ledger
        $startTime = microtime(true);
        $httpStatus = null;
        $responseBody = null;
        $isSuccessful = false;

        try {
            $response = Http::withoutVerifying()
                ->timeout(15) // Give them 15 seconds to respond
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'x-q4i-signature' => $signature
                ])
                ->post($url, $payload);

            $httpStatus = $response->status();
            $responseBody = $response->body();
            $isSuccessful = $response->successful();

            if (!$isSuccessful) {
                Log::warning("Webhook failed to {$url} for Session {$this->transaction->session_id}. Status: {$httpStatus}");
                // If it fails, throw an exception so Laravel's queue worker knows to retry it later!
                throw new \Exception("Merchant server returned HTTP {$httpStatus}");
            }

        } catch (\Exception $e) {
            $httpStatus = $httpStatus ?? 500;
            $responseBody = $e->getMessage();
            throw $e; // Re-throw to trigger the backoff retries
        } finally {
            // 6. 🟢 NEW: Log to Database so the Merchant Dashboard can display it
            $duration = round((microtime(true) - $startTime) * 1000); // ms
            
            try {
                DB::table('webhook_deliveries')->insert([
                    'merchant_id' => $merchantId,
                    'transaction_ref' => $this->transaction->session_id,
                    'endpoint_url' => $url,
                    'payload' => $payloadJson,
                    'response_code' => $httpStatus,
                    'response_body' => substr($responseBody, 0, 500), // Truncate to prevent DB bloat
                    'duration_ms' => $duration,
                    'status' => $isSuccessful ? 'success' : 'failed',
                    'created_at' => now()
                ]);
            } catch (\Exception $logEx) {
                Log::error("Failed to write to webhook_deliveries ledger: " . $logEx->getMessage());
            }
        }
    }
}