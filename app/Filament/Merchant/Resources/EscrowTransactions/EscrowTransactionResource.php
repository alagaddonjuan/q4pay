<?php

namespace App\Filament\Merchant\Resources\EscrowTransactions;

use App\Filament\Merchant\Resources\EscrowTransactions\Pages;
use App\Models\EscrowTransaction;
use Filament\Schemas\Schema; // <-- FIX 2: SCHEMA IMPORTED
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EscrowTransactionResource extends Resource
{
    protected static ?string $model = EscrowTransaction::class;

    // <-- FIX 1: STRICT TYPE ENUM ADDED
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationLabel = 'Orders & Deliveries';
    protected static ?string $pluralModelLabel = 'Orders';

    // <-- FIX 2: FORM REPLACED WITH SCHEMA
    public static function form(Schema $schema): Schema
    {
        return $schema->components([]); 
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label('Order ID')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('item_description')
                    ->label('Product'),

                Tables\Columns\TextColumn::make('amount')
                    ->money('NGN')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Payment')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'awaiting_funds' => 'warning',
                        'funded' => 'success',
                        'released' => 'success',
                        'refunded' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('shipping_status')
                    ->label('Logistics')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'danger',
                        'shipped' => 'warning',
                        'delivered' => 'success',
                        default => 'gray',
                    }),
            ])
            ->actions([
                // THE MAGIC DISPATCH BUTTON (Namespace Fixed!)
                \Filament\Actions\Action::make('dispatch')
                    ->label('Update Shipping')
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->form([
                        \Filament\Forms\Components\Select::make('shipping_status')
                            ->options([
                                'pending' => 'Pending',
                                'shipped' => 'Shipped / In Transit',
                                'delivered' => 'Delivered',
                            ])
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('courier_name')
                            ->label('Courier Name (e.g., Sendbox, Kwik)')
                            ->placeholder('Leave blank if self-delivered'),
                        \Filament\Forms\Components\TextInput::make('tracking_number')
                            ->label('Tracking Number'),
                        \Filament\Forms\Components\TextInput::make('tracking_link')
                            ->label('Tracking Link')
                            ->url(),
                    ])
                    ->action(function (EscrowTransaction $record, array $data): void {
                        // 1. Update the database
                        $record->update($data);

                        $metaApiUrl = 'https://graph.facebook.com/v25.0/' . env('META_PHONE_NUMBER_ID') . '/messages';

                        // 2A. If SHIPPED: Send the tracking link text message
                        if ($data['shipping_status'] === 'shipped') {
                            $message = "🚚 *Delivery Update!*\n\n";
                            $message .= "Your order for *{$record->item_description}* has been shipped and is on its way.\n\n";
                            
                            if (!empty($data['courier_name'])) {
                                $message .= "📦 *Courier:* {$data['courier_name']}\n";
                            }
                            if (!empty($data['tracking_number'])) {
                                $message .= "🔢 *Tracking No:* {$data['tracking_number']}\n";
                            }
                            if (!empty($data['tracking_link'])) {
                                $message .= "🔗 *Track your item here:* {$data['tracking_link']}\n\n";
                            }
                            
                            $message .= "_Your money is still safely locked in Escrow. We will not release it to the vendor until you confirm receipt._";

                            \Illuminate\Support\Facades\Http::withoutVerifying()
                                ->withToken(env('META_ACCESS_TOKEN'))
                                ->post($metaApiUrl, [
                                    'messaging_product' => 'whatsapp',
                                    'to' => $record->buyer_phone,
                                    'type' => 'text',
                                    'text' => ['body' => $message]
                                ]);
                        }
                        
                        // 2B. If DELIVERED: Send the Interactive Buttons to Release Funds!
                        elseif ($data['shipping_status'] === 'delivered') {
                            $message = "📦 *Delivery Arrived!*\n\n";
                            $message .= "Your order for *{$record->item_description}* has been marked as delivered.\n\n";
                            $message .= "Please confirm you have received the item in good condition. Clicking 'Release Funds' will immediately credit the vendor's wallet.";

                            \Illuminate\Support\Facades\Http::withoutVerifying()
                                ->withToken(env('META_ACCESS_TOKEN'))
                                ->post($metaApiUrl, [
                                    'messaging_product' => 'whatsapp',
                                    'to' => $record->buyer_phone,
                                    'type' => 'interactive',
                                    'interactive' => [
                                        'type' => 'button',
                                        'body' => ['text' => $message],
                                        'action' => [
                                            'buttons' => [
                                                [
                                                    'type' => 'reply',
                                                    'reply' => [
                                                        'id' => 'release_funds_' . $record->id,
                                                        'title' => '✅ Release Funds'
                                                    ]
                                                ],
                                                [
                                                    'type' => 'reply',
                                                    'reply' => [
                                                        'id' => 'dispute_' . $record->id,
                                                        'title' => '⚠️ Report Issue'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]);
                        }

                        // 3. Show a success toast on the dashboard
                        \Filament\Notifications\Notification::make()
                            ->title('Shipping Updated & Buyer Notified!')
                            ->success()
                            ->send();
                    })
                    // Hide the button if the money has already been released
                    ->visible(fn (EscrowTransaction $record): bool => $record->status !== 'released'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEscrowTransactions::route('/'),
        ];
    }

    // SECURITY PADLOCK: Vendors only see their own sales
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('vendor_id', auth()->id());
    }

    // Disable the "Create" button
    public static function canCreate(): bool
    {
        return false;
    }
}
