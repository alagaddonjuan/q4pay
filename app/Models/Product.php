<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // ==========================================
    // 1. MASS ASSIGNMENT SECURITY
    // ==========================================
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'price',
        'stock',
        'total_sold', // 🟢 FIXED: Synchronized with our Checkout & Escrow Controllers!
        'image',
        'description',
        'is_active',
    ];

    // ==========================================
    // 2. STRICT TYPE CASTING
    // ==========================================
    protected $casts = [
        'image' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2', // Always return price as a strict 2-decimal float
        'stock' => 'integer',
        'total_sold' => 'integer',
    ];

    // ==========================================
    // 3. RELATIONSHIPS
    // ==========================================
    
    /**
     * This links the product back to the Social Commerce Vendor who owns it.
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ==========================================
    // 4. UX HELPERS & ACCESSORS
    // ==========================================

    /**
     * Automatically safely extracts the FIRST image from the array and generates 
     * a fully qualified public URL for Meta/WhatsApp to render.
     * Usage in controllers: $product->primary_image_url
     */
    public function getPrimaryImageUrlAttribute()
    {
        if (empty($this->image)) {
            return 'https://via.placeholder.com/600x600.png?text=No+Image'; // Safe fallback
        }

        // If for some reason it's a string, handle it gracefully
        $images = is_string($this->image) ? json_decode($this->image, true) : $this->image;

        $primary = (is_array($images) && count($images) > 0) ? $images[0] : $this->image;

        // Return the full URL for Meta's API
        return asset('storage/' . $primary);
    }

    // ==========================================
    // 5. QUERY SCOPES
    // ==========================================

    /**
     * Quickly fetch only products that are turned on and visible.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Quickly fetch only products that actually have inventory.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}