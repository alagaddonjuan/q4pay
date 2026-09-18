<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TvSubscriptionService
{
    public function processSubscription($sourceAccount, $smartcardNumber, $amount, $billerId, $packageCode, $customerPhone = null)
    {
        // Added ->withoutVerifying() to bypass local Laragon SSL issues
        $response = Http::withoutVerifying()->withHeaders([
            'Content-Type' => 'application/json',
            'fintech-token' => env('TECHVIBS_FINTECH_TOKEN'),
        ])->post('https://techvibs.com/bank/api_general/bill_tv_subscription_Route_byFintechToken_api.php', [
            'source_account' => $sourceAccount,
            'smartcard_number' => $smartcardNumber,
            'amount' => $amount,
            'biller_id' => $billerId,
            'package_code' => $packageCode,
            'customer_phone' => $customerPhone,
        ]);

        return $response->json();
    }
}