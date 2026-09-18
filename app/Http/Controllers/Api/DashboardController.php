<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Get the rich omnichannel dashboard data for Mobile Apps / SPAs
     */
    public function getOverview(Request $request)
    {
        // 1. 🟢 THE SECURITY LOCK (No more IDOR!)
        // This securely extracts the merchant from the passed Sanctum Bearer Token
        $merchant = $request->user(); 

        if (!$merchant) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // 2. 🟢 SYNCHRONIZED METRICS (Matching the Web Dashboard)
        $activeAgentsCount = DB::table('agents')
            ->where('merchant_id', $merchant->id)
            ->count();

        $availableBalance = DB::table('virtual_accounts')
            ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
            ->where('agents.merchant_id', $merchant->id)
            ->where('virtual_accounts.is_active', true)
            ->sum('virtual_accounts.ledger_balance');

        $todayCollections = DB::table('transactions')
            ->join('virtual_accounts', 'transactions.virtual_account_id', '=', 'virtual_accounts.id')
            ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
            ->where('agents.merchant_id', $merchant->id)
            ->where('transactions.type', 'credit')
            ->where('transactions.status', 'successful')
            ->whereDate('transactions.created_at', Carbon::today())
            ->sum('transactions.amount');

        // 3. Fetch Recent Activity with Context
        $recentTransactions = DB::table('transactions')
            ->join('virtual_accounts', 'transactions.virtual_account_id', '=', 'virtual_accounts.id')
            ->join('agents', 'virtual_accounts.agent_id', '=', 'agents.id')
            ->where('agents.merchant_id', $merchant->id)
            ->select(
                'transactions.session_id as reference',
                'transactions.type',
                'transactions.amount',
                'transactions.status',
                'transactions.created_at',
                'virtual_accounts.account_number',
                'agents.first_name',
                'agents.last_name'
            )
            ->orderBy('transactions.created_at', 'desc')
            ->limit(5)
            ->get();

        // 4. Return the Enterprise API Payload
        return response()->json([
            'status' => 'success',
            'data' => [
                'merchant' => [
                    'business_name' => $merchant->business_name,
                    'kyc_status' => $merchant->kyc_status,
                ],
                'metrics' => [
                    'wallet_balance' => round((float) $availableBalance, 2),
                    'today_collections' => round((float) $todayCollections, 2),
                    'active_sub_agents' => $activeAgentsCount,
                    'currency' => 'NGN'
                ],
                'recent_transactions' => $recentTransactions
            ]
        ], 200);
    }
}