<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    // ==========================================
    // 1. MASS ASSIGNMENT SECURITY
    // ==========================================
    protected $fillable = [
        'user_id',
        'balance',          // The total actual money in the wallet
        'locked_balance',   // Money frozen due to active escrows or disputes
        'currency',         // e.g., 'NGN', 'USD' (Prepares you for scaling!)
        'is_active',
    ];

    // ==========================================
    // 2. STRICT TYPE CASTING (Fintech Standard)
    // ==========================================
    protected $casts = [
        'balance'        => 'decimal:2',
        'locked_balance' => 'decimal:2',
        'is_active'      => 'boolean',
    ];

    // ==========================================
    // 3. RELATIONSHIPS
    // ==========================================

    /**
     * This links the wallet back to the user (Vendor/Buyer) who owns it.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ==========================================
    // 4. UX HELPERS & ACCESSORS
    // ==========================================

    /**
     * Calculates the actual spendable/withdrawable cash by subtracting locked funds.
     * Usage in controllers: $wallet->available_balance
     */
    public function getAvailableBalanceAttribute()
    {
        return max(0, $this->balance - $this->locked_balance);
    }

    // ==========================================
    // 5. QUERY SCOPES
    // ==========================================

    /**
     * Quickly fetch active wallets.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}