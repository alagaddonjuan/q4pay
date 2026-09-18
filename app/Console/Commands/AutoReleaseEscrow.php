<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EscrowTransaction;
use App\Models\VirtualAccount;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AutoReleaseEscrow extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'escrow:auto-release';

    /**
     * The console command description.
     */
    protected $description = 'Automatically releases escrow funds 24 hours after delivery if no dispute is raised.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scanning for expired escrows...');

        // 🟢 FIXED: Use the exact 'auto_release_at' timestamp we set in the webhook!
        // This is much safer than calculating 'delivered_at' dynamically.
        $expiredEscrows = EscrowTransaction::where('status', 'locked') // Ensure it is actually locked
            ->whereNotNull('auto_release_at')
            ->where('auto_release_at', '<=', now())
            ->get();

        if ($expiredEscrows->isEmpty()) {
            $this->info('No expired escrows found. Sleeping...');
            return;
        }

        foreach ($expiredEscrows as $escrow) {
            DB::beginTransaction();
            try {
                $vendor = User::find($escrow->vendor_id);
                if (!$vendor) {
                    throw new \Exception("Vendor {$escrow->vendor_id} not found.");
                }

                // 1. Calculate Q4I Commission (e.g., 2% Escrow Fee)
                $platformFee = $escrow->amount * 0.02;
                $netPayout = $escrow->amount - $platformFee;

                // 2. Empty the disposable holding account
                $disposableAccount = VirtualAccount::where('account_number', $escrow->disposable_account)->first();
                if ($disposableAccount) {
                    $disposableAccount->update(['ledger_balance' => 0.00]);
                }

                // 3. Move Net Funds to Vendor Wallet
                $vendor->increment('wallet_balance', $netPayout);

                // 4. Log Q4I Profit to System Earnings
                DB::table('system_earnings')->insert([
                    'transaction_ref' => $escrow->reference,
                    'merchant_id' => $vendor->id,
                    'type' => 'escrow_auto_release_commission',
                    'amount' => $platformFee,
                    'created_at' => now()
                ]);

                // 5. Update Escrow Status
                $escrow->update(['status' => 'released']);

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

                // 7. Notify Users via WhatsApp
                $this->sendNotifications($escrow, $netPayout);

                $this->info("✅ Successfully auto-released Escrow ID: {$escrow->id}");

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Auto-Release Error for Escrow {$escrow->id}: " . $e->getMessage());
                $this->error("Failed to release Escrow ID: {$escrow->id}");
            }
        }
    }

    /**
     * ==========================================
     * WHATSAPP NOTIFICATION HELPERS
     * ==========================================
     */
    private function sendNotifications($escrow, $netPayout)
    {
        $vendor = User::find($escrow->vendor_id);
        $vendorPhone = $vendor ? $this->formatPhoneForMeta($vendor->phone) : null;
        $buyerPhone = $this->formatPhoneForMeta($escrow->buyer_phone);

        // Tell the Vendor they got paid (showing their NET amount!)
        if ($vendorPhone) {
            $this->sendMessage('whatsapp', $vendorPhone, "⏰ *AUTO-RELEASE: Funds Credited!*\n\n24 hours have passed since the delivery of *{$escrow->item_description}* with no disputes raised. \n\n₦" . number_format($netPayout, 2) . " (after platform fees) has been automatically released to your Q4I wallet!");
        }

        // Tell the Buyer the window closed
        if ($buyerPhone) {
            $this->sendMessage('whatsapp', $buyerPhone, "⏰ *AUTO-RELEASE COMPLETED*\n\nYour 24-hour inspection period for *{$escrow->item_description}* has expired. The funds have been automatically released to the vendor. \n\nThank you for using Q4I Escrow!");
        }
    }

    private function sendMessage($platform, $to, $message)
    {
        if (!$to) return;
        
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
                Log::warning("WhatsApp Delivery Failed in Auto-Release: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("WhatsApp Exception in Auto-Release: " . $e->getMessage());
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