<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    use HasFactory;

    // ==========================================
    // 1. MASS ASSIGNMENT SECURITY
    // ==========================================
    // Explicitly whitelist only the columns that are safe to write to.
    protected $fillable = [
        'escrow_transaction_id',
        'vendor_id',
        'reason',
        'status',          // e.g., 'open', 'resolved', 'refunded', 'rejected'
        'admin_notes',     // The private notes left by the Q4I Admin
        'resolved_by',     // The ID of the Admin who handled it
        'resolved_at',     // Timestamp of resolution
    ];

    // ==========================================
    // 2. STRICT TYPE CASTING
    // ==========================================
    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    // ==========================================
    // 3. RELATIONSHIPS
    // ==========================================

    /**
     * A dispute strictly belongs to a single Escrow Transaction.
     */
    public function escrowTransaction()
    {
        return $this->belongsTo(EscrowTransaction::class);
    }

    /**
     * A dispute is raised against a specific Social Commerce Vendor.
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * (Optional) The Q4I Admin who resolved this dispute.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    // ==========================================
    // 4. QUERY SCOPES (For cleaner controllers)
    // ==========================================

    /**
     * Quickly grab all disputes that need Admin attention.
     * Usage: Dispute::requiresAction()->get();
     */
    public function scopeRequiresAction($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Quickly grab all historical/resolved disputes.
     * Usage: Dispute::resolved()->get();
     */
    public function scopeResolved($query)
    {
        return $query->whereIn('status', ['resolved', 'refunded', 'rejected']);
    }
}