<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EscrowTransaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class LogisticsWebhookController extends Controller
{
    /**
     * SHIPBUBBLE WEBHOOK HANDLER
     * Receives real-time tracking updates from the logistics network.
     */
    public function handleShipbubbleUpdate(Request $request)
    {
        // ==========================================
        // 1. SECURITY: Verify Shipbubble Signature
        // ==========================================
        $signature = $request->header('x-shipbubble-signature');
        $payload = $request->getContent();
        
        $expectedSignature = hash_hmac('sha256', $payload, env('SHIPBUBBLE_WEBHOOK_SECRET'));
        
        if (!hash_equals($expectedSignature, $signature)) {
            Log::warning("Unauthorized Shipbubble Webhook attempt detected.");
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        // ==========================================
        // 2. PARSE PAYLOAD
        // ==========================================
        $event = $request->input('event');
        $trackingCode = $request->input('data.tracking_code');
        $status = $request->input('data.status'); // 'shipped', 'in_transit', 'delivered', 'failed'

        $escrow = EscrowTransaction::where('tracking_code', $trackingCode)->first();

        if (!$escrow) {
            Log::warning("Webhook received for unknown tracking code: " . $trackingCode);
            return response()->json(['status' => 'ignored', 'message' => 'Tracking code not found'], 200);
        }

        // ==========================================
        // 3. THE ESCROW COUNTDOWN ENGINE
        // ==========================================
        if ($event === 'shipment.status_updated' && $status === 'delivered') {
            
            // Ensure we only trigger this once
            if ($escrow->status === 'locked') {
                
                // 1. Update the database to reflect delivery
                $escrow->update([
                    'delivery_status' => 'delivered',
                    'delivered_at' => now(),
                    // 🟢 THE COUNTDOWN TRIGGER: 24 hours from delivery
                    'auto_release_at' => now()->addHours(24) 
                ]);

                // 2. Notify the Buyer via WhatsApp
                $buyerPhone = $this->formatPhoneForMeta($escrow->buyer_phone);
                $this->sendMessage('whatsapp', $buyerPhone, "📦 *DELIVERY CONFIRMED!*\n\nYour order (*{$escrow->item_description}*) has been marked as delivered by the courier!\n\nPlease inspect your item. You have exactly 24 hours to report any issues or raise a dispute. If no action is taken, the funds will be automatically released to the vendor.\n\nReply 'DISPUTE' if there is an issue, or click here to manually release the funds: " . env('APP_URL') . "/release/" . $escrow->reference);

                // 3. Notify the Vendor via WhatsApp
                $vendor = \App\Models\User::find($escrow->vendor_id);
                if ($vendor) {
                    $vendorPhone = $this->formatPhoneForMeta($vendor->phone);
                    $this->sendMessage('whatsapp', $vendorPhone, "📦 *DELIVERY CONFIRMED!*\n\nGood news! Your shipment (*{$escrow->item_description}*) has been delivered.\n\nThe buyer's 24-hour inspection window has begun. If no dispute is raised, your funds (₦" . number_format($escrow->amount, 2) . ") will be automatically released to your wallet tomorrow.");
                }

                Log::info("Escrow Countdown Started for: " . $escrow->reference);
            }
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * ==========================================
     * UTILITY FUNCTIONS 
     * ==========================================
     */
    private function sendMessage($platform, $to, $message)
    {
        if (!$to) return;

        if ($platform === 'whatsapp') {
            try {
                $token = env('META_ACCESS_TOKEN');
                $url = 'https://graph.facebook.com/v25.0/' . env('META_PHONE_NUMBER_ID') . '/messages';
                $payload = [
                    'messaging_product' => 'whatsapp',
                    'to' => $to,
                    'type' => 'text',
                    'text' => ['body' => $message]
                ];
                Http::withoutVerifying()->withToken($token)->post($url, $payload);
            } catch (\Exception $e) {
                Log::error('WhatsApp Notification Exception: ' . $e->getMessage());
            }
        }
    }

    private function formatPhoneForMeta($phone)
    {
        if (!$phone) return null;
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            return '234' . substr($phone, 1);
        }
        return $phone;
    }
}