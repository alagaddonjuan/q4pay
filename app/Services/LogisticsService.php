<?php

namespace App\Services;

use App\Models\EscrowTransaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class LogisticsService
{
    /**
     * Triggered immediately after the buyer funds the Escrow Virtual Account.
     */
    public function dispatchRider(EscrowTransaction $escrow)
    {
        try {
            // Ping the Sendbox API (or your chosen logistics provider)
            // We pass the vendor's saved address and the buyer's destination
            $response = Http::withToken(env('SENDBOX_API_KEY'))
                ->post('https://live.sendbox.co/v1/shipments', [
                    'origin_address' => $escrow->vendor->business_address,
                    'destination_phone' => $escrow->buyer_phone, // Crucial for the rider
                    'item_description' => $escrow->item_description,
                    'weight' => 1, // Defaulting to 1kg for standard social commerce
                    'callback_url' => env('APP_URL') . '/api/v1/webhooks/logistics' // Where Sendbox pings us back
                ]);

            if ($response->failed()) {
                throw new Exception("Logistics API failed: " . $response->body());
            }

            $data = $response->json();

            // Save the tracking code to our Q4I Escrow Database
            $escrow->update([
                'status' => 'in_transit',
                'logistics_provider' => 'Sendbox',
                'tracking_code' => $data['tracking_code']
            ]);

            return true;

        } catch (Exception $e) {
            // If the logistics API goes down, we log it heavily so the CEO Dashboard catches it
            Log::critical('Logistics Dispatch Failed for Escrow ID: ' . $escrow->reference . ' Error: ' . $e->getMessage());
            return false;
        }
    }
}