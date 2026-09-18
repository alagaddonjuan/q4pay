<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\BankAccount;

class VendorWalletController extends Controller
{
    public function index()
    {
        // Fetch actual wallet balance from the wallets table
        $wallet = DB::table('wallets')->where('user_id', Auth::id())->first();
        $availableBalance = $wallet ? $wallet->balance : 0;

        // Fetch their withdrawal history
        $withdrawals = DB::table('withdrawals')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Fetch their active primary bank
        $primaryBank = BankAccount::where('user_id', Auth::id())->where('is_active', true)->first();

        return view('dashboard.wallet.index', compact('availableBalance', 'withdrawals', 'primaryBank'));
    }

    public function storeBank(Request $request)
    {
        $request->validate([
            'bank_code' => 'required|string',
            'bank_name' => 'required|string',
            'account_number' => 'required|string|size:10',
        ]);

        $user = Auth::user();

        // 1. Security Lock: Ensure they have completed Dojah KYC
        if ($user->kyc_status !== 'verified' || empty($user->kyc_verified_name)) {
            return back()->withErrors(['error' => 'You must complete Identity Verification before adding a withdrawal account.']);
        }

        // 2. NUBAN Verification via Paystack
        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->withToken(env('PAYSTACK_SECRET_KEY'))
                ->get("https://api.paystack.co/bank/resolve", [
                    'account_number' => $request->account_number,
                    'bank_code' => $request->bank_code
                ]);

            if (!$response->successful()) {
                return back()->withErrors(['error' => 'Banking network rejected this account. Please check your account number and selected bank.']);
            }

            $resolvedAccountName = $response->json()['data']['account_name'];

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('NUBAN Resolve Crash: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Banking network is temporarily unavailable. Please try again.']);
        }

        // ==========================================
        // 3. THE SMART IDENTITY MATCHING ALGORITHM
        // ==========================================
        $kycNameParts = explode(' ', strtolower(trim($user->kyc_verified_name)));
        $bankNameParts = explode(' ', strtolower(trim($resolvedAccountName)));

        // Count how many significant words from the bank name exist in their official KYC name
        $matchedWords = 0;
        foreach ($bankNameParts as $word) {
            if (in_array($word, $kycNameParts) && strlen($word) >= 2) {
                $matchedWords++;
            }
        }

        // We strictly require at least 2 matching names (e.g., First Name AND Surname must match)
        $requiredMatches = min(2, count($kycNameParts)); 

        if ($matchedWords < $requiredMatches) {
            \Illuminate\Support\Facades\Log::warning("Fraud Prevention Triggered: KYC[{$user->kyc_verified_name}] attempted to link Bank[{$resolvedAccountName}]");
            
            return back()->withErrors(['error' => "Account name mismatch. Bank registered to '{$resolvedAccountName}', but your verified identity is '{$user->kyc_verified_name}'. Fraud prevention active."]);
        }

        // 4. Save the Verified Bank Account
        $hasExistingBanks = \App\Models\BankAccount::where('user_id', $user->id)->exists();

        \App\Models\BankAccount::create([
            'user_id' => $user->id,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => strtoupper($resolvedAccountName), // Lock in the official bank name
            'is_active' => !$hasExistingBanks, 
        ]);

        return back()->with('success', 'Bank account verified and securely linked to your profile!');
    }

    public function setDefaultBank($id)
    {
        BankAccount::where('user_id', Auth::id())->update(['is_active' => false]);

        $bank = BankAccount::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $bank->is_active = true;
        $bank->save();

        return back()->with('success', $bank->bank_name . ' is now your default payout account!');
    }

    // ==========================================
    // 🟢 SECURE WITHDRAWAL ENGINE (WITH OTP & FEES)
    // ==========================================
    public function sendOtp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000'
        ]);

        $user = Auth::user();

        // Check if there is already an active OTP to prevent spam
        if (\Illuminate\Support\Facades\Cache::has("withdrawal_otp_{$user->id}")) {
            return response()->json(['status' => 'error', 'message' => 'An OTP has already been sent to your email. Please check your inbox or wait before requesting a new one.'], 429);
        }

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        
        // Store in Cache for 15 minutes
        \Illuminate\Support\Facades\Cache::put("withdrawal_otp_{$user->id}", $otp, now()->addMinutes(15));
        
        // Store the amount requested so it can't be tampered with between OTP send and submit
        \Illuminate\Support\Facades\Cache::put("withdrawal_amount_{$user->id}", $request->amount, now()->addMinutes(15));

        // Send Email
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\WithdrawalOtpMail($otp, $request->amount));

        return response()->json(['status' => 'success', 'message' => 'A 6-digit OTP has been sent to your email.']);
    }

    public function requestWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000', // Minimum withdrawal of ₦1,000
            'pin' => 'required|digits:4',
            'otp' => 'required|digits:6'
        ]);

        $user = Auth::user();

        // 1A. Security Check: Verify dedicated 4-digit Transaction PIN
        if (!$user->transaction_pin) {
            return back()->withErrors(['error' => 'Please set up a 4-Digit Security PIN in your settings first.']);
        }
        
        if (!Hash::check($request->pin, $user->transaction_pin)) {
            return back()->withErrors(['error' => 'Incorrect Security PIN. Transaction aborted.']);
        }

        // 1B. Security Check: Verify Email OTP
        $storedOtp = \Illuminate\Support\Facades\Cache::get("withdrawal_otp_{$user->id}");
        $storedAmount = \Illuminate\Support\Facades\Cache::get("withdrawal_amount_{$user->id}");

        if (!$storedOtp || $storedOtp != $request->otp) {
            return back()->withErrors(['error' => 'Invalid or expired OTP. Please request a new one.']);
        }

        if ($storedAmount != $request->amount) {
            return back()->withErrors(['error' => 'The withdrawal amount was tampered with after requesting the OTP. Transaction aborted.']);
        }

        // Clear the OTP to prevent reuse
        \Illuminate\Support\Facades\Cache::forget("withdrawal_otp_{$user->id}");
        \Illuminate\Support\Facades\Cache::forget("withdrawal_amount_{$user->id}");

        // ==========================================
        // 2. Q4I OUTFLOW COMMISSION ENGINE
        // ==========================================
        $withdrawalAmount = $request->amount;
        $q4iFee = config('app.vendor_withdrawal_fee', 50.00);
