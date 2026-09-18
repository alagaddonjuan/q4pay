<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class MonitorSystemHealth extends Command
{
    // The command you can type in the terminal to run this script
    protected $signature = 'system:monitor-health';
    protected $description = 'Pings Techvibes and DB to update the traffic light status';

    public function handle()
    {
        $status = 'green';
        $message = 'All systems operational.';
        $techvibesLatency = 0;

        // 1. Check Q4I Database Health
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            // If the database is down, immediately cache the RED status and stop.
            Cache::put('q4i_system_health', [
                'status' => 'red',
                'message' => 'Q4I Database is currently undergoing maintenance.',
                'latency_ms' => 0,
            ], 120); 
            $this->error('Database is down!');
            return;
        }

        // 2. Check Techvibes (Bank Network) Health
        try {
            $start = microtime(true);
            
            // We ping their main domain to see how fast their servers are responding
            $response = Http::withoutVerifying()->timeout(5)->get('https://techvibs.com');
            
            $techvibesLatency = (microtime(true) - $start) * 1000; // Convert to milliseconds

            // Determine the Traffic Light Status
            if (!$response->successful()) {
                $status = 'red';
                $message = 'Bank network is currently unreachable. Transfers are paused.';
            } elseif ($techvibesLatency > 4000) {
                // Takes more than 4 seconds
                $status = 'yellow';
                $message = 'Bank network is highly congested. Transfers may be delayed.';
            } elseif ($techvibesLatency > 1500) {
                // Takes more than 1.5 seconds
                $status = 'yellow';
                $message = 'Slight bank network delays detected.';
            } else {
                // Takes less than 1.5 seconds
                $status = 'green';
                $message = 'All systems operational.';
            }
        } catch (\Exception $e) {
            $status = 'red';
            $message = 'Bank network connection timeout.';
        }

        // 3. Save the result to Laravel's ultra-fast Cache (Expires in 2 minutes)
        Cache::put('q4i_system_health', [
            'status' => $status,
            'message' => $message,
            'latency_ms' => round($techvibesLatency),
            'timestamp' => now()->toIso8601String()
        ], 120);

        $this->info("Health check complete. Status: {$status} | Latency: {$techvibesLatency}ms");
    }
}