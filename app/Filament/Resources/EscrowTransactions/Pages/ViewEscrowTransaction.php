<?php

namespace App\Filament\Resources\EscrowTransactions\Pages;

use App\Filament\Resources\EscrowTransactions\EscrowTransactionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEscrowTransaction extends ViewRecord
{
    protected static string $resource = EscrowTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
