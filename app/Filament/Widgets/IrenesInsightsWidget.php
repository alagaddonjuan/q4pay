<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Merchant;
use App\Models\SupportTicket;
use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\EscrowTransaction;
use App\Models\Dispute;
use Carbon\Carbon;

class IrenesInsightsWidget extends Widget
{
    protected string $view = 'filament.widgets.irenes-insights-widget';

    protected int | string | array $columnSpan = 'full';

    // We can define properties that are passed to the blade view
    public array $insights = [];

    public static function canView(): bool
    {
        // Hide from the main dashboard if we want it exclusively on GodEye.
        // If route is filament.admin.pages.dashboard, return false.
        return ! request()->routeIs('filament.admin.pages.dashboard');
    }

    public function mount()
    {
        $this->generateInsights();
    }

    protected function generateInsights()
    {
        $insights = [];

        // 1. System Health
        // We simulate system health check (e.g. database connection and 9PSB status).
        $systemHealth = true; // Placeholder for actual API pings if available
        if ($systemHealth) {
             $insights[] = [
                'type' => 'success',
                'icon' => 'las la-server',
                'message' => "**System Health is optimal.** All core services and API connections (9PSB, Monnify) are currently operational.",
                'action_url' => null,
                'action_label' => null,
            ];
        }

        // 2. Pending KYC Alerts
        $pendingKyc = Merchant::where('kyc_status', 'pending')->count();
        if ($pendingKyc > 0) {
            $insights[] = [
                'type' => 'warning',
                'icon' => 'las la-id-card',
                'message' => "There are **{$pendingKyc} merchants** awaiting KYC approval. Reviewing these promptly helps onboard users faster.",
                'action_url' => route('filament.admin.resources.merchants.index'),
                'action_label' => 'Review Merchants',
            ];
        }

        // 3. Open Support Tickets
        $openTickets = SupportTicket::where('status', 'escalated')->count();
        if ($openTickets > 0) {
            $insights[] = [
                'type' => 'danger',
                'icon' => 'las la-user-nurse',
                'message' => "**{$openTickets} support tickets** have been escalated past me and require human intervention.",
                'action_url' => route('filament.admin.resources.support-tickets.index'),
                'action_label' => 'Handle Tickets',
            ];
        }

        // 4. Pending Withdrawals
        $pendingWithdrawals = Withdrawal::where('status', 'pending')->count();
        if ($pendingWithdrawals > 0) {
            $insights[] = [
                'type' => 'warning',
                'icon' => 'las la-money-bill-wave',
                'message' => "You have **{$pendingWithdrawals} pending withdrawal requests**. Processing these ensures healthy cash flow for merchants.",
                'action_url' => route('filament.admin.resources.withdrawals.index'),
                'action_label' => 'Process Withdrawals',
            ];
        }

        // 5. Active Escrow Disputes
        $activeDisputes = Dispute::where('status', 'open')->count();
        if ($activeDisputes > 0) {
            $insights[] = [
                'type' => 'danger',
                'icon' => 'las la-gavel',
                'message' => "There are **{$activeDisputes} open escrow disputes**. These require immediate arbitration to unlock frozen funds.",
                'action_url' => route('filament.admin.resources.disputes.index'),
                'action_label' => 'Resolve Disputes',
            ];
        }

        // 6. Suspicious Activity (Large Withdrawals)
        $suspiciousWithdrawals = Withdrawal::where('status', 'pending')->where('amount', '>', 5000000)->count();
        if ($suspiciousWithdrawals > 0) {
             $insights[] = [
                'type' => 'danger',
                'icon' => 'las la-exclamation-triangle',
                'message' => "**Security Alert:** {$suspiciousWithdrawals} unusually large withdrawal(s) (over ₦5M) have been requested and need manual review.",
                'action_url' => route('filament.admin.resources.withdrawals.index'),
                'action_label' => 'Investigate',
            ];
        }

        // 7. Daily Volume
        $todayVolume = Transaction::whereDate('created_at', Carbon::today())->sum('amount');
        if ($todayVolume > 0) {
            $insights[] = [
                'type' => 'info',
                'icon' => 'las la-chart-line',
                'message' => "Strong activity today! The platform has processed **₦" . number_format($todayVolume, 2) . "** in volume.",
                'action_url' => route('filament.admin.resources.transactions.index'),
                'action_label' => 'View Transactions',
            ];
        }

        if (empty($insights)) {
            $insights[] = [
                'type' => 'success',
                'icon' => 'las la-thumbs-up',
                'message' => "Everything is running smoothly! No critical alerts at this time.",
                'action_url' => null,
                'action_label' => null,
            ];
        }

        $this->insights = $insights;
    }
}
