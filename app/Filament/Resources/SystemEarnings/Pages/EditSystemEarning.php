<?php

namespace App\Filament\Resources\SystemEarnings\Pages;

use App\Filament\Resources\SystemEarnings\SystemEarningResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSystemEarning extends EditRecord
{
    protected static string $resource = SystemEarningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
