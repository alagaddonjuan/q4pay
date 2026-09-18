<?php

namespace App\Filament\Resources\EscrowTransactions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EscrowTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Transaction Details')
                    ->schema([
                        TextInput::make('reference')
                            
                            ->disabled(),
                            
                        TextInput::make('amount')
                            ->prefix('₦')
                            ->numeric()
                            ->disabled(),
                            
                        TextInput::make('item_description')
                            ->disabled(),
                            
                        Select::make('status')
                            ->options([
                                'awaiting_funds' => 'Awaiting Funds',
                                'funded_locked' => 'Funded & Locked',
                                'in_transit' => 'In Transit',
                                'disputed' => 'Disputed',
                                'released' => 'Released',
                                'refunded' => 'Refunded',
                            ])
                            ->disabled(),
                    ])->columns(2),

                Section::make('Payment Routing')
                    ->schema([
                        TextInput::make('buyer_phone')
                            ->label('Buyer WhatsApp')
                            ->disabled(),
                            
                        TextInput::make('virtual_account_bank')
                            ->label('Bank Name')
                            ->disabled(),
                            
                        TextInput::make('virtual_account_number')
                            ->label('Account Number')
                            ->disabled(),
                    ])->columns(3),
            ]);
    }
}
