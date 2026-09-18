<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('virtual_account_id')
                    ->required()
                    ->numeric(),
                TextInput::make('merchant_id')
                    ->required()
                    ->numeric(),
                TextInput::make('session_id')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->default('credit'),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('balance_before')
                    ->required()
                    ->numeric(),
                TextInput::make('balance_after')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('successful'),
                Textarea::make('remarks')
                    ->columnSpanFull(),
                TextInput::make('fee_charged')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('settled_amount')
                    ->numeric(),
                Toggle::make('is_swept')
                    ->required(),
            ]);
    }
}
