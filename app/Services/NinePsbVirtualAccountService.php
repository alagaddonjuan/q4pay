<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class NinePsbVirtualAccountService
{
    protected $baseUrl;
    protected $publicKey;
    protected $privateKey;
    protected $ivaBaseUrl;

    public function __construct()
    {
        $this->baseUrl = env('NINEPSB_WAAS_BASE_URL', 'http://102.216.128.75:9090'); // Usually https://baastest.9psb.com.ng for IVA, but using WAAS base as fallback
        $this->publicKey = env('NINEPSB_WAAS_PUBLIC_KEY');
        $this->privateKey = env('NINEPSB_WAAS_PRIVATE_KEY');
        
        // Note: The IVA (Virtual Account API) baseUrl seems to be https://baastest.9psb.com.ng based on the PDF docs.
        // We will override if needed, but we'll use a specific base url for IVA endpoints.
        $this->ivaBaseUrl = 'https://baastest.9psb.com.ng/iva-api/v1';
    }

    /**
     * Authenticate and get Bearer Token for IVA
     */
    public function getAuthToken()
    {
        $cacheKey = '9psb_iva_auth_token';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = Http::withoutVerifying()->post("{$this->ivaBaseUrl}/merchant/virtualaccount/authenticate", [
            'publickey' => $this->publicKey,
            'privatekey' => $this->privateKey,
        ]);

        if ($response->successful() && $response->json('code') === '00') {
            $token = $response->json('access_token');
            $expiresInSeconds = $response->json('expires_in'); 

            // Cache token slightly less than expiration time to be safe
            Cache::put($cacheKey, $token, now()->addSeconds($expiresInSeconds - 60));

            return $token;
        }

        Log::error('9PSB IVA Authentication Failed', ['response' => $response->json()]);
        throw new Exception('Failed to authenticate with 9PSB Virtual Account service');
    }

    /**
     * Prepare HTTP Client with Token
     */
    protected function client()
    {
        $token = $this->getAuthToken();

        return Http::withoutVerifying()->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Create Virtual Account (Static or Dynamic)
     */
    public function createVirtualAccount($payload)
    {
        /*
        Payload structure expected by API:
        {
            "transaction": {"reference": "unique_ref"},
            "order": {"amount": 100, "currency": "NGN", "description": "Desc", "country": "NGA", "amounttype": "EXACT|ANY"},
            "customer": {"account": {"name": "Customer Name", "type": "STATIC|DYNAMIC", "expiry": {"hours": 1} }}
        }
        */
        $response = $this->client()->post("{$this->ivaBaseUrl}/merchant/virtualaccount/create", $payload);
        return $response->json();
    }

    /**
     * Reallocate Virtual Account
     */
    public function reallocateVirtualAccount($payload)
    {
        $response = $this->client()->post("{$this->ivaBaseUrl}/merchant/virtualaccount/reallocate", $payload);
        return $response->json();
    }

    /**
     * Deactivate Virtual Account
     */
    public function deactivateVirtualAccount($reference, $accountNumber)
    {
        $response = $this->client()->post("{$this->ivaBaseUrl}/merchant/virtualaccount/deactivate", [
            'transaction' => ['reference' => $reference],
            'customer' => ['account' => ['number' => $accountNumber]]
        ]);
        return $response->json();
    }

    /**
     * Reactivate Virtual Account
     */
    public function reactivateVirtualAccount($reference, $accountNumber)
    {
        $response = $this->client()->post("{$this->ivaBaseUrl}/merchant/virtualaccount/reactivate", [
            'transaction' => ['reference' => $reference],
            'customer' => ['account' => ['number' => $accountNumber]]
        ]);
        return $response->json();
    }

    /**
     * Confirm Virtual Account Payment
     */
    public function confirmPayment($reference, $accountNumber, $sessionId = '', $amount = null)
    {
        $payload = [
            'reference' => $reference,
            'sessionid' => $sessionId,
            'accountnumber' => $accountNumber,
        ];

        if ($amount !== null) {
            $payload['amount'] = (float)$amount;
        }

        $response = $this->client()->post("{$this->ivaBaseUrl}/merchant/virtualaccount/confirmpayment", $payload);
        return $response->json();
    }
}
