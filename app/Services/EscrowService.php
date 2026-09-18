<?php

namespace App\Services;

use App\Models\EscrowTransaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Exception;

class EscrowService
{
    /**
     * 1. FUND THE ESCROW & SECURE LOGISTICS (The Webhook Entry Point)
     * Called the millisecond the buyer's bank transfer hits the Virtual Account.
     */
    public function lockEscrowFunds(EscrowTransaction $escrow, float $amount = null)
    {
        // 1. Prevent double-funding
        if ($escrow->status === 'funded_locked') {
            return true; 
        }

        $result = DB::transaction(function () use ($escrow, $amount) {
            
            // Only increment the wallet if an amount was passed (some flows might just need the status update)
            if ($amount !== null) {
                $vendorWallet = Wallet::where('user_id', $escrow->vendor_id)->first();
                if ($vendorWallet) {
                    $vendorWallet->increment('locked_balance', $amount);
                }
            }

            // Lock the Escrow Status
            $escrow->update(['status' => 'funded_locked']);
            
            // 1.5 Generate the 4-digit PIN now so we can text the raw PIN (and save the hash)
            $rawPin = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $escrow->update(['delivery_pin' => \Illuminate\Support\Facades\Hash::make($rawPin)]);
            
            // 2. Summon the Shipbubble Rider (ONLY IF NOT PICKUP)
            $vendor = \App\Models\User::find($escrow->vendor_id);
            $vendorMessage = "💰 *PAYMENT SECURED!*\n\nThe buyer has successfully transferred funds for *{$escrow->item_description}*.\nThe total amount is now securely locked in Q4I Escrow.\n";

            if ($vendor) {
                if (!$escrow->is_pickup) {
                    $shipbubble = new \App\Services\ShipbubbleService();
                    $shipmentData = $shipbubble->createShipment($escrow->delivery_address, $vendor);

                    if ($shipmentData) {
                        $trackingUrl = $shipmentData['tracking_url'] ?? 'N/A';
                        $courierName = $shipmentData['courier']['name'] ?? 'Your Courier';

                        $escrow->update([
                            'tracking_code'      => $shipmentData['order_id'] ?? null, 
                            'tracking_number'    => $shipmentData['order_id'] ?? null, 
                            'tracking_link'      => $trackingUrl,              
                            'logistics_provider' => $courierName,              
                            'courier_name'       => $courierName,              
                            'shipping_status'    => 'pending'                  
                        ]); 

                        $vendorMessage .= "\n🚀 *DISPATCH RIDER SUMMONED!*\n";
                        $vendorMessage .= "Courier: {$courierName}\n";
                        $vendorMessage .= "Tracking: {$trackingUrl}\n\n";
                        $vendorMessage .= "📦 Please package the item immediately. The rider is on their way.";
                    } else {
                        $vendorMessage .= "\n⚠️ *Logistics Alert:* Funds are secured, but we encountered a slight delay connecting to the dispatch rider. An admin will generate your waybill manually shortly.";
                    }
                } else {
                    $vendorMessage .= "\n🏪 *STORE PICKUP ALARM!*\n";
                    $vendorMessage .= "The buyer has chosen to pick up this item in-store. Please prepare the order for pickup.\n";
                    $vendorMessage .= "⚠️ *CRITICAL:* Do not hand over the item until the buyer gives you their 4-digit Delivery PIN. You must enter it in your dashboard to release the funds.";
                }
                
                // 3. Notify the Vendor via WhatsApp
                $this->sendWhatsAppMessage($vendor->phone, $vendorMessage);
            }

            // 4. Notify the Buyer and give them the PIN
            $buyerMessage = "💰 *PAYMENT CONFIRMED!*\n\n";
            $buyerMessage .= "Your payment for *{$escrow->item_description}* has been received and locked securely in the Q4I Vault.\n\n";
            
            if ($escrow->is_pickup) {
                $buyerMessage .= "📍 *STORE PICKUP:* Please proceed to the vendor's physical location to pick up your item.\n\n";
            } else {
                $buyerMessage .= "🚚 *DELIVERY INITIATED:* Your item will be shipped to your address shortly.\n\n";
            }
            
            $buyerMessage .= "🔐 *YOUR DELIVERY PIN: {$rawPin}*\n\n";
            $buyerMessage .= "⚠️ *DO NOT share this PIN with the vendor.*\nOnly give this 4-digit PIN to the vendor or dispatch rider *AFTER* you have received and inspected your package.";
            
            $this->sendWhatsAppMessage($escrow->buyer_phone, $buyerMessage);
            
            return $rawPin; // Return it so we can use it
        });

        // The transaction closure returns the value it evaluated to.
        return $result ?? true;
    }

