<?php

namespace App\Filament\Resources\EscrowTransactions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EscrowTransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Transaction Details')
                    ->schema([
                        TextEntry::make('reference')
                            ->weight('bold')
                            ->copyable(),
                            
                        TextEntry::make('amount')
                            ->money('NGN'),
                            
                        TextEntry::make('item_description'),
                            
                        TextEntry::make('status')
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
                    ])->columns(2),

                Section::make('Payment Routing')
                    ->schema([
                        TextEntry::make('buyer_phone')
                            ->label('Buyer WhatsApp'),
                            
                        TextEntry::make('virtual_account_bank')
                            ->label('Bank Name'),
                            
                        TextEntry::make('virtual_account_number')
                            ->label('Account Number')
                            ->copyable(),
                    ])->columns(3),
            ]);
    }
}
