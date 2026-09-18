<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerifyTechvibesWebhook
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Get the signature from the incoming header
        $signature = $request->header('X-Techvibes-Signature');

        if (!$signature) {
            Log::warning('Techvibes Webhook failed: Missing Signature Header');
            return response()->json(['error' => 'Unauthorized. Missing signature.'], 401);
        }

        // 2. Get the raw JSON payload body
        $payload = $request->getContent();
        
        // 3. Get your Webhook Secret from the .env file
        $secret = env('TECHVIBES_WEBHOOK_SECRET');

        // 4. Generate your own signature using the payload and your secret
        $expectedSignature = hash_hmac('sha512', $payload, $secret);

        // 5. Securely compare the two signatures
        if (!hash_equals($expectedSignature, $signature)) {
            Log::error('Techvibes Webhook failed: Invalid Signature Match');
            return response()->json(['error' => 'Unauthorized. Invalid signature.'], 401);
        }

        // 6. If they match, allow the request to pass through to your Controller!
        return $next($request);
    }
}