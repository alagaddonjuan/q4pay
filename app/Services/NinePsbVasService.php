<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class NinePsbVasService
{
    protected $baseUrl;
    protected $apiKey;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUrl = env('NINEPSB_VAS_BASE_URL', 'http://102.216.128.75:9090');
        $this->apiKey = env('NINEPSB_VAS_API_KEY');
        $this->secretKey = env('NINEPSB_VAS_SECRET_KEY');
    }

    /**
     * Authenticate and get Bearer Token
     */
    public function getAuthToken()
    {
        $cacheKey = '9psb_vas_auth_token';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = Http::post("{$this->baseUrl}/identity/api/v1/authenticate", [
            'username' => $this->apiKey,
            'password' => $this->secretKey,
        ]);

        if ($response->successful() && $response->json('status') === 'success') {
            $token = $response->json('data.accessToken');
            $expiresIn = (int) $response->json('data.expiresIn');
            // If the API returns seconds (e.g. 3600), dividing by 1000 gives 3.6 seconds.
            // Let's ensure it's calculated in seconds appropriately.
            $expiresInSeconds = $expiresIn > 100000 ? $expiresIn / 1000 : $expiresIn;

            // Cache token slightly less than expiration time to be safe
            Cache::put($cacheKey, $token, now()->addSeconds(max((int)$expiresInSeconds - 60, 60)));

            return $token;
        }

        Log::error('9PSB VAS Authentication Failed', ['response' => $response->json()]);
        throw new Exception('Failed to authenticate with 9PSB VAS service');
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
     * Get Phone Network
     */
    public function getNetwork($phone)
    {
        $response = $this->client()->get("{$this->baseUrl}/vas/api/v1/topup/network", [
            'phone' => $phone
        ]);

        return $response->json();
    }

    /**
     * Get Data Plans
     */
    public function getDataPlans($phone)
    {
        $response = $this->client()->get("{$this->baseUrl}/vas/api/v1/topup/dataPlans", [
            'phone' => $phone
        ]);

        return $response->json();
    }

    /**
     * Purchase Airtime
     */
    public function purchaseAirtime($phone, $network, $amount, $debitAccount, $transactionReference)
    {
        $payload = [
            'phoneNumber' => $phone,
            'network' => $network,
            'amount' => (string)$amount,
            'debitAccount' => strpos($this->baseUrl, '102.216.128.75') !== false ? '1100011303' : $debitAccount,
            'transactionReference' => $transactionReference,
        ];
        Log::info('9PSB VAS Airtime Request: ', $payload);
        $response = $this->client()->post("{$this->baseUrl}/vas/api/v1/topup/airtime", $payload);
        Log::info('9PSB VAS Airtime Response: ', $response->json() ?? ['raw' => $response->body()]);

        return $response->json();
    }

    /**
     * Purchase Data
     */
    public function purchaseData($phone, $network, $amount, $productId, $debitAccount, $transactionReference)
    {
        $response = $this->client()->post("{$this->baseUrl}/vas/api/v1/topup/data", [
            'phoneNumber' => $phone,
            'amount' => (string)$amount,
            'debitAccount' => strpos($this->baseUrl, '102.216.128.75') !== false ? '1100011303' : $debitAccount,
            'network' => $network,
            'productId' => $productId,
            'transactionReference' => $transactionReference,
        ]);

        return $response->json();
    }

    /**
     * Topup Status
     */
    public function getTopupStatus($transactionReference)
    {
        $response = $this->client()->get("{$this->baseUrl}/vas/api/v1/topup/status", [
            'transReference' => $transactionReference
        ]);

        return $response->json();
    }

    /**
     * Get Bill Categories
     */
    public function getCategories()
    {
        $response = $this->client()->get("{$this->baseUrl}/vas/api/v1/billspayment/categories");
        return $response->json();
    }

    /**
     * Get Category Billers
     */
    public function getCategoryBillers($categoryId)
    {
        $response = $this->client()->get("{$this->baseUrl}/vas/api/v1/billspayment/billers/{$categoryId}");
        return $response->json();
    }

    /**
     * Get Biller Input Fields (Items)
     */
    public function getBillerItems($billerId)
    {
        $response = $this->client()->get("{$this->baseUrl}/vas/api/v1/billspayment/fields/{$billerId}");
        return $response->json();
    }

    /**
     * Validate Biller Input
     */
    public function validateBiller($customerId, $billerId, $itemId = null, $amount = null, $firstname = null, $lastname = null)
    {
        $payload = [
            'customerId' => $customerId,
            'billerId' => $billerId,
        ];

        if ($itemId) $payload['itemId'] = $itemId;
        $payload['amount'] = $amount ? (string)$amount : "1000";
        if ($firstname) $payload['firstname'] = $firstname;
        if ($lastname) $payload['lastname'] = $lastname;

        $response = $this->client()->post("{$this->baseUrl}/vas/api/v1/billspayment/validate", $payload);
        return $response->json();
    }

    /**
     * Initiate Bills Payment
     */
    public function payBill($payload)
    {
        /*
        Payload expects:
        customerId, billerId, itemId (if applicable), customerPhone, customerName, otherField, debitAccount, amount, transactionReference
        */
        if (strpos($this->baseUrl, '102.216.128.75') !== false) {
            $payload['debitAccount'] = '1100011303';
        }
        $response = $this->client()->post("{$this->baseUrl}/vas/api/v1/billspayment/pay", $payload);
        return $response->json();
    }
}
