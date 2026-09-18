<?php

namespace App\Filament\Merchant\Resources\Products\Tables;

use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // SHOW THE PRIMARY THUMBNAIL SAFELY!
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->square()
                    ->getStateUsing(function (\App\Models\Product $record) {
                        $image = $record->image;
                        
                        // Scenario 1: It is the new Multi-Image format (List/Array)
                        if (is_array($image)) {
                            return $image[0] ?? null;
                        }
                        
                        // Scenario 2: It is the old Single-Image format (String)
                        if (is_string($image)) {
                            return $image;
                        }
                        
                        return null;
                    }),
                    
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (\App\Models\Product $record): string => $record->category ?? 'Uncategorized'),
                
                \Filament\Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->color('info'),

                \Filament\Tables\Columns\TextColumn::make('price')
                    ->money('NGN')
                    ->sortable(),
                    
                \Filament\Tables\Columns\TextColumn::make('stock')
                    ->label('Stock Left')
                    ->badge()
                    ->color(fn (string $state): string => $state <= 0 ? 'danger' : 'success'),

                \Filament\Tables\Columns\TextColumn::make('sold')
                    ->label('Total Sold')
                    ->sortable(),
                    
                \Filament\Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ]);
    }
}
