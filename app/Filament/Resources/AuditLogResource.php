<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-shield-check';
    protected static \UnitEnum|string|null $navigationGroup = 'Security & Compliance';
    protected static ?string $navigationLabel = 'Audit Logs';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Log Details')->schema([
                    Forms\Components\TextInput::make('user_type')->disabled(),
                    Forms\Components\TextInput::make('user_id')->disabled(),
                    Forms\Components\TextInput::make('action')->disabled(),
                    Forms\Components\TextInput::make('module')->disabled(),
                    Forms\Components\Textarea::make('description')->disabled()->columnSpanFull(),
                    Forms\Components\TextInput::make('ip_address')->disabled(),
                    Forms\Components\TextInput::make('user_agent')->disabled(),
                    Forms\Components\KeyValue::make('old_values')->disabled(),
                    Forms\Components\KeyValue::make('new_values')->disabled(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label('Timestamp'),
                Tables\Columns\TextColumn::make('user_type')->searchable(),
                Tables\Columns\TextColumn::make('module')->searchable()->badge(),
                Tables\Columns\TextColumn::make('action')->searchable(),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('ip_address')->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
        ];
    }
    
    // Security measure: Audit logs should NEVER be created, edited, or deleted manually.
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
