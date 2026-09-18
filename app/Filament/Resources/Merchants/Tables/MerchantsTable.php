<?php

namespace App\Filament\Resources\Merchants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action; 
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;

class MerchantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('business_name')->searchable(),
                TextColumn::make('q4i_api_key')->searchable(),
                TextColumn::make('contact_email')->searchable(),
                TextColumn::make('wallet_balance')->numeric()->sortable(),
                
                // Live API Kill Switch
                ToggleColumn::make('is_active')
                    ->label('Live API Access'),
                    
                TextColumn::make('kyc_status')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                    
                // VAS Upgrade: Now a clickable switch!
                IconColumn::make('vas_requested')
                    ->boolean()
                    ->label('Requested VAS'),
                ToggleColumn::make('vas_approved')
                    ->label('VAS Access'),

                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('inbound_flat_fee')->numeric()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('outbound_flat_fee')->numeric()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('bvn')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nin')->searchable()->toggleable(isToggledHiddenByDefault: true),
                
                ImageColumn::make('cac_document_path')->label('CAC Document')->square(),
                ImageColumn::make('utility_bill_path')->label('Utility Bill')->square(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                
                // 1. The Approve Button (Wires to the Bell)
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['kyc_status' => 'approved']);

                        Notification::make()
                            ->title('Merchant Approved')
                            ->body("{$record->business_name} has been granted live API access.")
                            ->success()
                            ->sendToDatabase(auth()->user());
                    })
                    ->hidden(fn ($record) => $record->kyc_status === 'approved'),

                // 2. NEW: The Revoke Button (So you can undo approvals!)
                Action::make('revoke')
                    ->label('Revoke KYC')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['kyc_status' => 'pending']);
                    })
                    ->hidden(fn ($record) => $record->kyc_status === 'pending'),
                    
                // 3. Manual Funding Tool
                Action::make('adjust_balance')
                    ->label('Adjust Wallet')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('warning')
                    ->form([
                        Radio::make('transaction_type')
                            ->options([
                                'add' => 'Add Funds',
                                'subtract' => 'Deduct Funds',
                            ])->required(),
                        TextInput::make('amount')->numeric()->prefix('₦')->required(),
                        TextInput::make('reason')->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $amount = (float) $data['amount'];
                        if ($data['transaction_type'] === 'add') {
                            $record->increment('wallet_balance', $amount);
                        } else {
                            $record->decrement('wallet_balance', $amount);
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
