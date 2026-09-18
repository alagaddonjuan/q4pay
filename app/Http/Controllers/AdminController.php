<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Merchant;
use App\Models\VirtualAccount;
use App\Models\MerchantKyc; // Added to handle actual KYC data
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // A strict security check to ensure ONLY Q4I admins can access this
    private function authenticateMasterAdmin(Request $request)
    {
        $masterKey = $request->header('X-Q4I-Master-Key');
        $validKey = env('Q4I_MASTER_KEY', 'q4i_super_admin_secret_999'); 
        
        return $masterKey === $validKey;
    }

    public function getPlatformOverview(Request $request)
    {
        if (!$this->authenticateMasterAdmin($request)) {
            return response()->json(['error' => 'Unauthorized. Master Key Required.'], 401);
        }
        
        // 1. 🟢 FIXED: Calculate TRUE Net Revenue from the System Ledger we built!
        $totalPlatformRevenue = DB::table('system_earnings')->sum('amount');

        // 2. Calculate Total Volume Processed
        $totalVolumeProcessed = Transaction::where('status', 'successful')->sum('amount');

        // 3. Count Total Active Merchants
        $totalMerchants = Merchant::count();

        // 4. Count Total Virtual Accounts
        $totalVirtualAccounts = VirtualAccount::count();

        // 5. Get recent global transactions
        $recentTransactions = Transaction::with(['merchant:id,business_name', 'virtualAccount:id,account_number'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($txn) {
                return [
                    'reference' => $txn->session_id,
                    'merchant' => $txn->merchant->business_name ?? 'Unknown',
                    'account' => $txn->virtualAccount->account_number ?? 'N/A',
                    'type' => $txn->type,
                    'amount' => $txn->amount,
                    'status' => $txn->status,
                    'date' => $txn->created_at->format('Y-m-d H:i:s')
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'metrics' => [
                    'total_net_profit_ngn' => $totalPlatformRevenue,
                    'total_volume_ngn' => $totalVolumeProcessed,
                    'active_merchants' => $totalMerchants,
                    'total_virtual_accounts' => $totalVirtualAccounts,
                ],
                'recent_global_transactions' => $recentTransactions
            ]
        ], 200);
    }

    /**
     * View all merchants waiting for KYC approval
     */
    public function getPendingMerchants(Request $request)
    {
        if (!$this->authenticateMasterAdmin($request)) {
            return response()->json(['error' => 'Unauthorized. Master Key Required.'], 401);
        }

        // 🟢 FIXED: Query the exact KYC table where the documents actually live
        $pendingKycRecords = MerchantKyc::with('merchant:id,email,business_name')
            ->where('status', 'pending')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $pendingKycRecords
        ], 200);
    }

    /**
     * Approve or Reject a Merchant's KYC and VAS
     */
    public function approveMerchantKyc(Request $request)
    {
        if (!$this->authenticateMasterAdmin($request)) {
            return response()->json(['error' => 'Unauthorized. Master Key Required.'], 401);
        }

        $validated = $request->validate([
            'merchant_id' => 'required|exists:merchants,id',
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'nullable|string|max:500', // Highly requested feature!
            'approve_vas' => 'nullable|boolean' 
        ]);

        $merchant = Merchant::findOrFail($validated['merchant_id']);
        
        // 🟢 FIXED: Find the actual KYC submission file
        $kycRecord = MerchantKyc::where('user_id', $merchant->id)->first();

        if (!$kycRecord) {
            return response()->json(['error' => 'No KYC document record found for this merchant.'], 404);
        }

        DB::beginTransaction();
        try {
            // 1. Update the KYC Submission Record so the Merchant Dashboard updates
            $kycRecord->update([
                'status' => $validated['status'],
                'rejection_reason' => $validated['rejection_reason'] ?? null
            ]);

            // 2. Handle the Master Account Approval Logic
            if ($validated['status'] === 'approved') {
                $merchant->is_active = true; 
                $merchant->kyc_status = 'approved'; // 🟢 FIXED: Ensure the main merchant table gets the approved status!
                
                // If you checked the box to approve VAS
                if ($request->boolean('approve_vas')) {
                    $merchant->vas_approved = true;
                }
            } else {
                // If rejected, ensure the API is locked
                $merchant->is_active = false;
                $merchant->vas_approved = false;
                $merchant->kyc_status = 'rejected';
            }

            $merchant->save();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Database error during approval: ' . $e->getMessage()], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Merchant {$merchant->business_name} has been {$validated['status']}.",
            'data' => [
                'merchant_id' => $merchant->id,
                'business_name' => $merchant->business_name,
                'kyc_status' => $kycRecord->status,
                'is_active' => $merchant->is_active,
                'vas_approved' => $merchant->vas_approved,
                'notes' => $kycRecord->rejection_reason
            ]
        ], 200);
    }
}