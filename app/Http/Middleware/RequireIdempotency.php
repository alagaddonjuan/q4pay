<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class RequireIdempotency
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Look for the key in the headers
        $idempotencyKey = $request->header('X-Idempotency-Key');

        // 2. If it's missing, reject the request completely
        if (!$idempotencyKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'X-Idempotency-Key header is strictly required for financial transactions to prevent double-charging.'
            ], 400);
        }

        $cacheKey = 'idempotency_' . $idempotencyKey;

        // 3. Check if we have already processed this exact request
        if (Cache::has($cacheKey)) {
            // Return the exact identical response from the first time they clicked the button
            return response()->json(Cache::get($cacheKey), 200);
        }

        // 4. If it's a new key, let the request pass through to your Controller (like VasController or PayoutController)
        $response = $next($request);

        // 5. If the transaction was successful (HTTP 200), save the JSON response to the Cache for 24 hours
        if ($response->getStatusCode() === 200 || $response->getStatusCode() === 201) {
            // We use getData(true) to extract the raw JSON array from the response
            Cache::put($cacheKey, $response->getData(true), now()->addHours(24));
        }

        return $response;
    }
}