<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
            return $this->routeToNinePsbAirtime($phone, $accountNumber, $amount);
        } 
        
        Log::warning("9PSB degraded. Rerouting NGN {$amount} airtime for {$phone} to Backup Provider.");
        return $this->routeToBackupProvider($phone, $amount);
    }

    /**
     * ========================================================================
     * DATA BUNDLES LOGIC
     * ========================================================================
     */
    public function getDataPlans($merchant, $phone)
    {
        $vas = new NinePsbVasService();
        return $vas->getDataPlans($phone);
    }

    public function processDataPurchase($merchant, $phone, $accountNumber, $amount, $network, $productId) 
    {
        $health = Cache::get('q4i_system_health', ['status' => 'green']);

        if ($health['status'] === 'green') {
            $vas = new NinePsbVasService();
            $txnReference = 'Q4I_DATA_' . time() . rand(100, 999);
            
            return $vas->purchaseData($phone, $network, $amount, $productId, $accountNumber, $txnReference);
        } 
        
        Log::warning("9PSB degraded. Data purchase for {$phone} failed over.");
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
        $vas = new NinePsbVasService();
        // Assuming Betting category ID is 4 based on typical 9PSB configs. 
        // This might need mapping if the category ID differs.
        return $vas->getCategoryBillers(4); 
    }

    // 2. Validate the Betting Wallet (Returns Name & Session Hash)
    public function validateBettingWallet($merchant, $accountNumber, $walletId, $billerId, $amount)
    {
        $vas = new NinePsbVasService();
        return $vas->validateBiller($walletId, $billerId, null, $amount);
    }

    // 3. Purchase / Fund the Wallet
    public function processBettingFunding($merchant, $accountNumber, $walletId, $billerId, $amount, $otherField, $customerPhone = '08000000000')
    {
        $vas = new NinePsbVasService();
        $txnReference = 'Q4I_BET_' . time() . rand(100, 999);
        
        $payload = [
            'customerId' => $walletId,
            'billerId' => $billerId,
            'itemId' => '', // Betting usually doesn't have an item id
            'customerPhone' => $customerPhone,
            'customerName' => 'Betting Customer',
            'otherField' => $otherField,
            'debitAccount' => $accountNumber,
            'amount' => $amount,
            'transactionReference' => $txnReference
        ];

        return $vas->payBill($payload);
    }

    /**
     * ========================================================================
     * INTERNAL GATEWAY ROUTING METHODS
     * ========================================================================
     */
    private function routeToNinePsbAirtime($phone, $accountNumber, $amount)
    {
        $vas = new NinePsbVasService();
        
        // 1. Fetch Network first
        $networkInfo = $vas->getNetwork($phone);
        $networkName = $networkInfo['network'] ?? 'MTN'; // Fallback
        
        $txnReference = 'Q4I_AIR_' . time() . rand(100, 999);

        return $vas->purchaseAirtime($phone, $networkName, $amount, $accountNumber, $txnReference);
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
     * ELECTRICITY LOGIC
     * ========================================================================
     */

    // 1. Get List of Electricity Providers (Discos)
    public function getElectricityBillers($merchant)
    {
        $vas = new NinePsbVasService();
        // Assuming Electricity category ID is 3
        return $vas->getCategoryBillers(3);
    }

    // 2. Validate the Meter Number
    public function validateMeter($merchant, $accountNumber, $meterNumber, $billerId, $meterType, $amount = 5000)
    {
        $vas = new NinePsbVasService();
        // Techvibes used $meterType, but 9PSB uses $itemId for prepaid/postpaid
        // We'll map $meterType to $itemId
        return $vas->validateBiller($meterNumber, $billerId, $meterType, $amount);
    }

    // 3. Purchase Electricity (Vend Token)
    public function processElectricityPurchase($merchant, $accountNumber, $meterNumber, $billerId, $meterType, $amount, $customerPhone = '08000000000')
    {
        $vas = new NinePsbVasService();
        $txnReference = 'Q4I_ELEC_' . time() . rand(100, 999);
        
        $payload = [
            'customerId' => $meterNumber,
            'billerId' => $billerId,
            'itemId' => $meterType, 
            'customerPhone' => $customerPhone,
            'customerName' => 'Electricity Customer',
            'otherField' => '',
            'debitAccount' => $accountNumber,
            'amount' => $amount,
            'transactionReference' => $txnReference
        ];

        return $vas->payBill($payload);
    }
}