$techvibsCost = config('app.techvibes_withdrawal_cost', 13.00);
        $q4iProfit = $q4iFee - $techvibsCost; // N87 Net Profit
        
        $totalDeduction = $withdrawalAmount + $q4iFee;

        // 3. Fetch Wallet & Verify Balance
        $wallet = DB::table('wallets')->where('user_id', $user->id)->first();
        if (!$wallet || $wallet->balance < $totalDeduction) {
            return back()->withErrors([
                'error' => 'Insufficient funds in your vault.',
                'message' => "Your balance must cover the withdrawal amount (₦" . number_format($withdrawalAmount) . ") plus the platform transfer fee (₦" . number_format($q4iFee) . ")."
            ]);
        }

        // 4. Ensure they have a primary bank set up
        $bank = BankAccount::where('user_id', $user->id)->where('is_active', true)->first();
        if (!$bank) {
            return back()->withErrors(['error' => 'Please add and select a destination bank account first.']);
        }

        $txnRef = 'Q4I-VEN-OUT-' . time() . '-' . rand(1000, 9999);

        // =========================================================================
        // 🔒 ATOMIC TRANSACTION PROCESSING (MONEY BLACKHOLE PROTECTION)
        // =========================================================================
        DB::beginTransaction();
        try {
            // A. Deduct Total Amount from wallet state instantly
            DB::table('wallets')->where('id', $wallet->id)->decrement('balance', $totalDeduction);

            // B. Trigger the automated live transfer via Techvibes API (SSL ENCRYPTED)
            // Note: ->withoutVerifying() has been strictly omitted to maintain full TLS integrity.
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.techvibes.token', env('TECHVIBES_API_TOKEN')),
                'Accept'        => 'application/json',
            ])->post(config('services.techvibes.base_url', 'https://api.techvibes.com/v1') . '/transfers', [
                'reference'             => $txnRef,
                'amount'                => $withdrawalAmount,
                'destination_account'   => $bank->account_number,
                'destination_bank_code' => $bank->bank_code,
                'narration'             => 'Q4I Escrow Settlement ' . $txnRef,
            ]);

            // C. Inspect the API payload explicitly. If it fails or times out, throw an exception!
            if (!$response->successful() || $response->json('status') !== 'success') {
                $errorReason = $response->json('message') ?? 'External settlement infrastructure connection error.';
                throw new \Exception("Techvibes Rejected Payout: " . $errorReason);
            }

            // D. Log the withdrawal request as successful since the bank accepted the payload
            DB::table('withdrawals')->insert([
                'user_id' => $user->id,
                'amount' => $withdrawalAmount,
                'fee_charged' => $q4iFee, 
                'bank_name' => $bank->bank_name,
                'account_number' => $bank->account_number,
                'account_name' => $bank->account_name,
                'status' => 'success', 
                'reference' => $txnRef,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // E. LOG Q4I PROFIT TO SYSTEM EARNINGS
            DB::table('system_earnings')->insert([
                'transaction_ref' => $txnRef,
                'merchant_id' => null, 
                'type' => 'vendor_outflow_profit',
                'amount' => $q4iProfit, 
                'created_at' => now()
            ]);

            // F. Everything cleared perfectly. Commit state changes permanently to database.
            DB::commit();

            return back()->with('success', 'Withdrawal of ₦' . number_format($withdrawalAmount, 2) . ' processed successfully. Funds are currently en route to your bank account.');

        } catch (\Exception $e) {
            // G. Failure safeguards: instantly reverse balance deductions if anything breaks mid-flight
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Vendor Withdrawal Money Blackhole Prevented: ' . $e->getMessage());
            
            return back()->withErrors([
                'error' => 'The external payout gateway failed to process this transfer. Your vault funds have been safely restored to your balance.'
            ]);
        }
    }
}