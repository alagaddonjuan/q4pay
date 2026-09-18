<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupportTicketResource\Pages;
use App\Models\SupportTicket;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class SupportTicketResource extends Resource
{
    protected static ?string $model = SupportTicket::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationLabel = 'Live Support';
    protected static ?string $modelLabel = 'Support Ticket';
    protected static ?string $pluralModelLabel = 'Live Support Tickets';
    
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Ticket Information')
                    ->schema([
                        Forms\Components\Select::make('merchant_id')
                            ->relationship('merchant', 'business_name')
                            ->searchable()
                            ->disabled()
                            ->required(),
                        Forms\Components\TextInput::make('reference')
                            ->disabled()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('subject')
                            ->disabled()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('status')
                            ->options([
                                'open' => 'Open (AI)',
                                'escalated' => 'Escalated (Human)',
                                'resolved' => 'Resolved',
                            ])
                            ->required(),
                    ])->columns(2),
                
                \Filament\Schemas\Components\Section::make('Chat History')
                    ->schema([
                        Forms\Components\ViewField::make('chat_history')
                            ->view('filament.resources.support-ticket.chat-history')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('merchant.business_name')
                    ->searchable()
                    ->sortable()
                    ->label('Merchant'),
                Tables\Columns\TextColumn::make('reference')
                    ->searchable()
                    ->copyable()
                    ->label('Ref'),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'open',
                        'warning' => 'escalated',
                        'success' => 'resolved',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Default to showing escalated tickets
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'open' => 'Open (AI)',
                        'escalated' => 'Escalated (Human needed)',
                        'resolved' => 'Resolved',
                    ])
                    ->default('escalated'),
            ])
            ->recordActions([
                EditAction::make()->label('View & Reply'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
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
            'index' => Pages\ListSupportTickets::route('/'),
            'edit' => Pages\EditSupportTicket::route('/{record}/edit'),
        ];
    }
}
