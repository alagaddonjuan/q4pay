<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscrowTransaction extends Model
{
    use HasFactory;

    // ==========================================
    // 1. MASS ASSIGNMENT SECURITY (The Whitelist)
    // ==========================================
    protected $fillable = [
        'reference',
        'vendor_id',
        'buyer_phone',
        'platform',
        'platform_sender_id',
        'amount',
        'shipping_fee',
        'item_description',
        'cart_items',
        'virtual_account_number',
        'virtual_account_bank',
        'status', 
        'delivery_address',
        'is_pickup',
        'delivery_pin',
        'tracking_code',
        'tracking_number',
        'tracking_link',
        'logistics_provider',
        'courier_name',
        'shipping_status',
        'delivered_at',
        'auto_release_at',
        'rating',
        'review',
    ];

    // ==========================================
    // 2. STRICT TYPE CASTING (The Magic Fix)
    // ==========================================
    protected $casts = [
        'amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        
        // 🟢 MAGIC: Laravel will now automatically convert arrays to JSON when saving, 
        // and convert JSON back to arrays when reading! No more json_decode() needed.
        'cart_items' => 'array', 
        
        // 🟢 MAGIC: These are now Carbon instances, preventing your Cron Jobs from crashing!
        'delivered_at' => 'datetime',
        'auto_release_at' => 'datetime',
        
        'rating' => 'integer',
    ];

    // ==========================================
    // 3. RELATIONSHIPS
    // ==========================================

    /**
     * This links the escrow transaction back to your Social Commerce Vendor
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * This links the transaction to a potential Dispute.
     * (One escrow transaction usually has one active dispute)
     */
    public function dispute()
    {
        return $this->hasOne(Dispute::class);
    }

    // ==========================================
    // 4. QUERY SCOPES
    // ==========================================

    /**
     * Scope to quickly find funds safely locked in the vault.
     */
    public function scopeLocked($query)
    {
        return $query->whereIn('status', ['funded_locked', 'in_transit']);
    }

    /**
     * Scope to find escrows waiting for buyer confirmation.
     */
    public function scopeAwaitingConfirmation($query)
    {
        return $query->where('shipping_status', 'delivered')
                     ->where('status', 'in_transit'); 
    }
}