<?php

namespace App\Filament\Resources\Transactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 🟢 SWAPPED: Raw ID changed to the actual Business Name
                \Filament\Tables\Columns\TextColumn::make('merchant.business_name')
                    ->label('Merchant')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                \Filament\Tables\Columns\TextColumn::make('session_id')
                    ->label('Reference ID')
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'credit' => 'success',
                        'debit' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('amount')
                    ->money('NGN') // Formats it as currency
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'successful' => 'success',
                        'pending' => 'warning',
                        'reversed' => 'danger', // 🟢 Auto-Reversals will flag red!
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('fee_charged')
                    ->money('NGN')
                    ->sortable(),

                \Filament\Tables\Columns\IconColumn::make('is_swept')
                    ->boolean()
                    ->label('Swept'),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d M Y, g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false), // Show by default
            ])
            ->defaultSort('created_at', 'desc') // Show newest first
            ->recordActions([\Filament\Actions\ViewAction::make()]);
    }
}
