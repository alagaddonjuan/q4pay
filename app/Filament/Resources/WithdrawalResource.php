<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawalResource\Pages;
use App\Models\Withdrawal;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class WithdrawalResource extends Resource
{
    protected static ?string $model = Withdrawal::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-currency-dollar';
    protected static \UnitEnum|string|null $navigationGroup = 'Financial Operations';
    protected static ?string $navigationLabel = 'Withdrawals';
    protected static ?string $modelLabel = 'Withdrawal Request';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Withdrawal Details')->schema([
                    Forms\Components\Select::make('user_id')
                        ->relationship('vendor', 'business_name')
                        ->label('Merchant')
                        ->disabled(),
                    Forms\Components\TextInput::make('amount')
                        ->prefix('₦')
                        ->disabled(),
                    Forms\Components\TextInput::make('fee')
                        ->prefix('₦')
                        ->disabled(),
                    Forms\Components\TextInput::make('bank_name')
                        ->disabled(),
                    Forms\Components\TextInput::make('account_number')
                        ->disabled(),
                    Forms\Components\TextInput::make('account_name')
                        ->disabled(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'processing' => 'Processing',
                            'successful' => 'Successful',
                            'failed' => 'Failed',
                        ])
                        ->disabled(),
                    Forms\Components\TextInput::make('reference')
                        ->disabled(),
                    Forms\Components\Textarea::make('admin_notes'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('vendor.business_name')->label('Merchant')->searchable(),
                Tables\Columns\TextColumn::make('amount')->money('NGN')->sortable(),
                Tables\Columns\TextColumn::make('fee')->money('NGN'),
                Tables\Columns\TextColumn::make('bank_name')->searchable(),
                Tables\Columns\TextColumn::make('account_number')->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'processing',
                        'success' => 'successful',
                        'danger' => 'failed',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'successful' => 'Successful',
                        'failed' => 'Failed',
                    ]),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
                Action::make('approve')
                    ->label('Approve & Process')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->hidden(fn ($record) => $record->status !== 'pending')
                    ->action(function ($record) {
                        // Mark as processing, in real app would trigger API to NIBSS/Gateway
                        $record->update(['status' => 'successful', 'processed_at' => now()]);

                        // Deduct from wallet securely
                        $merchant = $record->vendor;
                        if($merchant) {
                            $merchant->decrement('wallet_balance', $record->amount + $record->fee);
                        }

                        Notification::make()
                            ->title('Withdrawal Approved')
                            ->body('Funds deducted from merchant wallet.')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->hidden(fn ($record) => $record->status !== 'pending')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Reason for Rejection')
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => 'failed',
                            'admin_notes' => $data['admin_notes'],
                        ]);
                        Notification::make()
                            ->title('Withdrawal Rejected')
                            ->danger()
                            ->sendToDatabase(auth()->user());
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWithdrawals::route('/'),
        ];
    }
}
