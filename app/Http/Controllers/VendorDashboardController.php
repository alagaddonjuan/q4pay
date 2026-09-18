<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class VendorDashboardController extends Controller
{
    public function getOverview()
    {
        // Get the currently logged-in vendor's ID
        $vendorId = Auth::id();

        // ==========================================
        // 1. 🟢 FIXED: TRUE AVAILABLE BALANCE
        // ==========================================
        // We must fetch this from the wallets table to account for fees and withdrawals!
        $wallet = DB::table('wallets')->where('user_id', $vendorId)->first();
        $availableBalance = $wallet ? $wallet->balance : 0;

        // 2. Pending Escrow: Sum of amounts locked in active escrow 
        $pendingEscrow = DB::table('escrow_transactions')
            ->where('vendor_id', $vendorId)
            ->whereNotIn('status', ['released', 'awaiting_funds', 'cancelled', 'failed'])
            ->sum('amount');

        // 3. Total Sales Volume: Lifetime successful sales (Gross Volume)
        $totalSales = DB::table('escrow_transactions')
            ->where('vendor_id', $vendorId)
            ->where('status', 'released')
            ->sum('amount');

        // 4. Active Orders Count: Number of ongoing transactions
        $activeOrdersCount = DB::table('escrow_transactions')
            ->where('vendor_id', $vendorId)
            ->whereNotIn('status', ['released', 'awaiting_funds', 'cancelled', 'failed'])
            ->count();

        // 5. Activity Feed: Fetch the 5 most recent transactions
        $recentActivities = DB::table('escrow_transactions')
            ->where('vendor_id', $vendorId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pass the live database data to your dashboard view
        return view('vendor.dashboard', compact(
            'availableBalance', 
            'pendingEscrow', 
            'totalSales', 
            'activeOrdersCount',
            'recentActivities'
        ));
    }
}