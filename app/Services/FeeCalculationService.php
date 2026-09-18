<?php

namespace App\Services;

use App\Models\SystemFee;
use App\Models\Merchant;
use App\Models\SystemEarning;
use Illuminate\Support\Facades\Log;

class FeeCalculationService
{
    /**
     * Calculate fees, settle amount, and record system profit.
     * 
     * @param Merchant $merchant
     * @param string $transactionType e.g., 'inflow_transfer', 'outflow_payout', 'vas_mtn'
     * @param float $amount
     * @return array ['fee_charged' => float, 'settled_amount' => float, 'system_profit' => float]
     */
    public function calculateFee(Merchant $merchant, string $transactionType, float $amount): array
    {
        // 1. Automatic Tier Upgrade Check
        $this->checkAndUpgradeTier($merchant);

        // 2. Fetch the fee rule for this merchant's tier, fallback to 'standard'
        $rule = SystemFee::where('transaction_type', $transactionType)
                         ->where('fee_tier', $merchant->fee_tier)
                         ->first();

        if (!$rule) {
            $rule = SystemFee::where('transaction_type', $transactionType)
                             ->where('fee_tier', 'standard')
                             ->first();
        }

        if (!$rule) {
            Log::warning("No fee rule found for {$transactionType}. Defaulting to 0.");
            return [
                'fee_charged' => 0.00,
                'settled_amount' => $amount,
                'system_profit' => 0.00
            ];
        }

        // 3. Calculate Merchant Fee (What Q4I charges the merchant)
        $merchantFee = $this->calculateAmount($amount, $rule->merchant_charge, $rule->merchant_charge_type, $rule->cap_amount);

        // Special handling for payouts (Stamp Duty + Tiered logic is baked into the calculation)
        if ($transactionType === 'outflow_payout' && $amount >= 10000) {
            $merchantFee += 50.00; // Apply ₦50 Stamp Duty pass-through
        }

        // 4. Calculate Provider Cost (What 9PSB charges/pays Q4I)
        // Note: For VAS (where 9PSB pays Q4I), provider_cost is positive revenue for Q4I.
        // For inflows/outflows, provider_cost is a cost to Q4I.
        $providerCost = $this->calculateAmount($amount, $rule->provider_cost, $rule->provider_cost_type, null);

        // 5. Determine System Profit and Settled Amount
        if (str_starts_with($transactionType, 'vas_')) {
            // For VAS: Merchant sells at face value, but pays Q4I (Face Value - Discount)
            // Settled Amount = The amount debited from merchant wallet.
            // fee_charged = The discount given to merchant (informational)
            $discountGiven = $merchantFee; 
            $settledAmount = $amount - $discountGiven; 
            
            // Q4I gets full commission from 9PSB, gives some to merchant.
            // Profit = 9PSB Commission - Merchant Discount
            $systemProfit = $providerCost - $discountGiven; 
            
            return [
                'fee_charged' => 0.00, // Typically 0 fee for end customer, they pay face value
                'settled_amount' => $amount, // The face value of the service
                'merchant_debit' => $settledAmount, // What actually leaves merchant wallet
                'system_profit' => max(0, $systemProfit)
            ];
        }

        // For regular inflows/outflows
        $settledAmount = $amount - $merchantFee;
        
        // Profit = What Q4I charged merchant - What Q4I pays 9PSB
        // For stamp duty, we charged 50, but we also pay 50 (pass-through), so it nets 0.
        $systemProfit = $merchantFee - $providerCost;
        if ($transactionType === 'outflow_payout' && $amount >= 10000) {
            $systemProfit -= 50.00; // Deduct stamp duty from profit since we must pay it out
        }

        return [
            'fee_charged' => round($merchantFee, 2),
            'settled_amount' => round($settledAmount, 2),
            'system_profit' => round(max(0, $systemProfit), 2)
        ];
    }

    /**
     * Helper to calculate flat, percentage, or tiered amounts.
     */
    private function calculateAmount(float $amount, float $rate, string $type, ?float $cap): float
    {
        $calculated = 0;

        if ($type === 'percentage') {
            $calculated = $amount * ($rate / 100);
        } elseif ($type === 'flat') {
            $calculated = $rate;
        } elseif ($type === 'tiered') {
            // Hardcoded payout tiers based on strategy (assuming rate isn't used for tiered)
            if ($amount <= 5000) {
                $calculated = 20.00;
            } elseif ($amount <= 50000) {
                $calculated = 30.00;
            } else {
                $calculated = 50.00;
            }
        }

        if ($cap && $calculated > $cap) {
            $calculated = $cap;
        }

        return $calculated;
    }

    /**
     * Automatic Tier Upgrade Logic
     */
    private function checkAndUpgradeTier(Merchant $merchant)
    {
        // Example logic:
        // Pro = ₦100M+ total volume
        // Enterprise = ₦1B+ total volume
        
        $currentTier = $merchant->fee_tier;
        $volume = $merchant->total_processed_volume;
        $newTier = $currentTier;

        if ($volume >= 1000000000) {
            $newTier = 'enterprise';
        } elseif ($volume >= 100000000) {
            $newTier = 'pro';
        }

        if ($newTier !== $currentTier) {
            $merchant->update(['fee_tier' => $newTier]);
            Log::info("Merchant {$merchant->id} automatically upgraded to tier: {$newTier}");
        }
    }
    
    /**
     * Helper to record system profit
     */
    public function recordSystemProfit(string $txRef, Merchant $merchant, string $type, float $profitAmount)
    {
        if ($profitAmount <= 0) return;
        
        SystemEarning::create([
            'transaction_ref' => $txRef,
            'merchant_id' => $merchant->id,
            'type' => $type,
            'amount' => $profitAmount
        ]);
    }
}
