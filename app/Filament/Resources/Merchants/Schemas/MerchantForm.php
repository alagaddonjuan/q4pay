<?php

namespace App\Filament\Resources\Merchants\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MerchantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('business_name')
                    ->required(),
                TextInput::make('q4i_api_key')
                    ->required(),
                TextInput::make('contact_email')
                    ->email()
                    ->required(),
                TextInput::make('wallet_balance')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('webhook_url')
                    ->url(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('inbound_flat_fee')
                    ->required()
                    ->numeric()
                    ->default(5),
                TextInput::make('outbound_flat_fee')
                    ->required()
                    ->numeric()
                    ->default(18),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('password')
                    ->password(),
                TextInput::make('transaction_pin'),
                TextInput::make('business_type')
                    ->required()
                    ->default('individual'),
                TextInput::make('kyc_status')
                    ->required()
                    ->default('pending'),
                TextInput::make('bvn'),
                TextInput::make('nin'),
                TextInput::make('cac_number'),
                TextInput::make('tin_number'),
                TextInput::make('cac_document_path'),
                TextInput::make('utility_bill_path'),
                Toggle::make('vas_requested')
                    ->required(),
                Toggle::make('vas_approved')
                    ->required(),
            ]);
    }
}
