<?php

namespace App\Filament\Merchant\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WalletOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Get the logged-in vendor's wallet
        $wallet = \App\Models\Wallet::firstOrCreate(
            ['user_id' => auth()->id()],
            ['balance' => 0, 'locked_balance' => 0]
        );

        // Calculate total pending withdrawals so they can't overdraw
        $pendingWithdrawals = \App\Models\Withdrawal::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->sum('amount');

        $availableToWithdraw = $wallet->balance - $pendingWithdrawals;

        return [
            Stat::make('Available Balance', '₦ ' . number_format($availableToWithdraw, 2))
                ->description('Ready for withdrawal')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Locked in Escrow', '₦ ' . number_format($wallet->locked_balance, 2))
                ->description('Awaiting buyer approval')
                ->descriptionIcon('heroicon-m-lock-closed')
                ->color('warning'),

            Stat::make('Pending Withdrawals', '₦ ' . number_format($pendingWithdrawals, 2))
                ->description('Processing payouts')
                ->color('danger'),
        ];
    }
}
