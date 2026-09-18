<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VirtualAccountResource\Pages;
use App\Models\VirtualAccount;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VirtualAccountResource extends Resource
{
    protected static ?string $model = VirtualAccount::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-credit-card';
    protected static \UnitEnum|string|null $navigationGroup = 'Financial Operations';
    protected static ?string $navigationLabel = 'Virtual Accounts';
    protected static ?string $modelLabel = 'Virtual Account';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Account Details')->schema([
                    Forms\Components\TextInput::make('account_name')->disabled(),
                    Forms\Components\TextInput::make('account_number')->disabled(),
                    Forms\Components\TextInput::make('bank_name')->disabled(),
                    Forms\Components\TextInput::make('ledger_balance')->disabled()->prefix('₦'),
                    Forms\Components\Toggle::make('is_active')->disabled(),
                    Forms\Components\TextInput::make('customer_id')->disabled(),
                    Forms\Components\TextInput::make('order_ref')->disabled(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('account_name')->searchable(),
                Tables\Columns\TextColumn::make('account_number')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('bank_name')->searchable(),
                Tables\Columns\TextColumn::make('ledger_balance')->money('NGN')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active Status'),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVirtualAccounts::route('/'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }
    
    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }
    
    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }
}