    /**
     * Helper to send WhatsApp messages from the Service
     */
    private function sendWhatsAppMessage($phone, $message)
    {
        if (!$phone) return;

        // Clean phone number for Meta API
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '234' . substr($cleanPhone, 1);
        }

        $token = env('META_ACCESS_TOKEN');
        $url = 'https://graph.facebook.com/v25.0/' . env('META_PHONE_NUMBER_ID') . '/messages';
        
        $response = \Illuminate\Support\Facades\Http::withoutVerifying()->withToken($token)->post($url, [
            'messaging_product' => 'whatsapp',
            'to' => $cleanPhone,
            'type' => 'text',
            'text' => ['body' => $message]
        ]);

        if (!$response->successful()) {
            \Illuminate\Support\Facades\Log::error('EscrowService WhatsApp Send Failed: ' . $response->body() . ' TO: ' . $cleanPhone);
        }
    }

    /**
     * 2. RELEASE THE FUNDS (The Margin Engine)
     * Called when the buyer taps "Release" on WhatsApp, or Sendbox confirms delivery.
     */
    public function releaseEscrowFunds(EscrowTransaction $escrow)
    {
        // Security check: Allow standard release OR CEO dispute overrides
        if ($escrow->status !== 'funded_locked' && $escrow->status !== 'in_transit' && $escrow->status !== 'disputed') {
            throw new \Exception("Funds cannot be released. Current status: " . $escrow->status);
        }

        $totalAmount = $escrow->amount;
        
        // Calculate Q4I's 1.5% Margin (The Profit)
        $q4iMargin = $totalAmount * 0.015; 
        
        // Calculate what the vendor actually gets
        $vendorPayout = $totalAmount - $q4iMargin;

        // DB::transaction ensures if the server crashes on line 64, lines 60-63 reverse automatically.
        DB::transaction(function () use ($escrow, $totalAmount, $vendorPayout, $q4iMargin) {
            
            $vendorWallet = Wallet::where('user_id', $escrow->vendor_id)->firstOrFail();

            // STEP A: Remove the full amount from the locked vault
            $vendorWallet->decrement('locked_balance', $totalAmount);
            
            // STEP B: Add the vendor's cut to their actual withdrawable balance
            $vendorWallet->increment('balance', $vendorPayout);
            
            // STEP C: Route Q4I's profit to the Master Settlement Account
            $this->creditMasterWallet($q4iMargin);

            // STEP D: Close the transaction permanently
            $escrow->update([
                'status' => 'released',
                'q4i_fee' => $q4iMargin
            ]);
        });
    }

    /**
     * 3. DISPUTE RESOLUTION (The Auto-Reversal)
     * Called from your CEO Dashboard if the vendor scammed the buyer.
     */
    public function refundBuyer(EscrowTransaction $escrow)
    {
        // Security check
        if (!in_array($escrow->status, ['funded_locked', 'in_transit', 'disputed'])) {
            throw new Exception("Cannot refund a transaction in status: " . $escrow->status);
        }

        DB::transaction(function () use ($escrow) {
            $vendorWallet = Wallet::where('user_id', $escrow->vendor_id)->firstOrFail();

            // Remove the funds from the vendor's locked balance
            $vendorWallet->decrement('locked_balance', $escrow->amount);

            // Mark the transaction as refunded
            $escrow->update([
                'status' => 'refunded'
            ]);

            // Note: In a real environment, you would trigger your Payout API here 
            // to send the actual cash back to the $escrow->buyer_phone / bank account.
            // $this->payoutService->sendMoneyToBank(...);
        });
    }

    /**
     * Internal helper to safely credit the Q4I corporate wallet.
     */
    private function creditMasterWallet(float $amount)
    {
        // Assuming user_id 1 is the Master Q4I Admin account
        Wallet::where('user_id', 1)->increment('balance', $amount);
    }
}