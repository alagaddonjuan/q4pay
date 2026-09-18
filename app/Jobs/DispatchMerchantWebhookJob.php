<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DispatchMerchantWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $merchantId;
    protected $payload;
    protected $event;

    /**
     * Create a new job instance.
     */
    public function __construct($merchantId, $event, $payload)
    {
        $this->merchantId = $merchantId;
        $this->event = $event;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $config = DB::table('webhook_endpoints')
            ->where('merchant_id', $this->merchantId)
            ->first();

        if (!$config || empty($config->live_url)) {
            return; // No live webhook configured
        }

        $targetUrl = $config->live_url;
        $secret = $config->secret ?? 'test_secret_key';
        
        $wrappedPayload = [
            'event' => $this->event,
            'data' => $this->payload
        ];

        $signature = hash_hmac('sha512', json_encode($wrappedPayload), $secret);

        $start = microtime(true);
        try {
            $response = Http::withHeaders([
                'x-q4i-signature' => $signature,
                'Content-Type' => 'application/json'
            ])->timeout(10)->post($targetUrl, $wrappedPayload);
            
            $timeMs = round((microtime(true) - $start) * 1000);
            
            \App\Models\WebhookDelivery::create([
                'merchant_id' => $this->merchantId,
                'event' => $this->event,
                'webhook_url' => $targetUrl,
                'payload' => $wrappedPayload,
                'response_headers' => $response->headers(),
                'response_body' => $response->body(),
                'response_status' => $response->status(),
                'is_successful' => $response->successful(),
                'processing_time_ms' => $timeMs
            ]);

        } catch (\Exception $e) {
            $timeMs = round((microtime(true) - $start) * 1000);
            
            \App\Models\WebhookDelivery::create([
                'merchant_id' => $this->merchantId,
                'event' => $this->event,
                'webhook_url' => $targetUrl,
                'payload' => $wrappedPayload,
                'response_body' => 'Error: ' . $e->getMessage(),
                'is_successful' => false,
                'processing_time_ms' => $timeMs
            ]);
            
            Log::error('Merchant Webhook Delivery Failed', [
                'merchant_id' => $this->merchantId,
                'error' => $e->getMessage()
            ]);
        }
    }
}
