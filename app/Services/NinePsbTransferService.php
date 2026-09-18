<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class NinePsbTransferService
{
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $clientId;
    protected $clientSecret;
    protected $poolAccount;
    protected $poolName;

    public function __construct()
    {
        $this->baseUrl = env('NINEPSB_WAAS_BASE_URL', 'https://baastest.9psb.com.ng');
        $this->username = env('NINEPSB_WAAS_USERNAME');
        $this->password = env('NINEPSB_WAAS_PASSWORD');
        $this->clientId = env('NINEPSB_WAAS_CLIENT_ID');
        $this->clientSecret = env('NINEPSB_WAAS_CLIENT_SECRET');
        $this->poolAccount = env('NINEPSB_POOL_ACCOUNT'); // The system account from which funds will be deducted
        $this->poolName = env('NINEPSB_POOL_NAME', 'Q4I Payments');
    }

    /**
     * Authenticate and get Bearer Token for WAAS
     */
    public function getAuthToken()
    {
        $cacheKey = '9psb_waas_auth_token';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = Http::post("{$this->baseUrl}/api/v1/authenticate", [
            'username' => $this->username,
            'password' => $this->password,
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
        ]);

        if ($response->successful() && isset($response['accessToken'])) {
            $token = $response['accessToken'];
            $expiresIn = (int) ($response['expiresIn'] ?? 3600);
            
            // Wait, does expiresIn come as a string or int? usually seconds.
            // Let's ensure it's calculated in seconds appropriately.
            $expiresInSeconds = $expiresIn > 100000 ? $expiresIn / 1000 : $expiresIn;

            // Cache token slightly less than expiration time to be safe
            Cache::put($cacheKey, $token, now()->addSeconds(max((int)$expiresInSeconds - 60, 60)));

            return $token;
        }

        Log::error('9PSB WAAS Authentication Failed', ['response' => $response->json()]);
        throw new Exception('Failed to authenticate with 9PSB WAAS service');
    }

    /**
     * Prepare HTTP Client with Token
     */
    protected function client()
    {
        $token = $this->getAuthToken();

        return Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Transfer Funds to Other Banks
     */
    public function transferToOtherBank(array $data)
    {
        // $data expects: ['bank_code', 'account_number', 'account_name', 'amount', 'reference', 'narration']
        
        $payload = [
            "customer" => [
                "account" => [
                    "bank" => $data['bank_code'],
                    "name" => $data['account_name'],
                    "number" => $data['account_number'],
                    "senderaccountnumber" => $this->poolAccount,
                    "sendername" => $this->poolName
                ]
            ],
            "narration" => $data['narration'] ?? "Payout Transfer",
            "order" => [
                "amount" => (string)$data['amount'],
                "country" => "NGA",
                "currency" => "NGN",
                "description" => $data['narration'] ?? "Payout Transfer"
            ],
            "transaction" => [
                "reference" => $data['reference']
            ],
            "merchant" => [
                "isFee" => false,
                "merchantFeeAccount" => "",
                "merchantFeeAmount" => ""
            ]
        ];

        Log::info('9PSB Transfer Request: ', $payload);

        $response = $this->client()->post("{$this->baseUrl}/api/v1/wallet_other_banks", $payload);

        Log::info('9PSB Transfer Response: ', $response->json() ?? ['raw' => $response->body()]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('9PSB Transfer Failed: ' . ($response->json('message') ?? 'Unknown error'));
    }
}
