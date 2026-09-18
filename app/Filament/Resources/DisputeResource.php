<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DisputeResource\Pages;
use App\Models\Dispute;
use Filament\Forms;
use Filament\Schemas\Schema; 
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// V4 Action Imports (Moved from Tables namespace!)
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class DisputeResource extends Resource
{
    protected static ?string $model = Dispute::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shield-exclamation';
    
    protected static ?string $recordTitleAttribute = 'transaction_reference';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('transaction_reference')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('merchant_id')
                    ->label('Merchant ID')
                    ->numeric(),
                Forms\Components\TextInput::make('reason')
                    ->label('Client Complaint / Reason')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options([
                        'open' => 'Open',
                        'investigating' => 'Investigating',
                        'resolved' => 'Resolved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('open')
                    ->required(),
                Forms\Components\Textarea::make('resolution_notes')
                    ->label('CEO Resolution Notes (Internal Only)')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('merchant_id')
                    ->label('Merchant ID')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reason')
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'danger',
                        'investigating' => 'warning',
                        'resolved' => 'success',
                        'rejected' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            // Upgraded to V4 Architecture
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDisputes::route('/'),
            'create' => Pages\CreateDispute::route('/create'),
            'edit' => Pages\EditDispute::route('/{record}/edit'),
        ];
    }
}
