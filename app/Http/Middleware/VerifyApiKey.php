<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Merchant;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized. Missing Bearer Token.'], 401);
        }

        // Validate token against api_keys table
        $apiKeyRecord = DB::table('api_keys')
            ->where('live_secret_key', $token)
            ->orWhere('test_secret_key', $token)
            ->first();

        if (!$apiKeyRecord) {
            return response()->json(['error' => 'Unauthorized. Invalid API Key.'], 401);
        }

        $merchant = Merchant::where('id', $apiKeyRecord->merchant_id)->where('is_active', true)->first();

        if (!$merchant) {
            return response()->json(['error' => 'Unauthorized. Merchant account inactive or suspended.'], 401);
        }

        // Pass the authenticated merchant into the request for controllers to use
        $request->merge(['_merchant' => $merchant]);
        
        // Also figure out if this is test mode
        $isTestMode = $token === $apiKeyRecord->test_secret_key;
        $request->merge(['_is_test_mode' => $isTestMode]);

        // If in test mode and performing a mutation (POST), return a mock success response
        if ($isTestMode && $request->isMethod('post')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Test mode simulated success',
                'data' => [
                    'reference' => 'TEST-' . time(),
                    'amount' => $request->input('amount', 0),
                    'is_mocked' => true
                ]
            ]);
        }

        return $next($request);
    }
}
