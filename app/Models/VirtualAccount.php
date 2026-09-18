<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualAccount extends Model
{
    use HasFactory;

    // ==========================================
    // 1. MASS ASSIGNMENT SECURITY
    // ==========================================
    protected $fillable = [
        'user_id',
        'agent_id',
        'account_name',   // 🟢 FIXED: Required for NIBSS/9PSB payment invoices!
        'account_number',
        'bank_name',
        'customer_id',
        'order_ref',
        'ledger_balance',
        'is_active',
    ];

    // ==========================================
    // 2. STRICT TYPE CASTING
    // ==========================================
    protected $casts = [
        'ledger_balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // ==========================================
    // 3. RELATIONSHIPS
    // ==========================================

    /**
     * Get the sub-agent that owns this virtual account.
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * 🟢 NEW: Get every transaction that has ever passed through this specific account.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * 🟢 NEW: A "HasOneThrough" shortcut to instantly get the Master Merchant
     * who ultimately controls this virtual account.
     */
    public function merchant()
    {
        return $this->hasOneThrough(
            Merchant::class, 
            Agent::class, 
            'id',          // Foreign key on the agents table
            'id',          // Foreign key on the merchants table
            'agent_id',    // Local key on the virtual_accounts table
            'merchant_id'  // Local key on the agents table
        );
    }

    // ==========================================
    // 4. QUERY SCOPES
    // ==========================================

    /**
     * Scope to quickly fetch only active accounts ready to receive funds.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}