<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemFee;

class SystemFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fees = [
            // Standard Inflow Transfer (e.g. they pay 1.0% with ₦2000 cap)
            [
                'transaction_type' => 'inflow_transfer',
                'fee_tier' => 'standard',
                'provider_cost' => 0.00,
                'provider_cost_type' => 'flat',
                'merchant_charge' => 1.0,
                'merchant_charge_type' => 'percentage',
                'cap_amount' => 2000.00,
            ],
            // Pro Inflow Transfer (e.g. they pay 0.8% with ₦1500 cap)
            [
                'transaction_type' => 'inflow_transfer',
                'fee_tier' => 'pro',
                'provider_cost' => 0.00,
                'provider_cost_type' => 'flat',
                'merchant_charge' => 0.8,
                'merchant_charge_type' => 'percentage',
                'cap_amount' => 1500.00,
            ],
            // Enterprise Inflow Transfer (e.g. they pay 0.5% with ₦1000 cap)
            [
                'transaction_type' => 'inflow_transfer',
                'fee_tier' => 'enterprise',
                'provider_cost' => 0.00,
                'provider_cost_type' => 'flat',
                'merchant_charge' => 0.5,
                'merchant_charge_type' => 'percentage',
                'cap_amount' => 1000.00,
            ],
            
            // Outflow Payout (Tiered 20, 30, 50 logic baked in Service, but we define the base rule here)
            // Plus 50 NGN stamp duty for >10k
            [
                'transaction_type' => 'outflow_payout',
                'fee_tier' => 'standard',
                'provider_cost' => 50.00, // Pass-through stamp duty + base cost
                'provider_cost_type' => 'flat',
                'merchant_charge' => 0, // This is calculated dynamically in FeeCalculationService based on amount tiers
                'merchant_charge_type' => 'tiered',
                'cap_amount' => null,
            ],
            
            // VAS MTN
            [
                'transaction_type' => 'vas_mtn',
                'fee_tier' => 'standard',
                'provider_cost' => 2.3007, // 9PSB pays us 2.3007%
                'provider_cost_type' => 'percentage',
                'merchant_charge' => 2.0, // We give merchant 2.0% discount
                'merchant_charge_type' => 'percentage',
                'cap_amount' => null,
            ],
            
            // VAS Airtel
            [
                'transaction_type' => 'vas_airtel',
                'fee_tier' => 'standard',
                'provider_cost' => 3.00, // 9PSB pays us 3.00%
                'provider_cost_type' => 'percentage',
                'merchant_charge' => 2.74, // We give merchant 2.74% discount
                'merchant_charge_type' => 'percentage',
                'cap_amount' => null,
            ],
            
            // VAS Glo
            [
                'transaction_type' => 'vas_glo',
                'fee_tier' => 'standard',
                'provider_cost' => 4.29, // 9PSB pays us 4.29%
                'provider_cost_type' => 'percentage',
                'merchant_charge' => 3.5, // We give merchant 3.5% discount
                'merchant_charge_type' => 'percentage',
                'cap_amount' => null,
            ],
            
            // VAS 9Mobile
            [
                'transaction_type' => 'vas_9mobile',
                'fee_tier' => 'standard',
                'provider_cost' => 7.71, // 9PSB pays us 7.71%
                'provider_cost_type' => 'percentage',
                'merchant_charge' => 6.5, // We give merchant 6.5% discount
                'merchant_charge_type' => 'percentage',
                'cap_amount' => null,
            ],
            
            // VAS Abuja Disco (AEDC)
            [
                'transaction_type' => 'vas_aedc',
                'fee_tier' => 'standard',
                'provider_cost' => 1.29, // 9PSB pays us 1.29%
                'provider_cost_type' => 'percentage',
                'merchant_charge' => 1.0, // We give merchant 1.0% discount
                'merchant_charge_type' => 'percentage',
                'cap_amount' => null,
            ],
            
            // VAS EEDC
            [
                'transaction_type' => 'vas_eedc',
                'fee_tier' => 'standard',
                'provider_cost' => 1.29, 
                'provider_cost_type' => 'percentage',
                'merchant_charge' => 1.0, 
                'merchant_charge_type' => 'percentage',
                'cap_amount' => null,
            ],
            
            // VAS IKEDC
            [
                'transaction_type' => 'vas_ikedc',
                'fee_tier' => 'standard',
                'provider_cost' => 0.86, 
                'provider_cost_type' => 'percentage',
                'merchant_charge' => 0.5, 
                'merchant_charge_type' => 'percentage',
                'cap_amount' => null,
            ],
        ];

        foreach ($fees as $fee) {
            SystemFee::updateOrCreate(
                [
                    'transaction_type' => $fee['transaction_type'],
                    'fee_tier' => $fee['fee_tier']
                ],
                $fee
            );
        }
    }
}
