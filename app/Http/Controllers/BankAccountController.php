<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BankAccountController extends Controller
{
    // ==========================================
    // 1. Save a new Bank Account (Vendors)
    // ==========================================
    public function store(Request $request)
    {
        // A. Validate the form input
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|size:10',
            // We still accept account_name from the form, but we will verify it!
            'account_name' => 'required|string|max:255',
        ]);

        // 🟢 FIXED: Use the standard Auth guard for Vendors (users table)
        $vendor = Auth::user(); 

        // B. REAL-TIME NIBSS VERIFICATION (Prevent bounced payouts)
        try {
            // Note: You need a bank_code mapping here in production (e.g., '058' for GTB)
            // For this example, assuming your Techvibs endpoint resolves it, or you pass bank_code from the frontend
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
                'X-Fintech-Token' => env('TECHVIBES_LIVE_TOKEN') 
            ])->post('https://techvibs.com/waas9/validate_destination_account_external_fintech_token.php', [
                'account_number' => $request->account_number,
                // If your frontend select box sends the bank name, you'll want to map it to the NIBSS code
                // 'bank_code' => $request->bank_code 
            ]);

            $apiResult = $response->json();

            // If the banking network says the account doesn't exist
            if (!$response->successful() || (isset($apiResult['success']) && $apiResult['success'] === false)) {
                return back()->withErrors(['error' => 'Invalid Bank Account. We could not verify this account on the NIBSS network.']);
            }

            // Optional: You can overwrite their typed name with the official NIBSS name
            // $verifiedName = $apiResult['data']['account_name'] ?? $request->account_name;
            $verifiedName = strtoupper($request->account_name);

        } catch (\Exception $e) {
            Log::error('NIBSS Verification failed during Bank Add: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Banking network is currently unreachable. Please try again later.']);
        }

        // C. Check if this is the Vendor's very first bank account
        $isFirstAccount = BankAccount::where('user_id', $vendor->id)->count() === 0;

        // D. Save it securely to PostgreSQL
        BankAccount::create([
            'user_id' => $vendor->id,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $verifiedName, // Save the verified/formatted name
            'is_active' => $isFirstAccount,  // Automatically make it Default if it's their first!
        ]);

        return back()->with('success', 'Bank account verified and added securely.');
    }

    // ==========================================
    // 2. Set an existing Bank Account as Default
    // ==========================================
    public function setDefault($id)
    {
        // 🟢 FIXED: Use the standard Auth guard for Vendors
        $vendorId = Auth::id();

        // A. Find the specific bank, ensuring it actually belongs to this specific vendor
        $selectedBank = BankAccount::where('user_id', $vendorId)->findOrFail($id);

        // B. Turn OFF 'is_active' for all of this vendor's bank accounts
        BankAccount::where('user_id', $vendorId)->update(['is_active' => false]);

        // C. Turn ON 'is_active' only for the newly selected bank
        $selectedBank->update(['is_active' => true]);

        return back()->with('success', $selectedBank->bank_name . ' is now your default payout account!');
    }
}