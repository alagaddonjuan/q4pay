<?php

namespace App\Filament\Resources\SystemEarnings\Pages;

use App\Filament\Resources\SystemEarnings\SystemEarningResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSystemEarnings extends ListRecords
{
    protected static string $resource = SystemEarningResource::class;

    protected function getHeaderActions(): array
    {
        return [
                    ];
    }
}
