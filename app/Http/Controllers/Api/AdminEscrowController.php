<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EscrowTransaction;
use App\Models\VirtualAccount;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminEscrowController extends Controller
{
    /**
     * 🟢 SECURE AUTHENTICATION GATE
     */
    private function authenticateMasterAdmin(Request $request)
    {
        $masterKey = $request->header('X-Q4I-Master-Key');
        $validKey = env('Q4I_MASTER_KEY', 'q4i_super_admin_secret_999'); 
        
        return $masterKey === $validKey;
    }

    /**
     * ADMIN ACTION: Refund the Buyer (The Red Button)
     */
    public function refundBuyer(Request $request, $id)
    {
        if (!$this->authenticateMasterAdmin($request)) {
            return response()->json(['error' => 'Unauthorized. Master Key Required.'], 401);
        }

        $escrow = EscrowTransaction::find($id);

        if (!$escrow || $escrow->status !== 'disputed') {
            return response()->json(['error' => 'Transaction not found or not in a disputed state.'], 400);
        }

        DB::beginTransaction();
        try {
            // 1. Update Escrow Status
            $escrow->update(['status' => 'refunded']);

            // 2. Zero out the disposable holding account so system liabilities are accurate
            $disposableAccount = VirtualAccount::where('account_number', $escrow->disposable_account)->first();
            if ($disposableAccount) {
                $disposableAccount->update(['ledger_balance' => 0.00]);
            }

            // 3. Queue the Refund for Manual/Outbound Processing
            // Since NIBSS inbound transfers cannot be auto-reversed, we log it to a payout queue.
            DB::table('refunds_queue')->insert([
                'escrow_id' => $escrow->id,
                'buyer_phone' => $escrow->buyer_phone,
                'amount_due' => $escrow->amount, // You usually do not refund shipping fees if already incurred
                'status' => 'awaiting_bank_details',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            // 4. Notify the Buyer via WhatsApp
            $buyerPhone = $this->formatPhoneForMeta($escrow->buyer_phone);
            $this->sendMessage('whatsapp', $buyerPhone, "⚖️ *DISPUTE RESOLVED: Refund Issued*\n\nOur Admin team has reviewed your dispute regarding *{$escrow->item_description}* and ruled in your favor.\n\nThe transaction has been cancelled. Please check your SMS/Email for a secure link to provide your bank details so we can route your ₦" . number_format($escrow->amount, 2) . " refund.");

            // 5. Notify the Vendor via WhatsApp
            $vendor = User::find($escrow->vendor_id);
            if ($vendor) {
                $vendorPhone = $this->formatPhoneForMeta($vendor->phone);
                $this->sendMessage('whatsapp', $vendorPhone, "⚖️ *DISPUTE RESOLVED: Refund Issued*\n\nOur Admin team has completed the review for the disputed *{$escrow->item_description}*.\n\nWe have ruled in favor of the buyer, and the locked funds have been scheduled for a refund. If you need further clarification, please contact vendor support.");
            }

            return response()->json(['status' => 'success', 'message' => 'Buyer refunded. Added to refunds queue.']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Admin Refund Error: " . $e->getMessage());
            return response()->json(['error' => 'System error during refund process.'], 500);
        }
    }

    /**
     * ADMIN ACTION: Force Payout to Vendor (The Green Button)
     */
    public function forcePayout(Request $request, $id)
    {
        if (!$this->authenticateMasterAdmin($request)) {
            return response()->json(['error' => 'Unauthorized. Master Key Required.'], 401);
        }

        $escrow = EscrowTransaction::find($id);

        if (!$escrow || $escrow->status !== 'disputed') {
            return response()->json(['error' => 'Transaction not found or not in a disputed state.'], 400);
        }

        $vendor = User::find($escrow->vendor_id);
        if (!$vendor) {
            return response()->json(['error' => 'Vendor not found in the system.'], 404);
        }

        DB::beginTransaction();
        try {
            // 1. Calculate the Q4I Platform Commission (e.g., 2% Escrow Fee)
            $platformFee = $escrow->amount * 0.02;
            $netPayout = $escrow->amount - $platformFee;

            // 2. Empty the disposable holding account
            $disposableAccount = VirtualAccount::where('account_number', $escrow->disposable_account)->first();
            if ($disposableAccount) {
                $disposableAccount->update(['ledger_balance' => 0.00]);
            }

            // 3. Move the Net Funds to the Vendor's Main Wallet
            $vendor->increment('wallet_balance', $netPayout);

            // 4. Update the Escrow Transaction Status
            $escrow->update(['status' => 'released']);

            // 5. 🟢 LOG Q4I PROFIT TO SYSTEM EARNINGS
            DB::table('system_earnings')->insert([
                'transaction_ref' => $escrow->reference,
                'merchant_id' => $vendor->id,
                'type' => 'escrow_commission',
                'amount' => $platformFee,
                'created_at' => now()
            ]);

            // 6. Update Vendor's Inventory
            $product = Product::where('user_id', $escrow->vendor_id)
                        ->where('name', $escrow->item_description)
                        ->first();

            if ($product) {
                $product->increment('total_sold'); 
                if ($product->stock_left > 0) {
                    $product->decrement('stock_left');
                }
            }

            DB::commit();

            // 7. Notify the Vendor (Success)
            $vendorPhone = $this->formatPhoneForMeta($vendor->phone);
            $this->sendMessage('whatsapp', $vendorPhone, "⚖️ *DISPUTE RESOLVED: Funds Released!*\n\nOur Admin team has reviewed the dispute for *{$escrow->item_description}* and ruled in your favor.\n\nThe freeze has been lifted and ₦" . number_format($netPayout, 2) . " (after platform fees) has been successfully credited to your Q4I wallet.");

            // 8. Notify the Buyer (Rejection)
            $buyerPhone = $this->formatPhoneForMeta($escrow->buyer_phone);
            $this->sendMessage('whatsapp', $buyerPhone, "⚖️ *DISPUTE RESOLVED: Claim Rejected*\n\nOur Admin team has completed the investigation regarding *{$escrow->item_description}*.\n\nBased on the evidence, your dispute claim has been closed and the funds have been released to the vendor. Please check your email for the detailed resolution report.");

            return response()->json(['status' => 'success', 'message' => 'Funds forced to vendor successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Force Payout Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to release funds. Please check logs.'], 500);
        }
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
                
                $response = Http::withoutVerifying()->withToken($token)->post($url, $payload);
                
                if (!$response->successful()) {
                    Log::warning('WhatsApp Delivery Failed: ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::error('WhatsApp Exception: ' . $e->getMessage());
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