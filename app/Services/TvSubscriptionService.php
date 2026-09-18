<?php

namespace App\Services;

class TvSubscriptionService
{
    public function processSubscription($sourceAccount, $smartcardNumber, $amount, $billerId, $packageCode, $customerPhone = null)
    {
        $vas = new NinePsbVasService();
        $txnReference = 'Q4I_TV_' . time() . rand(100, 999);
        
        $payload = [
            'customerId' => $smartcardNumber,
            'billerId' => $billerId,
            'itemId' => $packageCode,
            'customerPhone' => $customerPhone ?? '08000000000',
            'customerName' => 'TV Customer',
            'otherField' => '',
            'debitAccount' => $sourceAccount,
            'amount' => $amount,
            'transactionReference' => $txnReference
        ];

        return $vas->payBill($payload);
    }
}