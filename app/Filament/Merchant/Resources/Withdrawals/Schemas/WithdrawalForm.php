<?php

namespace App\Filament\Merchant\Resources\Withdrawals\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class WithdrawalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(auth()->id()),

                Section::make('Request Payout')
                    ->description('Enter your bank details to withdraw available funds from your Q4I wallet.')
                    ->schema([
                        TextInput::make('amount')
                            ->label('Withdrawal Amount')
                            ->required()
                            ->numeric()
                            ->prefix('₦')
                            ->minValue(1000) // Minimum withdrawal amount
                            // THE OVERDRAFT PROTECTION:
                            ->maxValue(function () {
                                $wallet = \App\Models\Wallet::firstOrCreate(
                                    ['user_id' => auth()->id()],
                                    ['balance' => 0, 'locked_balance' => 0]
                                );
                                $pending = \App\Models\Withdrawal::where('user_id', auth()->id())
                                    ->where('status', 'pending')
                                    ->sum('amount');
                                
                                return max(0, $wallet->balance - $pending);
                            })
                            ->helperText('Minimum withdrawal is ₦1,000.'),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('bank_name')
                                    ->label('Bank Name')
                                    ->placeholder('e.g., Wema Bank')
                                    ->required(),

                                TextInput::make('account_number')
                                    ->label('Account Number')
                                    ->required()
                                    ->numeric()
                                    ->length(10),
                            ]),

                        TextInput::make('account_name')
                            ->label('Account Holder Name')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
