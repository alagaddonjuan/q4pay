<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShipbubbleService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('SHIPBUBBLE_API_KEY');
        $this->baseUrl = 'https://api.shipbubble.com/v1'; 
    }

    /**
     * Helper Method: Turns a text address into a Shipbubble Address Code
     */
    private function getAddressCode($addressText, $name, $email, $phone)
    {
        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . trim($this->apiKey),
                    'Content-Type'  => 'application/json'
                ])
                ->post($this->baseUrl . '/shipping/address/validate', [
                    'name'    => $name,
                    'email'   => $email,
                    'phone'   => $phone,
                    'address' => $addressText
                ]);

            if ($response->successful()) {
                return $response->json('data.address_code');
            }
            
            throw new \Exception("Address Error ($addressText): " . $response->body());

        } catch (\Exception $e) {
            throw new \Exception("Address Exception: " . $e->getMessage());
        }
    }

    /**
     * Helper Method: Fetch a valid category ID directly from the current environment
     */
    private function getValidCategoryId()
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . trim($this->apiKey),
                    'Content-Type'  => 'application/json'
                ])
                ->get($this->baseUrl . '/shipping/labels/categories');

            if ($response->successful()) {
                $categories = $response->json('data');
                if (!empty($categories) && isset($categories[0]['category_id'])) {
                    return $categories[0]['category_id'];
                }
                throw new \Exception("Category Array was empty.");
            }
            
            throw new \Exception("Category Fetch Failed: " . $response->body());

        } catch (\Exception $e) {
            throw new \Exception("Category Exception: " . $e->getMessage());
        }
    }

    /**
     * THE MASTER METHOD: Fetch the cheapest delivery rate dynamically!
     */
    public function getCheapestRate($buyerAddress, $vendor)
    {
        if (empty($this->apiKey)) {
            throw new \Exception("SHIPBUBBLE_API_KEY is completely missing or empty in your live .env file.");
        }

        // 1. EXTRACT VENDOR DATA 
        $vName = $vendor->name ?? 'Retail Vendor';
        $vEmail = $vendor->email ?? 'vendor@q4i.com';
        $vPhone = $vendor->phone ?? '08000000000';
        
        // 🔴 THE FIX: Dynamically combine the new database columns to form a complete address
        $street = rtrim($vendor->address ?? '15 Allen Avenue', ', ');
        $city = $vendor->city ? ', ' . $vendor->city : '';
        $state = $vendor->state ? ', ' . $vendor->state : '';
        $vAddress = $street . $city . $state . ', Nigeria';
        
        // STEP 1: Get Sender Address Code 
        $senderCode = $this->getAddressCode($vAddress, $vName, $vEmail, $vPhone);
        
        // STEP 2: Get Receiver Address Code 
        $smartBuyerAddress = rtrim($buyerAddress, ', ') . ', Nigeria';
        $receiverCode = $this->getAddressCode($smartBuyerAddress, 'Retail Buyer', 'buyer@q4i.com', '08098765432');

        // STEP 2.5: Dynamically fetch a valid category ID
        $categoryId = $this->getValidCategoryId();

        if (!$senderCode || !$receiverCode || !$categoryId) {
            throw new \Exception("Missing prerequisite. Sender: $senderCode | Receiver: $receiverCode | Category: $categoryId");
        }

        // STEP 3: Fetch the Live Rate!
        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . trim($this->apiKey),
                    'Content-Type'  => 'application/json'
                ])
                ->post($this->baseUrl . '/shipping/fetch_rates', [
                    'sender_address_code'   => $senderCode,
                    'reciever_address_code' => $receiverCode, 
                    'pickup_date'           => now()->addDay()->format('Y-m-d'), 
                    'category_id'           => $categoryId,
                    'package_items'         => [
                        [
                            'name'         => 'Escrow Item',
                            'description'  => 'Item purchased via Q4I Escrow',
                            'unit_weight'  => '1',
                            'unit_amount'  => '5000',
                            'quantity'     => '1'
                        ]
                    ],
                    'package_dimension'     => [
                        'length' => 10,
                        'width'  => 10,
                        'height' => 10
                    ]
                ]);

            if ($response->successful()) {
                $cheapestTotal = $response->json('data.cheapest_courier.total');
                if ($cheapestTotal) {
                    return (float) $cheapestTotal;
                }
                throw new \Exception("Rate API succeeded, but could not find 'cheapest_courier.total' in response.");
            }
            
            throw new \Exception('Shipbubble Rates API Error: ' . $response->body());

        } catch (\Exception $e) {
            throw new \Exception('Shipbubble Rates Exception: ' . $e->getMessage()); 
        }
    }

    /**
     * THE FULFILLMENT METHOD: Books the actual shipment and summons the dispatch rider!
     */
    public function createShipment($buyerAddress, $vendor)
    {
        if (empty($this->apiKey)) {
            return null; 
        }

        // 1. Get the dynamic vendor and buyer data
        $vName = $vendor->name ?? 'Retail Vendor';
        $vEmail = $vendor->email ?? 'vendor@q4i.com';
        $vPhone = $vendor->phone ?? '08000000000';
        
        // 🔴 THE FIX: Dynamically combine the new database columns to form a complete address
        $street = rtrim($vendor->address ?? '15 Allen Avenue', ', ');
        $city = $vendor->city ? ', ' . $vendor->city : '';
        $state = $vendor->state ? ', ' . $vendor->state : '';
        $vAddress = $street . $city . $state . ', Nigeria';
        
        $senderCode = $this->getAddressCode($vAddress, $vName, $vEmail, $vPhone);
        $smartBuyerAddress = rtrim($buyerAddress, ', ') . ', Nigeria';
        $receiverCode = $this->getAddressCode($smartBuyerAddress, 'Retail Buyer', 'buyer@q4i.com', '08098765432');
        $categoryId = $this->getValidCategoryId();

        if (!$senderCode || !$receiverCode || !$categoryId) {
            return null; 
        }

        try {
            // 2. FETCH A FRESH RATE (To get the required token and IDs)
            $rateResponse = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . trim($this->apiKey),
                    'Content-Type'  => 'application/json'
                ])
                ->post($this->baseUrl . '/shipping/fetch_rates', [
                    'sender_address_code'   => $senderCode,
                    'reciever_address_code' => $receiverCode, 
                    'pickup_date'           => now()->addDay()->format('Y-m-d'), 
                    'category_id'           => $categoryId,
                    'package_items'         => [
                        [
                            'name'         => 'Escrow Item',
                            'description'  => 'Item purchased via Q4I Escrow',
                            'unit_weight'  => '1',
                            'unit_amount'  => '5000',
                            'quantity'     => '1'
                        ]
                    ],
                    'package_dimension'     => [
                        'length' => 10, 'width' => 10, 'height' => 10
                    ]
                ]);

            if ($rateResponse->successful()) {
                $data = $rateResponse->json('data');
                $requestToken = $data['request_token'] ?? null;
                $courierId = $data['cheapest_courier']['courier_id'] ?? null;
                $serviceCode = $data['cheapest_courier']['service_code'] ?? null;

                // 3. SECURE THE SHIPMENT! Fire the tokens into the Labels API
                if ($requestToken && $courierId && $serviceCode) {
                    $bookResponse = \Illuminate\Support\Facades\Http::withoutVerifying()
                        ->withHeaders([
                            'Authorization' => 'Bearer ' . trim($this->apiKey),
                            'Content-Type'  => 'application/json'
                        ])
                        ->post($this->baseUrl . '/shipping/labels', [
                            'request_token' => $requestToken,
                            'service_code'  => $serviceCode,
                            'courier_id'    => $courierId
                        ]);

                    if ($bookResponse->successful()) {
                        // Return the tracking data so we can text it to the vendor!
                        return $bookResponse->json('data'); 
                    }
                    Log::error('Shipbubble Booking Error: ' . $bookResponse->body());
                }
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Shipbubble Booking Exception: ' . $e->getMessage());
            return null; 
        }
    }
}