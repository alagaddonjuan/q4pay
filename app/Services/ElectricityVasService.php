<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ElectricityVasService
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->baseUrl = env('VAS_ELECTRICITY_URL');
        $this->token = env('VAS_FINTECH_TOKEN');
    }

    /**
     * 1. GET BILLERS (Returns the list of DISCOs)
     */
    public function getBillers()
    {
        return $this->makeRequest([
            'action' => 'get_billers'
        ]);
    }

    /**
     * 2. VALIDATE METER (Always call before payment!)
     */
    public function validateMeter(string $accountNumber, string $meterNumber, string $billerId, string $meterType)
    {
        return $this->makeRequest([
            'action'         => 'validate_meter',
            'account_number' => $accountNumber,
            'meter_number'   => $meterNumber,
            'biller_id'      => $billerId,
            'meter_type'     => $meterType
        ]);
    }

    /**
     * 3. PURCHASE ELECTRICITY (Debits and Vends Token)
     */
    public function purchase(string $accountNumber, string $meterNumber, string $billerId, string $meterType, float $amount, string $phone)
    {
        return $this->makeRequest([
            'account_number' => $accountNumber,
            'meter_number'   => $meterNumber,
            'biller_id'      => $billerId,
            'meter_type'     => $meterType,
            'amount'         => $amount,
            'customer_phone' => $phone
        ]);
    }

    /**
     * INTERNAL HELPER: Handles the exact Headers and JSON required by the API
     */
    private function makeRequest(array $payload)
    {
        try {
            $response = Http::withoutVerifying() // Useful for local Laragon testing
                ->withHeaders([
                    'Content-Type'  => 'application/json',
                    'Fintech-Token' => $this->token,
                ])
                ->post($this->baseUrl, $payload);

            return $response->json();

        } catch (\Exception $e) {
            Log::error('Electricity VAS Error: ' . $e->getMessage());
            return [
                'success' => false,
                'data' => ['error' => 'Unable to connect to the electricity provider.']
            ];
        }
    }
}