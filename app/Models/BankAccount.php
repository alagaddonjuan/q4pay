<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'account_name',
        'is_active',
    ];

    // ==========================================
    // 1. STRICT TYPE CASTING
    // ==========================================
    // Ensures frontend frameworks don't crash on 0/1 integer comparisons
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ==========================================
    // 2. RELATIONSHIPS
    // ==========================================
    
    // Tells Laravel this bank account belongs to a Social Commerce Vendor
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // (Optional but Recommended) If you have a Vendor Payouts table later:
    // public function payouts()
    // {
    //     return $this->hasMany(VendorPayout::class);
    // }

    // ==========================================
    // 3. SECURITY HELPERS (PII Protection)
    // ==========================================
    
    /**
     * Get a securely masked version of the account number for API responses.
     * Example output: ******5678
     */
    public function getMaskedAccountNumberAttribute()
    {
        if (!$this->account_number) return null;
        
        // Grab the last 4 digits and pad the rest with asterisks
        return str_pad(substr($this->account_number, -4), strlen($this->account_number), '*', STR_PAD_LEFT);
    }

    // ==========================================
    // 4. QUERY SCOPES
    // ==========================================
    
    /**
     * Allows you to simply write: BankAccount::active()->get();
     * instead of BankAccount::where('is_active', true)->get();
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}