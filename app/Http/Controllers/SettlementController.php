<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\AuditLogger;

class SettlementController extends Controller
{
    use AuditLogger;

    public function index(Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        // 1. Fetch available balance (wallet_balance)
        $availableBalance = $merchant->wallet_balance ?? 0;

        // 2. Fetch saved bank accounts
        $savedBanks = DB::table('merchant_bank_accounts')
                        ->where('merchant_id', $merchant->id)
                        ->orderByDesc('is_default')
                        ->orderByDesc('created_at')
                        ->get();

        // 3. Fetch past payout requests
        $payouts = Transaction::where('merchant_id', $merchant->id)
                     ->where('type', 'debit')
                     ->where('session_id', 'like', 'Q4I-PAY-%')
                     ->orderByDesc('created_at')
                     ->paginate(10);

        return view('merchant.settlements.index', compact('merchant', 'availableBalance', 'savedBanks', 'payouts'));
    }

    public function verifyAccount(Request $request)
    {
        $request->validate([
            'bank_code' => 'required|string',
            'account_number' => 'required|string|size:10'
        ]);

        try {
            // Resolve account via Paystack
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()->withToken(env('PAYSTACK_SECRET_KEY'))
                ->get('https://api.paystack.co/bank/resolve', [
                    'account_number' => $request->account_number,
                    'bank_code' => $request->bank_code
                ]);

            $apiResult = $response->json();
            
            if ($response->successful() && isset($apiResult['status']) && $apiResult['status'] === true && !empty($apiResult['data']['account_name'])) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'account_name' => $apiResult['data']['account_name']
                    ]
                ]);
            }
            
            return response()->json([
                'status' => 'error',
                'message' => $apiResult['message'] ?? 'Could not verify account details.'
            ], 400);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Paystack Name Enquiry Failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Verification service unavailable.'
            ], 500);
        }
    }

    public function addBank(Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        $validated = $request->validate([
            'bank_code' => 'required|string',
            'bank_name' => 'required|string',
            'account_number' => 'required|string|min:10|max:10',
            'account_name' => 'required|string'
        ]);

        $isFirst = DB::table('merchant_bank_accounts')->where('merchant_id', $merchant->id)->count() === 0;

        DB::table('merchant_bank_accounts')->insert([
            'merchant_id' => $merchant->id,
            'bank_code' => $validated['bank_code'],
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_name' => strtoupper($validated['account_name']),
            'is_default' => $isFirst,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Settlement account added successfully!');
    }

    public function setupPin(Request $request)
    {
        $validated = $request->validate([
            'pin' => 'required|digits:4',
            'pin_confirmation' => 'required|same:pin'
        ]);

        $merchant = \App\Models\Merchant::current();
        
        // Hash the PIN securely and save it to the user's profile
        $merchant->transaction_pin = Hash::make($validated['pin']);
        $merchant->save();

        return redirect()->back()->with('success', 'Your 4-Digit Transaction PIN has been successfully set and secured!');
    }

    // ==========================================
    // 🟢 SECURE PAYOUT ENGINE (WITH N100 FEE)
    // ==========================================
    public function requestPayout(Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        $validated = $request->validate([
            'bank_account_id' => 'required|exists:merchant_bank_accounts,id',
            'amount' => 'required|numeric|min:100',
            'pin' => 'required|digits:4',
            'totp_code' => 'nullable|string'
        ]);

        // 1. PIN Shield
        if (!$merchant->transaction_pin) {
            return redirect()->back()->withErrors(['Please set a Transaction PIN in your settings before withdrawing.']);
        }
        if (!Hash::check($validated['pin'], $merchant->transaction_pin)) {
            return redirect()->back()->withErrors(['Invalid Transaction PIN.']);
        }

        // 1.5 2FA Shield
        if ($merchant->two_factor_enabled) {
            if (empty($validated['totp_code'])) {
                return redirect()->back()->withErrors(['Please provide your 2FA Authenticator code.']);
            }
            $google2fa = new \PragmaRX\Google2FA\Google2FA();
            $valid = $google2fa->verifyKey($merchant->two_factor_secret, $validated['totp_code']);
            if (!$valid) {
                return redirect()->back()->withErrors(['Invalid 2FA code. Please try again.']);
            }
        }

        // ==========================================
        // 2. Q4I OUTFLOW COMMISSION CALCULATIONS
        // ==========================================
        $withdrawalAmount = $validated['amount'];
        $q4iFee = 100.00; // Flat platform withdrawal fee
        $techvibsCost = 13.00; // NIBSS cost
        $q4iProfit = $q4iFee - $techvibsCost; // N87 Net Profit
        
        $totalDeduction = $withdrawalAmount + $q4iFee;

        // 3. Balance Check (Must cover withdrawal + N100 fee)
        if ($merchant->wallet_balance < $totalDeduction) {
            return redirect()->back()->withErrors([
                "Insufficient funds. Your balance must cover the withdrawal amount (₦" . number_format($withdrawalAmount) . ") plus the ₦100 platform fee."
            ]);
        }

        // 4. Pre-fetch Data
        $bank = DB::table('merchant_bank_accounts')->where('id', $validated['bank_account_id'])->first();
        $txnRef = 'Q4I-PAY-' . time() . '-' . rand(1000, 9999);

        // Fetch a valid account ID to satisfy the database schema (Fallback to null)
        $account = \App\Models\VirtualAccount::whereHas('agent', function($q) use ($merchant) {
            $q->where('merchant_id', $merchant->id);
        })->first();

        // Calculate balances securely before decrementing
        $balanceBefore = $merchant->wallet_balance;
        $balanceAfter = $balanceBefore - $totalDeduction;

        // 5. Lock Funds, Apply Fees, & Save Transaction
        DB::beginTransaction();
        try {
            // Deduct the full amount (Withdrawal + Fee) from the merchant
            $merchant->decrement('wallet_balance', $totalDeduction);

            // Check if Maker-Checker workflow applies
            $status = 'pending';
            $isApprovalRequired = \Illuminate\Support\Facades\Auth::guard('team_member')->check() && \Illuminate\Support\Facades\Auth::guard('team_member')->user()->role !== 'admin';
            
            if ($isApprovalRequired) {
                $status = 'pending_approval';
            }

            // Create the primary debit ledger entry
            $transaction = Transaction::create([
                'virtual_account_id' => $account ? $account->id : null,
                'merchant_id' => $merchant->id,
                'session_id' => $txnRef,
                'type' => 'debit',
                'amount' => $withdrawalAmount,
                'fee_charged' => $q4iFee, // Log the N100 fee
                'settled_amount' => $totalDeduction,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'status' => $status, 
                'remarks' => "Payout to {$bank->bank_name} ({$bank->account_number})"
            ]);
            
            // 🟢 LOG Q4I PROFIT TO SYSTEM EARNINGS
            DB::table('system_earnings')->insert([
                'transaction_ref' => $txnRef,
                'merchant_id' => $merchant->id,
                'type' => 'merchant_outflow_profit',
                'amount' => $q4iProfit, // Logs exactly ₦87
                'created_at' => now()
            ]);
            
            DB::commit();
            
            // 🟢 DISPATCH NOTIFICATION
            $merchant->notify(new \App\Notifications\SecurityAlert(
                $isApprovalRequired ? 'Withdrawal Requested' : 'Withdrawal Initiated',
                $isApprovalRequired 
                    ? 'A withdrawal of ₦' . number_format($withdrawalAmount) . ' to ' . $bank->bank_name . ' (' . $bank->account_number . ') has been requested and is awaiting Admin approval.'
                    : 'Your withdrawal of ₦' . number_format($withdrawalAmount) . ' to ' . $bank->bank_name . ' (' . $bank->account_number . ') has been initiated.',
                'outflow'
            ));
            
            // NOTE: Automated instant payouts via 9PSB (Only if NOT pending approval)
            if ($status === 'pending') {
                try {
                    $transferService = new \App\Services\NinePsbTransferService();
                    $transferResponse = $transferService->transferToOtherBank([
                        'bank_code' => $bank->bank_code,
                        'account_number' => $bank->account_number,
                        'account_name' => $bank->account_name,
                        'amount' => $withdrawalAmount,
                        'reference' => $txnRef,
                        'narration' => "Payout to {$bank->bank_name} ({$bank->account_number}) from {$merchant->business_name}"
                    ]);

                    // 9PSB response format check
                    if (isset($transferResponse['code']) && $transferResponse['code'] === '00') {
                        $transaction->update(['status' => 'successful']);
                    } else {
                        Log::warning('9PSB Transfer Pending/Failed: ', ['response' => $transferResponse]);
                    }

                } catch (\Exception $e) {
                    Log::error("9PSB Payout Error: " . $e->getMessage());
                    // We leave the status as pending for admin review
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Web Payout Crash: " . $e->getMessage());
            return redirect()->back()->withErrors(['System Error: ' . $e->getMessage()]);
        }

        $this->logAuditAction('requested_payout', 'settlements', "Requested withdrawal of ₦" . number_format($withdrawalAmount, 2) . " to {$bank->bank_name}");

        if ($status === 'pending_approval') {
            return redirect()->back()->with('success', 'Withdrawal of ₦' . number_format($withdrawalAmount, 2) . ' requested successfully. It is now awaiting Admin approval.');
        }

        return redirect()->back()->with('success', 'Withdrawal of ₦' . number_format($withdrawalAmount, 2) . ' submitted successfully. A fee of ₦100 was applied.');
    }

    // ==========================================
    // 🟢 APPROVE / REJECT PAYOUTS (MAKER-CHECKER)
    // ==========================================
    public function approvePayout(Request $request, $id)
    {
        $merchant = \App\Models\Merchant::current();
        
        $transaction = Transaction::where('id', $id)
            ->where('merchant_id', $merchant->id)
            ->where('status', 'pending_approval')
            ->firstOrFail();
            
        // Transition to pending
        $transaction->status = 'pending';
        $transaction->save();
        
        $this->logAuditAction('approved_payout', 'settlements', "Approved payout {$transaction->session_id} for ₦" . number_format($transaction->amount, 2));

        // Parse bank details from remarks
        preg_match('/Payout to (.+?) \((.+?)\)/', $transaction->remarks, $matches);
        $bankName = $matches[1] ?? 'Unknown Bank';
        $accountNumber = $matches[2] ?? 'Unknown Account';
        
        // Find bank code
        $bank = DB::table('merchant_bank_accounts')
            ->where('merchant_id', $merchant->id)
            ->where('account_number', $accountNumber)
            ->first();
            
        if (!$bank) {
            return redirect()->back()->withErrors(['Could not find associated bank details for this payout.']);
        }
        
        try {
            $transferService = new \App\Services\NinePsbTransferService();
            $transferResponse = $transferService->transferToOtherBank([
                'bank_code' => $bank->bank_code,
                'account_number' => $bank->account_number,
                'account_name' => $bank->account_name,
                'amount' => $transaction->amount,
                'reference' => $transaction->session_id,
                'narration' => "Payout to {$bank->bank_name} ({$bank->account_number}) from {$merchant->business_name}"
            ]);

            if (isset($transferResponse['code']) && $transferResponse['code'] === '00') {
                $transaction->update(['status' => 'successful']);
                return redirect()->back()->with('success', 'Payout approved and processed successfully!');
            } else {
                Log::warning('9PSB Transfer Pending/Failed: ', ['response' => $transferResponse]);
                return redirect()->back()->with('success', 'Payout approved but processing is delayed/pending. Check 9PSB status.');
            }

        } catch (\Exception $e) {
            Log::error("9PSB Payout Error on Approval: " . $e->getMessage());
            return redirect()->back()->with('success', 'Payout approved, but gateway encountered an error. Status is now pending.');
        }
    }

    public function rejectPayout(Request $request, $id)
    {
        $merchant = \App\Models\Merchant::current();
        
        $transaction = Transaction::where('id', $id)
            ->where('merchant_id', $merchant->id)
            ->where('status', 'pending_approval')
            ->firstOrFail();
            
        DB::beginTransaction();
        try {
            $transaction->status = 'failed';
            $transaction->remarks .= ' [REJECTED BY ADMIN]';
            $transaction->save();
            
            // Refund the locked amount (amount + 100 fee)
            $merchant->increment('wallet_balance', $transaction->settled_amount);
            
            // Remove the profit entry from system_earnings
            DB::table('system_earnings')
                ->where('transaction_ref', $transaction->session_id)
                ->where('type', 'merchant_outflow_profit')
                ->delete();
                
            DB::commit();
            
            $this->logAuditAction('rejected_payout', 'settlements', "Rejected payout {$transaction->session_id} for ₦" . number_format($transaction->amount, 2));
            
            return redirect()->back()->with('success', 'Payout rejected. The funds have been refunded to the wallet.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['System Error: ' . $e->getMessage()]);
        }
    }

    public function saveAutoSweep(Request $request)
    {
        $merchant = $request->user();

        $validated = $request->validate([
            'pin' => 'required|digits:4',
            'auto_sweep_enabled' => 'nullable|boolean',
            'auto_sweep_frequency' => 'required_with:auto_sweep_enabled|in:daily,weekly,threshold',
            'auto_sweep_threshold' => 'required_if:auto_sweep_frequency,threshold|numeric|min:1000',
            'auto_sweep_bank_account_id' => 'required_with:auto_sweep_enabled|exists:merchant_bank_accounts,id'
        ]);

        // 1. PIN Shield
        if (!$merchant->transaction_pin) {
            return redirect()->back()->withErrors(['Please set a Transaction PIN in your settings before configuring auto-sweep.']);
        }
        if (!Hash::check($validated['pin'], $merchant->transaction_pin)) {
            return redirect()->back()->withErrors(['Invalid Transaction PIN.']);
        }

        // 2. Save Auto-Sweep Configuration
        $merchant->auto_sweep_enabled = $request->has('auto_sweep_enabled');
        if ($merchant->auto_sweep_enabled) {
            $merchant->auto_sweep_frequency = $validated['auto_sweep_frequency'];
            $merchant->auto_sweep_threshold = $validated['auto_sweep_threshold'] ?? null;
            $merchant->auto_sweep_bank_account_id = $validated['auto_sweep_bank_account_id'];
        } else {
            $merchant->auto_sweep_frequency = 'daily';
            $merchant->auto_sweep_threshold = null;
            $merchant->auto_sweep_bank_account_id = null;
        }

        $merchant->save();

        if ($merchant->auto_sweep_enabled) {
            $merchant->notify(new \App\Notifications\SecurityAlert(
                'Auto-Sweep Configured',
                'You have successfully enabled automated withdrawals for your master wallet.',
                'settings'
            ));
            
            $this->logAuditAction('configured_auto_sweep', 'settlements', 'Enabled Auto-Sweep configuration.');

            return redirect()->back()->with('success', 'Automated sweeps have been successfully configured and activated.');
        } else {
            $this->logAuditAction('disabled_auto_sweep', 'settlements', 'Disabled Auto-Sweep configuration.');
            return redirect()->back()->with('success', 'Automated sweeps have been disabled.');
        }
    }
}