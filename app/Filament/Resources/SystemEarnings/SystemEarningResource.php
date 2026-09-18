<?php

namespace App\Filament\Resources\SystemEarnings;

use App\Filament\Resources\SystemEarnings\Pages\CreateSystemEarning;
use App\Filament\Resources\SystemEarnings\Pages\EditSystemEarning;
use App\Filament\Resources\SystemEarnings\Pages\ListSystemEarnings;
use App\Filament\Resources\SystemEarnings\Pages\ViewSystemEarning;
use App\Filament\Resources\SystemEarnings\Schemas\SystemEarningForm;
use App\Filament\Resources\SystemEarnings\Schemas\SystemEarningInfolist;
use App\Filament\Resources\SystemEarnings\Tables\SystemEarningsTable;
use App\Models\SystemEarning;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SystemEarningResource extends Resource
{
    protected static ?string $model = SystemEarning::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'transaction_ref';

    public static function form(Schema $schema): Schema
    {
        return SystemEarningForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SystemEarningInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('merchant.business_name')
                    ->label('Merchant')
                    ->searchable()
                    ->weight('bold'),

                \Filament\Tables\Columns\TextColumn::make('transaction_ref')
                    ->label('Reference')
                    ->searchable()
                    ->copyable(),

                \Filament\Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'inflow_fee' => 'success',
                        'outflow_fee' => 'success',
                        'outflow_reversal' => 'danger', // 🟢 Highlights refunded fees!
                        default => 'gray',
                    }),

                \Filament\Tables\Columns\TextColumn::make('amount')
                    ->label('Profit Collected')
                    ->money('NGN')
                    ->weight('bold')
                    ->color(fn ($record) => $record->amount < 0 ? 'danger' : 'success')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime('d M Y, g:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    // 🟢 SECURITY LOCK: This disables the "New" button on the dashboard.
    // Financial records are only generated automatically by your APIs!
    public static function canCreate(): bool 
    { 
        return false; 
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSystemEarnings::route('/'),
            // 'create' => CreateSystemEarning::route('/create'),
            'view' => ViewSystemEarning::route('/{record}'),
            // 'edit' => EditSystemEarning::route('/{record}/edit'),
        ];
    }

}
