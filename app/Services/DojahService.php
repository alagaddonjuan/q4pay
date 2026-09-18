<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DojahService
{
    protected $baseUrl;
    protected $appId;
    protected $privateKey;

    public function __construct()
    {
        $this->baseUrl = env('DOJAH_BASE_URL', 'https://api.dojah.io');
        $this->appId = env('DOJAH_APP_ID');
        $this->privateKey = env('DOJAH_PRIVATE_KEY');
    }

    /**
     * Verify a BVN and return the official registered name
     */
    public function verifyBvn($bvn)
    {
        try {
            $response = Http::withHeaders([
                'AppId' => $this->appId,
                'Authorization' => $this->privateKey,
            ])->get("{$this->baseUrl}/api/v1/kyc/bvn", [
                'bvn' => $bvn
            ]);

            $data = $response->json();

            // Check if Dojah successfully found the BVN
            if ($response->successful() && isset($data['entity'])) {
                $entity = $data['entity'];
                
                // Dojah usually returns first_name, last_name, and sometimes middle_name
                $firstName = $entity['first_name'] ?? '';
                $lastName = $entity['last_name'] ?? '';
                
                return [
                    'status' => 'success',
                    'official_name' => trim(strtoupper($firstName . ' ' . $lastName)),
                    'raw_data' => $entity
                ];
            }

            $errorMessage = $data['error'] ?? $data['message'] ?? 'Invalid BVN or identity not found.';
            Log::error('Dojah BVN Lookup Failed', ['response' => $data]);
            return ['status' => 'error', 'message' => $errorMessage];

        } catch (\Exception $e) {
            Log::error('Dojah API Crash: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Identity verification service is temporarily down.'];
        }
    }
}