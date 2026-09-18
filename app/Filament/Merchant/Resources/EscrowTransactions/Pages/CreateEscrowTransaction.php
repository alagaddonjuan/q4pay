<?php

namespace App\Filament\Merchant\Resources\EscrowTransactions\Pages;

use App\Filament\Merchant\Resources\EscrowTransactions\EscrowTransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEscrowTransaction extends CreateRecord
{
    protected static string $resource = EscrowTransactionResource::class;
}
