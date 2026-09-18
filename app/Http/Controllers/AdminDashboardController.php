<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\User; // Added for Vendors
use App\Models\Agent;
use App\Models\VirtualAccount;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    // A strict security check to ensure ONLY Q4I admins can access this
    private function authenticateMasterAdmin(Request $request)
    {
        $masterKey = $request->header('X-Q4I-Master-Key');
        $validKey = env('Q4I_MASTER_KEY', ''); 
        
        return $masterKey === $validKey;
    }

    // ========================================================================
    // 1. Get Q4I System Overview (Revenue, Liabilities, & Escrow)
    // ========================================================================
    public function getSystemOverview(Request $request)
    {
        if (!$this->authenticateMasterAdmin($request)) {
            return response()->json(['error' => 'Unauthorized. Master Key Required.'], 401);
        }

        // 1. Total User Base Across Omnichannel
        $totalCorporateMerchants = Merchant::count();
        $totalSocialVendors = User::count();
        $totalProvisionedAccounts = VirtualAccount::count();

        // 2. 🟢 FIXED: Total System Liabilities (Every penny Q4I owes to users)
        $merchantWalletLiabilities = Merchant::sum('wallet_balance');
        $vendorWalletLiabilities = User::sum('wallet_balance');
        
        // Funds currently locked in escrow that belong to vendors (pending release)
        $lockedEscrowLiabilities = DB::table('escrow_transactions')
            ->whereIn('status', ['awaiting_funds', 'locked', 'disputed'])
            ->sum('amount');
            
        $totalSystemLiabilities = $merchantWalletLiabilities + $vendorWalletLiabilities + $lockedEscrowLiabilities;

        // 3. 🟢 FIXED: Q4I's Pure Net Profit! (Querying the dedicated earnings ledger)
        $totalQ4IRevenue = DB::table('system_earnings')->sum('amount');
        
        // Let's break down the revenue so you know what products are performing best
        $revenueBreakdown = DB::table('system_earnings')
            ->select('type', DB::raw('SUM(amount) as total'))
            ->groupBy('type')
            ->pluck('total', 'type');

        // 4. Total Volume Processed (Inbound vs Outbound)
        $totalInboundVolume = Transaction::where('type', 'credit')->where('status', 'successful')->sum('amount');
        $totalOutboundVolume = Transaction::where('type', 'debit')->where('status', 'successful')->sum('amount');

        return response()->json([
            'status' => 'success',
            'data' => [
                'company' => 'Q4I LIMITED',
                'users' => [
                    'corporate_merchants' => $totalCorporateMerchants,
                    'social_vendors' => $totalSocialVendors,
                    'total_virtual_accounts_provisioned' => $totalProvisionedAccounts,
                ],
                'financials' => [
                    'q4i_pure_net_revenue' => $totalQ4IRevenue,
                    'revenue_breakdown' => $revenueBreakdown,
                    'liabilities' => [
                        'merchant_wallets' => $merchantWalletLiabilities,
                        'vendor_wallets' => $vendorWalletLiabilities,
                        'locked_in_escrow' => $lockedEscrowLiabilities,
                        'total_exposure' => $totalSystemLiabilities
                    ]
                ],
                'volume' => [
                    'total_inbound_processed' => $totalInboundVolume,
                    'total_outbound_processed' => $totalOutboundVolume,
                ]
            ]
        ], 200);
    }

    // ========================================================================
    // 2. Get All Merchants and their Balances
    // ========================================================================
    public function getMerchantsList(Request $request)
    {
        if (!$this->authenticateMasterAdmin($request)) {
            return response()->json(['error' => 'Unauthorized. Master Key Required.'], 401);
        }

        // 🟢 FIXED: Fetch all merchants WITH their KYC data, ordered by who has the highest balance
        $merchants = Merchant::with('kyc')->orderBy('wallet_balance', 'desc')->paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => $merchants
        ], 200);
    }
    
    // ========================================================================
    // 3. 🟢 NEW: Get All Vendors and their Balances
    // ========================================================================
    public function getVendorsList(Request $request)
    {
        if (!$this->authenticateMasterAdmin($request)) {
            return response()->json(['error' => 'Unauthorized. Master Key Required.'], 401);
        }

        $vendors = User::orderBy('wallet_balance', 'desc')->paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => $vendors
        ], 200);
    }
}
