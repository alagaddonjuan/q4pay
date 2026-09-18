<?php

namespace App\Filament\Merchant\Resources\Withdrawals\Tables;

use Filament\Tables\Table;

class WithdrawalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('amount')
                    ->label('Amount Requested')
                    ->money('NGN')
                    ->weight('bold')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('bank_name')
                    ->label('Destination Bank')
                    ->description(fn (\App\Models\Withdrawal $record): string => $record->account_number),

                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Requested On')
                    ->dateTime('d M Y, g:i A')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // NO EDIT OR DELETE ACTIONS! Only View is allowed for ledgers.
                \Filament\Actions\ViewAction::make(),
            ]);
    }
}
