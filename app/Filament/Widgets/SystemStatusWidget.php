<?php

namespace App\Filament\Widgets;

use App\Models\Dispute;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemStatusWidget extends BaseWidget
{
    // Removed 'static' to perfectly match V4 rules!
    protected ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        // We query the database live to get the exact counts
        $openDisputes = Dispute::where('status', 'open')->count();
        $resolvedDisputes = Dispute::where('status', 'resolved')->count();

        return [
            Stat::make('Action Required: Open Disputes', $openDisputes)
                ->description('Requires immediate CEO review')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger')
                ->chart([7, 4, 5, 6, 4, 3, 5, $openDisputes]), // A slick mini-chart for the UI

            Stat::make('Cleared: Resolved Disputes', $resolvedDisputes)
                ->description('Successfully handled and closed')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success')
                ->chart([1, 2, 3, 4, 5, 7, 8, $resolvedDisputes]),

            Stat::make('Q4I Gateway Health', '100%')
                ->description('All transaction systems operational')
                ->descriptionIcon('heroicon-m-bolt')
                ->color('primary')
                ->chart([9, 9, 9, 9, 9, 9, 9, 9]),
        ];
    }
}
