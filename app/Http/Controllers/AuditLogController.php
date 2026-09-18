<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        // Include both merchant and team members' logs 
        // We need to fetch logs for this merchant id or their team members
        // For simplicity right now, if a team member acts, we should log merchant_id in audit_log or link team members to merchant
        
        // For now, let's fetch logs where user_type is merchant and user_id is merchant->id
        // Or if we need team members, we can get their IDs
        $teamMemberIds = \App\Models\MerchantTeamMember::where('merchant_id', $merchant->id)->pluck('id')->toArray();

        $logs = AuditLog::where(function($query) use ($merchant, $teamMemberIds) {
            $query->where('user_type', 'merchant')->where('user_id', $merchant->id);
            if (!empty($teamMemberIds)) {
                $query->orWhere(function($q) use ($teamMemberIds) {
                    $q->where('user_type', 'team_member')->whereIn('user_id', $teamMemberIds);
                });
            }
        })
        ->orderByDesc('created_at')
        ->paginate(20);

        return view('merchant.settings.audit-logs', compact('merchant', 'logs'));
    }
}
