<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ProfitChart extends ChartWidget
{
    // Fix: Removed the word 'static' from the heading!
    protected ?string $heading = '7-Day Platform Profit (Fees Collected)';
    
    // Sort determines the order on the page. 2 puts it under the stats!
    protected static ?int $sort = 2; 

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        // Loop through the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i);
            
            // 🟢 FIXED: Query the new system_earnings table instead of transactions.
            // This natively adds up the +50s, +18s, and perfectly subtracts the -18 reversals!
            $dailyProfit = \Illuminate\Support\Facades\DB::table('system_earnings')
                ->whereDate('created_at', $date->toDateString())
                ->sum('amount');

            $data[] = $dailyProfit;
            $labels[] = $date->format('M d'); // e.g., "Mar 14"
        }

        return [
            'datasets' => [
                [
                    'label' => 'Net Profit Swept (₦)',
                    'data' => $data,
                    'borderColor' => '#10b981', 
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
