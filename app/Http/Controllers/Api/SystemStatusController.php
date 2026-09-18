<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SystemStatusController extends Controller
{
    public function checkStatus()
    {
        $services = [];
        $overallStatus = 'green';
        $message = 'All Systems Operational';

        // 1. Database Check
        try {
            DB::connection()->getPdo();
            $services['database'] = ['name' => 'PostgreSQL Database', 'status' => 'online'];
        } catch (\Exception $e) {
            $services['database'] = ['name' => 'PostgreSQL Database', 'status' => 'offline'];
            $overallStatus = 'red';
        }

        // 2. Cache/Redis Check
        try {
            Cache::put('health_ping', true, 1);
            $services['cache'] = ['name' => 'System Cache', 'status' => 'online'];
        } catch (\Exception $e) {
            $services['cache'] = ['name' => 'System Cache', 'status' => 'offline'];
            $overallStatus = $overallStatus === 'red' ? 'red' : 'yellow';
        }

        // 3. Meta / WhatsApp API Check
       try {
            \Illuminate\Support\Facades\Http::withoutVerifying()->timeout(3)->get('https://graph.facebook.com/v25.0/');
            $services['whatsapp'] = ['name' => 'WhatsApp Cloud API', 'status' => 'online'];
        } catch (\Exception $e) {
            $services['whatsapp'] = ['name' => 'WhatsApp Cloud API', 'status' => 'offline'];
            $overallStatus = $overallStatus === 'red' ? 'red' : 'yellow';
        }

        // 4. Shipbubble Logistics Check
        try {
            \Illuminate\Support\Facades\Http::withoutVerifying()->timeout(3)->get('https://api.shipbubble.com/v1/');
            $services['shipbubble'] = ['name' => 'Shipbubble Logistics', 'status' => 'online'];
        } catch (\Exception $e) {
            $services['shipbubble'] = ['name' => 'Shipbubble Logistics', 'status' => 'offline'];
            $overallStatus = $overallStatus === 'red' ? 'red' : 'yellow';
        }

        // Determine final master status
        if ($overallStatus === 'red') {
            $message = 'System Outage';
        } elseif ($overallStatus === 'yellow') {
            $message = 'Degraded Performance';
        }

        return response()->json([
            'success' => true,
            'data' => [
                'status' => $overallStatus,
                'message' => $message,
                'services' => $services
            ]
        ]);
    }
}