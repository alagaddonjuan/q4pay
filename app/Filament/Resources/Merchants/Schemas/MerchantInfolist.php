<?php

namespace App\Filament\Resources\Merchants\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MerchantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('business_name'),
                TextEntry::make('q4i_api_key'),
                TextEntry::make('contact_email'),
                TextEntry::make('wallet_balance')
                    ->numeric(),
                TextEntry::make('webhook_url')
                    ->placeholder('-'),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('inbound_flat_fee')
                    ->numeric(),
                TextEntry::make('outbound_flat_fee')
                    ->numeric(),
                TextEntry::make('email')
                    ->label('Email address')
                    ->placeholder('-'),
                TextEntry::make('transaction_pin')
                    ->placeholder('-'),
                TextEntry::make('business_type'),
                TextEntry::make('kyc_status'),
                TextEntry::make('bvn')
                    ->placeholder('-'),
                TextEntry::make('nin')
                    ->placeholder('-'),
                TextEntry::make('cac_number')
                    ->placeholder('-'),
                TextEntry::make('tin_number')
                    ->placeholder('-'),
                TextEntry::make('cac_document_path')
                    ->placeholder('-'),
                TextEntry::make('utility_bill_path')
                    ->placeholder('-'),
                IconEntry::make('vas_requested')
                    ->boolean(),
                IconEntry::make('vas_approved')
                    ->boolean(),
            ]);
    }
}
