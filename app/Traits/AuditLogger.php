<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

trait AuditLogger
{
    /**
     * Log an action to the audit logs.
     *
     * @param string $action
     * @param string $module
     * @param string $description
     * @param array|null $oldValues
     * @param array|null $newValues
     * @return void
     */
    public function logAuditAction($action, $module, $description = null, $oldValues = null, $newValues = null)
    {
        // 1. Check Merchant Guard
        if (auth('merchant')->check()) {
            $user = \App\Models\Merchant::current();
            $userType = 'merchant';
        } 
        // 2. Check Team Member Guard
        elseif (auth('team_member')->check()) {
            $user = auth('team_member')->user();
            $userType = 'team_member';
        } 
        // 3. Fallback to default auth guard
        elseif (auth()->check()) {
            $user = auth()->user();
            $userType = get_class($user) === 'App\Models\Admin' ? 'admin' : 'user';
        } 
        else {
            return; // No authenticated user to log
        }

        AuditLog::create([
            'user_type' => $userType,
            'user_id' => $user->id,
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ]);
    }
}
