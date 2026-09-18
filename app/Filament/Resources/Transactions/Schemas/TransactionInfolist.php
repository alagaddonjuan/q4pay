<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('virtual_account_id')
                    ->numeric(),
                TextEntry::make('merchant_id')
                    ->numeric(),
                TextEntry::make('session_id'),
                TextEntry::make('type'),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('balance_before')
                    ->numeric(),
                TextEntry::make('balance_after')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('remarks')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('fee_charged')
                    ->numeric(),
                TextEntry::make('settled_amount')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('is_swept')
                    ->boolean(),
            ]);
    }
}
