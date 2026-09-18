<?php

namespace App\Filament\Merchant\Resources\Withdrawals\Pages;

use App\Filament\Merchant\Resources\Withdrawals\WithdrawalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWithdrawal extends EditRecord
{
    protected static string $resource = WithdrawalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
