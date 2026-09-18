<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class GodEyeDashboard extends Page
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-eye';
    
    protected static ?string $navigationLabel = 'God\'s Eye';
    
    protected static ?string $title = 'God\'s Eye Dashboard';
    
    protected static \UnitEnum|string|null $navigationGroup = 'Irene AI';
    
    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.god-eye-dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\IrenesInsightsWidget::class,
        ];
    }

}
