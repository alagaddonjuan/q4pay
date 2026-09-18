<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SmartRoutingService 
{
    /**
     * ========================================================================
     * AIRTIME LOGIC (With Failover)
     * ========================================================================
     */
    public function processAirtime($merchant, $phone, $accountNumber, $amount) 
    {
        $health = Cache::get('q4i_system_health', ['status' => 'green']);

        if ($health['status'] === 'green') {
            return $this->routeToTechvibes($merchant, $phone, $accountNumber, $amount);
        } 
        
        Log::warning("Techvibes degraded. Rerouting NGN {$amount} airtime for {$phone} to Backup Provider.");
        return $this->routeToBackupProvider($phone, $amount);
    }

    /**
     * ========================================================================
     * DATA BUNDLES LOGIC
     * ========================================================================
     */
    public function getDataPlans($merchant, $phone)
    {
        $activeToken = $merchant->techvibes_token ?: env('TECHVIBES_LIVE_TOKEN');

        $response = Http::withoutVerifying()
            ->timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'token' => $activeToken 
            ])
            ->post('https://techvibs.com/vas9/data_external_fintech_token.php', [
                'action' => 'get_data_plans',
                'phone' => $phone
            ]);

        return $response->json();
    }

    public function processDataPurchase($merchant, $phone, $accountNumber, $amount, $network, $productId) 
    {
        $health = Cache::get('q4i_system_health', ['status' => 'green']);

        if ($health['status'] === 'green') {
            $activeToken = $merchant->techvibes_token ?: env('TECHVIBES_LIVE_TOKEN');

            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'token' => $activeToken 
                ])
                ->post('https://techvibs.com/vas9/data_external_fintech_token.php', [
                    'action' => 'purchase_data',
                    'phone' => $phone,
                    'account_number' => $accountNumber,
                    'amount' => (int) $amount,
                    'network' => $network,
                    'product_id' => $productId
                ]);

            return $response->json();
        } 
        
        Log::warning("Techvibes degraded. Data purchase for {$phone} failed over.");
        return ['success' => false, 'message' => 'Bank network is currently unreachable.'];
    }

    /**
     * ========================================================================
     * BETTING LOGIC (From Allen's Docs)
     * ========================================================================
     */
    
    // 1. Get List of Betting Providers (SportyBet, Bet9ja, etc.)
    public function getBettingBillers($merchant)
    {
        $activeToken = $merchant->techvibes_token ?: env('TECHVIBES_LIVE_TOKEN');

        $response = Http::withoutVerifying()
            ->timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Fintech-Token' => $activeToken // Betting uses Fintech-Token
            ])
            ->post('https://techvibs.com/vas9/bills_betting_FintechToken.php', [
                'action' => 'get_billers'
            ]);

        return $response->json();
    }

    // 2. Validate the Betting Wallet (Returns Name & Session Hash)
    public function validateBettingWallet($merchant, $accountNumber, $walletId, $billerId, $amount)
    {
        $activeToken = $merchant->techvibes_token ?: env('TECHVIBES_LIVE_TOKEN');

        $response = Http::withoutVerifying()
            ->timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Fintech-Token' => $activeToken
            ])
            ->post('https://techvibs.com/vas9/bills_betting_FintechToken.php', [
                'action' => 'validate_wallet',
                'account_number' => $accountNumber,
                'wallet_id' => $walletId,
                'biller_id' => $billerId,
                'amount' => (int) $amount
            ]);

        return $response->json();
    }

    // 3. Purchase / Fund the Wallet
    public function processBettingFunding($merchant, $accountNumber, $walletId, $billerId, $amount, $otherField, $customerPhone = '08000000000')
    {
        $activeToken = $merchant->techvibes_token ?: env('TECHVIBES_LIVE_TOKEN');

        $response = Http::withoutVerifying()
            ->timeout(45)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Fintech-Token' => $activeToken
            ])
            ->post('https://techvibs.com/vas9/bills_betting_FintechToken.php', [
                'account_number' => $accountNumber,
                'wallet_id' => $walletId,
                'biller_id' => $billerId,
                'amount' => (int) $amount,
                'other_field' => $otherField,
                'customer_phone' => $customerPhone
            ]);

        return $response->json();
    }

    /**
     * ========================================================================
     * INTERNAL GATEWAY ROUTING METHODS
     * ========================================================================
     */
    private function routeToTechvibes($merchant, $phone, $accountNumber, $amount)
    {
        $activeToken = $merchant->techvibes_token ?: env('TECHVIBES_LIVE_TOKEN');

        $response = Http::withoutVerifying()
            ->timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'token' => $activeToken 
            ])
            ->post('https://techvibs.com/vas9/airtime_external_fintech_token.php', [
                'phone' => $phone,
                'account_number' => $accountNumber,
                'amount' => $amount
            ]);

        return $response->json();
    }

    private function routeToBackupProvider($phone, $amount)
    {
        return [
            'success' => true,
            'message' => 'Airtime routed via Backup Provider (Simulated)',
            'data' => [
                'phone' => $phone,
                'network' => 'Auto',
                'amount' => $amount
            ]
        ];
    }

    /**
     * ========================================================================
     * ELECTRICITY LOGIC (From Allen's Docs)
     * ========================================================================
     */

    // 1. Get List of Electricity Providers (Discos)
    public function getElectricityBillers($merchant)
    {
        $activeToken = $merchant->techvibes_token ?: env('TECHVIBES_LIVE_TOKEN');

        $response = Http::withoutVerifying()
            ->timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Fintech-Token' => $activeToken
            ])
            ->post('https://techvibs.com/vas9/bill_electricity_fintechToken.php', [
                'action' => 'get_billers'
            ]);

        return $response->json();
    }

    // 2. Validate the Meter Number
    public function validateMeter($merchant, $accountNumber, $meterNumber, $billerId, $meterType, $amount = 5000)
    {
        $activeToken = $merchant->techvibes_token ?: env('TECHVIBES_LIVE_TOKEN');

        $response = Http::withoutVerifying()
            ->timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Fintech-Token' => $activeToken
            ])
            ->post('https://techvibs.com/vas9/bill_electricity_fintechToken.php', [
                'action' => 'validate_meter',
                'account_number' => $accountNumber,
                'meter_number' => $meterNumber,
                'biller_id' => $billerId,
                'meter_type' => $meterType,
                'amount' => (int) $amount // This will now send 5000!
            ]);

        return $response->json();
    }

    // 3. Purchase Electricity (Vend Token)
    public function processElectricityPurchase($merchant, $accountNumber, $meterNumber, $billerId, $meterType, $amount, $customerPhone = '08000000000')
    {
        $activeToken = $merchant->techvibes_token ?: env('TECHVIBES_LIVE_TOKEN');

        $response = Http::withoutVerifying()
            ->timeout(45)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Fintech-Token' => $activeToken
            ])
            ->post('https://techvibs.com/vas9/bill_electricity_fintechToken.php', [
                'account_number' => $accountNumber,
                'meter_number' => $meterNumber,
                'biller_id' => $billerId,
                'meter_type' => $meterType,
                'amount' => (int) $amount,
                'customer_phone' => $customerPhone
            ]);

        return $response->json();
    }
}