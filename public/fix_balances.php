<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Merchant;
use Illuminate\Support\Facades\DB;

echo "<pre>";
echo "Synchronizing Merchant Balances...\n\n";

$merchants = Merchant::all();
$updated = 0;

foreach ($merchants as $merchant) {
    // Calculate the true sum of all their virtual accounts' ledger balances
    $trueBalance = DB::table('virtual_accounts')
        ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
        ->where('agents.merchant_id', $merchant->id)
        ->where('virtual_accounts.is_active', true)
        ->sum('virtual_accounts.ledger_balance');

    $oldBalance = $merchant->wallet_balance;

    if ($oldBalance != $trueBalance) {
        // Fix the negative/out-of-sync balance
        $merchant->wallet_balance = $trueBalance;
        $merchant->save();

        echo "Merchant ID {$merchant->id} '{$merchant->business_name}' updated:\n";
        echo "  - Old Wallet Balance: " . number_format($oldBalance, 2) . "\n";
        echo "  - New Sync'd Balance: " . number_format($trueBalance, 2) . "\n\n";
        $updated++;
    }
}

if ($updated === 0) {
    echo "All merchant balances are already perfectly in sync!\n";
}

echo "Done.\n";
echo "</pre>";
