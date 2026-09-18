<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // 1. YOUR CUSTOM ALIASES (Techvibes stays right here!)
        $middleware->alias([
            'auth.apikey' => \App\Http\Middleware\VerifyApiKey::class,
            'techvibes.webhook' => \App\Http\Middleware\VerifyTechvibesWebhook::class,
            'idempotent' => \App\Http\Middleware\RequireIdempotency::class,
            'ensure.2fa' => \App\Http\Middleware\Ensure2FAIsVerified::class,
            'team_role' => \App\Http\Middleware\CheckTeamRole::class,
        ]);

        // 2. THE CSRF EXEMPTIONS (The new addition)
        // This ensures Laravel doesn't block incoming server-to-server payments
        $middleware->validateCsrfTokens(except: [
            'api/webhooks/rexpay-dva', // Opens the door for RexPay
            'api/webhooks/techvibes',  // Opens the door for Techvibes
        ]);

        // 3. YOUR SMART REDIRECT LOGIC
        // Tells Laravel exactly which door to bounce unauthenticated users to
        $middleware->redirectGuestsTo(function (Request $request) {
            // If they are trying to access the Payment Gateway, send to Door 2
            if ($request->is('merchant') || $request->is('merchant/*')) {
                return route('merchant.login');
            }
            
            // Otherwise, send them to Door 1 (Social Commerce Vendor)
            return route('login'); 
        });

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();