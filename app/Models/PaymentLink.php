<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLink extends Model
{
    use HasFactory;

    // ==========================================
    // 1. MASS ASSIGNMENT SECURITY
    // ==========================================
    protected $fillable = [
        'merchant_id',
        'reference',     // The unique slug for the URL (e.g., 'pay-x7b9q')
        'title',         // e.g., 'Summer Sneaker Collection'
        'description',
        'amount',        // If NULL, the customer types in the amount they want to pay
        'currency',      // Default to 'NGN'
        'collect_phone_number',     // Toggle to force phone number entry
        'collect_delivery_address', // Toggle to force address entry (great for physical goods)
        'redirect_url',  // Where to send the buyer after a successful payment
        'is_active',
    ];

    // ==========================================
    // 2. STRICT TYPE CASTING
    // ==========================================
    protected $casts = [
        'amount' => 'decimal:2',
        'collect_phone_number' => 'boolean',
        'collect_delivery_address' => 'boolean',
        'is_active' => 'boolean',
    ];

    // ==========================================
    // 3. RELATIONSHIPS
    // ==========================================

    /**
     * The Corporate Merchant who created and owns this link.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * All successful and failed payments that originated from this specific link.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // ==========================================
    // 4. HELPERS & ACCESSORS
    // ==========================================

    /**
     * Automatically generates the fully qualified, clickable URL for the frontend.
     * Usage: $paymentLink->live_url
     */
    public function getLiveUrlAttribute()
    {
        // Adjust the base URL structure to match your actual frontend domain routing
        return url('/pay/' . $this->reference);
    }

    // ==========================================
    // 5. QUERY SCOPES
    // ==========================================

    /**
     * Quickly filter for links that are currently turned on.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}