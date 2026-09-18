<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL; // <-- I added this import for the HTTPS fix
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. THE NGROK FIX: Force Laravel to use secure links for CSS/Images
        URL::forceScheme('https');

        // 2. YOUR ENTERPRISE RATE LIMITER: (Left exactly as you wrote it!)
        RateLimiter::for('q4i-merchant', function (Request $request) {
            // Identify the merchant by their API Key. 
            // If they don't provide one, fallback to their IP address.
            $identifier = $request->header('X-Q4I-API-Key') ?: $request->ip();
            
            // Limit them to 60 requests per minute.
            return Limit::perMinute(60)->by($identifier);
        });
    }
}