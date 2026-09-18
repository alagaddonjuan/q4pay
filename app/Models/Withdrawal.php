<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    // ==========================================
    // 1. MASS ASSIGNMENT SECURITY
    // ==========================================
    protected $fillable = [
        'reference',       // 🟢 FIXED: The unique ID sent to Fincra/Flutterwave
        'user_id', 
        'amount',          // The actual amount hitting the vendor's bank
        'fee',             // The NIBSS/Gateway transfer fee deducted
        'bank_name', 
        'account_number', 
        'account_name', 
        'status',          // 'pending', 'processing', 'successful', 'failed', 'reversed'
        'admin_notes',     // E.g., "Failed at gateway: invalid account number"
        'processed_at'     // Timestamp for when the webhook confirmed success
    ];

    // ==========================================
    // 2. STRICT TYPE CASTING (Fintech Standard)
    // ==========================================
    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    // ==========================================
    // 3. RELATIONSHIPS
    // ==========================================
    
    /**
     * This links the withdrawal request back to the Social Commerce Vendor.
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ==========================================
    // 4. QUERY SCOPES
    // ==========================================

    /**
     * Scope to quickly fetch withdrawals waiting to be dispatched.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to quickly fetch failed withdrawals that require refunds to the wallet.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}