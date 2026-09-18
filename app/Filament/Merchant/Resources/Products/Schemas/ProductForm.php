<?php

namespace App\Filament\Merchant\Resources\Products\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid; // <-- FIXED V4 NAMESPACE!
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(auth()->id()),

                Section::make('Product Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Product Name')
                            ->placeholder('e.g., Nike Sneakers')
                            ->required()
                            ->maxLength(255),

                        Select::make('category')
                            ->label('Category')
                            ->options([
                                'fashion' => 'Clothing & Fashion',
                                'electronics' => 'Electronics & Gadgets',
                                'beauty' => 'Health & Beauty',
                                'home' => 'Home & Furniture',
                                'services' => 'Digital & Services',
                                'other' => 'Other'
                            ])
                            ->searchable(),

                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('₦'),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('stock')
                                    ->label('Units Available')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                                    
                                TextInput::make('sold')
                                    ->label('Units Sold')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled() // The system updates this, not the vendor!
                                    ->dehydrated(false), 
                            ]),

                        FileUpload::make('image')
                            ->label('Product Image')
                            ->image()
                            ->multiple()
                            // FORCE META-FRIENDLY FORMATS!
                            ->acceptedFileTypes(['image/jpeg', 'image/png']) 
                            ->disk('public')
                            ->directory('products')
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->placeholder('Optional details about the item...')
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Available in stock')
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
