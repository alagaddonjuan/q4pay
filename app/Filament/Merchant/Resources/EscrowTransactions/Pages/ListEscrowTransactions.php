<?php

namespace App\Filament\Merchant\Resources\EscrowTransactions\Pages;

use App\Filament\Merchant\Resources\EscrowTransactions\EscrowTransactionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEscrowTransactions extends ListRecords
{
    protected static string $resource = EscrowTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
