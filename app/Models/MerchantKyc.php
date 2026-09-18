<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MerchantKyc extends Model
{
    use HasFactory;

    protected $table = 'merchant_kycs';

    // ==========================================
    // 1. MASS ASSIGNMENT SECURITY
    // ==========================================
    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'registration_number',
        'tax_id',
        'industrial_sector',
        'business_address',
        
        'rep_first_name',
        'rep_last_name',
        'rep_bvn',
        'rep_nin',
        'rep_dob',
        
        'cac_certificate_path',
        'utility_bill_path',
        'rep_id_card_path',
        
        'status', 
        'rejection_reason', // 🟢 FIXED: Match the database column name!
    ];

    // ==========================================
    // 2. APPENDS FOR API RESPONSES
    // ==========================================
    protected $appends = [
        'cac_document_url', 
        'utility_bill_url', 
        'masked_bvn', 
        'masked_nin'
    ];

    // ==========================================
    // 2. STRICT TYPE CASTING
    // ==========================================
    protected $casts = [
        'rep_dob' => 'date', // Prevents Carbon parsing crashes
    ];

    // ==========================================
    // 3. RELATIONSHIPS
    // ==========================================
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'user_id');
    }

    // ==========================================
    // 4. SECURITY HELPERS (PII Masking)
    // ==========================================
    
    /**
     * Get a securely masked BVN for API responses (e.g., ******6789)
     */
    public function getMaskedBvnAttribute()
    {
        if (!$this->rep_bvn) return null;
        return str_pad(substr($this->rep_bvn, -4), strlen($this->rep_bvn), '*', STR_PAD_LEFT);
    }

    /**
     * Get a securely masked NIN for API responses (e.g., *******4567)
     */
    public function getMaskedNinAttribute()
    {
        if (!$this->rep_nin) return null;
        return str_pad(substr($this->rep_nin, -4), strlen($this->rep_nin), '*', STR_PAD_LEFT);
    }

    // ==========================================
    // 5. UX HELPERS (Auto-Generating URLs)
    // ==========================================
    // These allow your frontend to simply call $kyc->cac_document_url

    public function getCacDocumentUrlAttribute()
    {
        return $this->cac_certificate_path ? Storage::disk('local')->url($this->cac_certificate_path) : null;
    }

    public function getUtilityBillUrlAttribute()
    {
        return $this->utility_bill_path ? Storage::disk('local')->url($this->utility_bill_path) : null;
    }

    // ==========================================
    // 6. QUERY SCOPES
    // ==========================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}