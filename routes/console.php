<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Run the health check every single minute
Schedule::command('system:monitor-health')->everyMinute();

// Run the profit sweeper every night at 11:50 PM
Schedule::command('q4i:sweep-profits')->dailyAt('23:50');

// Wakes the robot up every hour to auto-release expired escrows!
Schedule::command('escrow:auto-release')->hourly();

// Process merchant auto-withdrawals every hour
Schedule::command('app:process-auto-sweeps')->hourly();