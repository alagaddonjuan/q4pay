<?php

namespace App\Filament\Widgets;

use App\Models\Merchant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class AdminStatsWidget extends BaseWidget
{
    // 🟢 Fixes the layout: Forces this widget to the very top of the dashboard
    protected static ?int $sort = 1; 

    protected function getStats(): array
    {
        // 🟢 FIXED: This is the missing line that caused your error!
        // It safely calculates the all-time net revenue before trying to display it.
        $netRevenue = DB::table('system_earnings')->sum('amount');

        return [
            Stat::make('Total Merchants', Merchant::count())
                ->description('All registered businesses on Q4I')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Pending KYC Approvals', Merchant::where('kyc_status', 'pending')->count())
                ->description('Requires CEO attention')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Total Wallet Balances', '₦ ' . number_format((float) Merchant::sum('wallet_balance'), 2))
                ->description('System-wide merchant holdings')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info'), 

            // The card will now successfully read the $netRevenue variable
            Stat::make('Net Q4I Revenue', '₦ ' . number_format((float) $netRevenue, 2))
                ->description('Total fees collected minus reversals')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),
        ];
    }
}
