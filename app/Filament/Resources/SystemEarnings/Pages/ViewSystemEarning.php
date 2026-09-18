<?php

namespace App\Filament\Resources\SystemEarnings\Pages;

use App\Filament\Resources\SystemEarnings\SystemEarningResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSystemEarning extends ViewRecord
{
    protected static string $resource = SystemEarningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
