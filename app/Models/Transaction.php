<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // ==========================================
    // 1. MASS ASSIGNMENT SECURITY
    // ==========================================
    protected $fillable = [
        'virtual_account_id',
        'merchant_id',
        'payment_link_id', // 🟢 NEW: Connects directly to the PaymentLink model
        'session_id',
        'type',            // 'credit' or 'debit'
        'amount',
        'balance_before',
        'balance_after',
        'status',          // 'successful', 'pending', 'failed'
        'remarks',
        'fee_charged',
        'settled_amount',
        'is_swept',
    ];

    // ==========================================
    // 2. STRICT TYPE CASTING (Fintech Standard)
    // ==========================================
    // This ensures your frontend always receives strict, predictable 2-decimal floats
    protected $casts = [
        'amount'         => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after'  => 'decimal:2',
        'fee_charged'    => 'decimal:2',
        'settled_amount' => 'decimal:2',
        'is_swept'       => 'boolean',
    ];

    // ==========================================
    // 3. RELATIONSHIPS
    // ==========================================

    /**
     * The Virtual Account (9PSB/Wema) that processed this transaction.
     */
    public function virtualAccount()
    {
        return $this->belongsTo(VirtualAccount::class);
    }

    /**
     * The Corporate Merchant who owns the funds.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * 🟢 NEW: The specific Payment Link that generated this payment (if applicable).
     */
    public function paymentLink()
    {
        return $this->belongsTo(PaymentLink::class);
    }

    // ==========================================
    // 4. QUERY SCOPES (For cleaner controllers)
    // ==========================================

    /**
     * Scope to quickly grab only successful transactions.
     * Usage: Transaction::successful()->get();
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'successful');
    }

    /**
     * Scope to quickly calculate inbound volume.
     * Usage: Transaction::credit()->successful()->sum('amount');
     */
    public function scopeCredit($query)
    {
        return $query->where('type', 'credit');
    }

    /**
     * Scope to quickly calculate outbound volume.
     */
    public function scopeDebit($query)
    {
        return $query->where('type', 'debit');
    }
}