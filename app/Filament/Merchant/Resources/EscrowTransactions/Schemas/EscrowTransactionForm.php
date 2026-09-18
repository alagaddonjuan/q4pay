<?php

namespace App\Filament\Merchant\Resources\EscrowTransactions\Schemas;

use Filament\Schemas\Schema;

class EscrowTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
