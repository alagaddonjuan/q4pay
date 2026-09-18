<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;

class VendorOrderController extends Controller
{
    // Fetch all escrow transactions for this vendor
    public function index()
    {
        $orders = DB::table('escrow_transactions')
            ->where('vendor_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.orders.index', compact('orders'));
    }

    // View details of a specific escrow order
    public function show($reference)
    {
        // 1. Fetch the exact order using the reference ID
        $order = DB::table('escrow_transactions')
            ->where('vendor_id', Auth::id())
            ->where('reference', $reference)
            ->first();

        // 2. Security Check
        if (!$order) {
            return redirect()->route('vendor.orders.index')->withErrors(['error' => 'Order not found or unauthorized.']);
        }

        // 3. Create a Guest Buyer profile using the WhatsApp phone number from the transaction
        $buyer = (object) [
            'name'  => 'WhatsApp Buyer',
            'email' => 'Guest Checkout',
            'phone' => $order->buyer_phone ?? 'Unknown Number'
        ];

        return view('dashboard.orders.show', compact('order', 'buyer'));
    }

    // Verify the 4-Digit PIN when the buyer comes to pick up the item
   public function verifyPickupPin(Request $request, $id)
    {
        $request->validate([
            'delivery_pin' => 'required|digits:4'
        ]);

        // =========================================================================
        // 🚨 BRUTE-FORCE PROTECTION GATEKEEPER
        // =========================================================================
        // Create a unique cache key per order instance to prevent multi-order guessing
        $limiterKey = 'verify-pin:' . $id;

        // Check if the bad actor has already exhausted their 5 attempts
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($limiterKey, 5)) {
            $secondsRemaining = \Illuminate\Support\Facades\RateLimiter::availableIn($limiterKey);
            $minutesRemaining = ceil($secondsRemaining / 60);
            
            return back()->withErrors([
                'error' => "🚨 Too many failed PIN attempts. This order's verification mechanism has been locked for {$minutesRemaining} minutes to protect escrow funds."
            ]);
        }

        // 1. Fetch the order securely using unified table tracking
        $order = DB::table('escrow_transactions')
            ->where('id', $id)
            ->where('vendor_id', Auth::id())
            ->first();

        if (!$order) {
            return back()->withErrors(['error' => 'Order not found or unauthorized.']);
        }
        
        // 2. THE DISPUTE FREEZE LOCK
        if ($order->status === 'disputed') {
            Log::warning("Vendor attempted to use PIN on Disputed Order ID: {$order->id}");
            return back()->withErrors(['error' => '🚨 This order is under active dispute. All funds and PIN verifications are frozen until Q4I Admin resolves the issue.']);
        }

        // 3. Check if order is eligible for release
        if ($order->status !== 'locked' || !$order->is_pickup) {
            return back()->withErrors(['error' => 'This order is not eligible for PIN verification.']);
        }

        // =========================================================================
        // 🔒 SECURE CRYPTOGRAPHIC PIN VALIDATION
        // =========================================================================
        // Compare the raw request digits against the secure bcrypt hash in the database
        if (!\Illuminate\Support\Facades\Hash::check($request->delivery_pin, $order->delivery_pin)) {
            
            // Record this strike. If they hit 5 failures, lock them out for 15 minutes (900 seconds)
            \Illuminate\Support\Facades\RateLimiter::hit($limiterKey, 900);

            return back()->withErrors(['error' => 'Invalid PIN. Please ask the buyer to check their WhatsApp again.']);
        }

        // Clear the rate limiter records instantly upon successful validation
        \Illuminate\Support\Facades\RateLimiter::clear($limiterKey);

        // ==========================================
        // 🟢 REAL-TIME ESCROW FEE CALCULATOR
        // ==========================================
        $escrowFeePercent = 0.025; // Example: 2.5% platform fee per transaction. Change as desired.
        $platformFee = $order->amount * $escrowFeePercent;
        $vendorNetAmount = $order->amount - $platformFee;

        // 5. Execute Safe Settlement Ledgering
        DB::beginTransaction();
        try {
            // A. Update the transaction status to released
            DB::table('escrow_transactions')
                ->where('id', $id)
                ->update([
                    'status' => 'released',
                    'updated_at' => now()
                ]);

            // B. Top up the Vendor's Wallet balance with the NET amount only
            $wallet = DB::table('wallets')->where('user_id', Auth::id())->first();
            
            if ($wallet) {
                DB::table('wallets')->where('user_id', Auth::id())->increment('balance', $vendorNetAmount);
            } else {
                DB::table('wallets')->insert([
                    'user_id' => Auth::id(),
                    'balance' => $vendorNetAmount,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // C. Capture Platform Revenue instantly inside System Earnings Ledger
            if ($platformFee > 0) {
                DB::table('system_earnings')->insert([
                    'transaction_ref' => $order->reference,
                    'merchant_id' => null, // Configured as null since this belongs to a platform vendor
                    'type' => 'escrow_fee',
                    'amount' => $platformFee,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            return back()->with('success', 'Pickup verified! Funds (net of platform escrow fees) have been successfully transferred to your wallet balance.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Escrow Release Settlement Exception: ' . $e->getMessage());
            return back()->withErrors(['error' => 'A backend data processing failure occurred while trying to distribute funds safely.']);
        }
    }
}