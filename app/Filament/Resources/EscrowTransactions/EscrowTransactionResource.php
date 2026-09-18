<?php

namespace App\Filament\Resources\EscrowTransactions;

use App\Filament\Resources\EscrowTransactions\Pages\CreateEscrowTransaction;
use App\Filament\Resources\EscrowTransactions\Pages\EditEscrowTransaction;
use App\Filament\Resources\EscrowTransactions\Pages\ListEscrowTransactions;
use App\Filament\Resources\EscrowTransactions\Pages\ViewEscrowTransaction;
use App\Filament\Resources\EscrowTransactions\Schemas\EscrowTransactionForm;
use App\Filament\Resources\EscrowTransactions\Schemas\EscrowTransactionInfolist;
use App\Filament\Resources\EscrowTransactions\Tables\EscrowTransactionsTable;
use BackedEnum;
use EscrowTransaction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EscrowTransactionResource extends Resource
{
    protected static ?string $model = \App\Models\EscrowTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'reference';

    public static function form(Schema $schema): Schema
    {
        return EscrowTransactionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EscrowTransactionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('reference')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),
                    
                \Filament\Tables\Columns\TextColumn::make('vendor.phone') 
                    ->label('Vendor Phone')
                    ->searchable(),
                    
                \Filament\Tables\Columns\TextColumn::make('buyer_phone')
                    ->searchable(),
                    
                \Filament\Tables\Columns\TextColumn::make('item_description'),
                
                \Filament\Tables\Columns\TextColumn::make('amount')
                    ->money('NGN') 
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('shipping_status')
                    ->label('Logistics')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'danger',
                        'shipped' => 'warning',
                        'delivered' => 'success',
                        default => 'gray',
                    }),
                    
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'awaiting_funds' => 'gray',
                        'funded_locked' => 'warning',
                        'in_transit' => 'info',
                        'disputed' => 'danger',
                        'released' => 'success',
                        'refunded' => 'danger',
                        default => 'gray',
                    }),
                    
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // We will add status filters here later
            ])
            ->actions([
                // 1. The CEO "Refund Buyer" Button
                \Filament\Actions\Action::make('refund_buyer')
                    ->label('Refund Buyer')
                    ->color('danger')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->requiresConfirmation()
                    ->modalDescription('Are you sure you want to refund this buyer? This will deduct the locked funds from the vault and cancel the transaction.')
                    ->visible(fn (\App\Models\EscrowTransaction $record): bool => $record->status === 'disputed')
                    ->action(function (\App\Models\EscrowTransaction $record) {
                        // Change status to refunded
                        $record->update(['status' => 'refunded']);
                        
                        // Remove the locked funds from the vendor's wallet
                        $wallet = \App\Models\Wallet::where('user_id', $record->vendor_id)->first();
                        if($wallet) {
                            $wallet->decrement('locked_balance', $record->amount);
                        }
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Buyer Refunded Successfully')
                            ->success()
                            ->send();
                    }),

                // 2. The CEO "Force Payout" Button
                \Filament\Actions\Action::make('force_payout')
                    ->label('Force Payout')
                    ->color('success')
                    ->icon('heroicon-o-check-badge')
                    ->requiresConfirmation()
                    ->modalDescription('Are you sure you want to force payout to the vendor? This overrides the dispute.')
                    ->visible(fn (\App\Models\EscrowTransaction $record): bool => $record->status === 'disputed')
                    ->action(function (\App\Models\EscrowTransaction $record) {
                        // Call the Day 1 Escrow Service to handle the math!
                        $escrowService = new \App\Services\EscrowService();
                        $escrowService->releaseEscrowFunds($record);

                        \Filament\Notifications\Notification::make()
                            ->title('Vendor Paid Successfully')
                            ->success()
                            ->send();
                    }),

                // 3. Standard Actions (Fixed namespace!)
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
            ]);
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
            'index' => ListEscrowTransactions::route('/'),
            'create' => CreateEscrowTransaction::route('/create'),
            'view' => ViewEscrowTransaction::route('/{record}'),
            'edit' => EditEscrowTransaction::route('/{record}/edit'),
        ];
    }
}
