<?php

namespace App\Filament\Merchant\Resources\Withdrawals;

use App\Filament\Merchant\Resources\Withdrawals\Pages\CreateWithdrawal;
use App\Filament\Merchant\Resources\Withdrawals\Pages\EditWithdrawal;
use App\Filament\Merchant\Resources\Withdrawals\Pages\ListWithdrawals;
use App\Filament\Merchant\Resources\Withdrawals\Schemas\WithdrawalForm;
use App\Filament\Merchant\Resources\Withdrawals\Tables\WithdrawalsTable;
use App\Models\Withdrawal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WithdrawalResource extends Resource
{
    protected static ?string $model = Withdrawal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return WithdrawalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WithdrawalsTable::configure($table);
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
            'index' => ListWithdrawals::route('/'),
            'create' => CreateWithdrawal::route('/create'),
            'edit' => EditWithdrawal::route('/{record}/edit'),
        ];
    }

    // THE SECURITY PADLOCK: Only load withdrawals that belong to the logged-in merchant
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    // BANKING RULE: Disable the "Edit" page completely. Financial records are permanent.
    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

}
