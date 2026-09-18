<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    // The security whitelist (now including KYC and AI fields)
    protected $fillable = [
        'merchant_id',
        'merchant_reference',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'bvn',
        'kyc_tier',          
        'id_document_url',   
        'liveness_score',    
        'date_of_birth',
        'gender',
        'address',
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    // RELATIONSHIP 1: An Agent has one Virtual Account
    public function virtualAccount()
    {
        return $this->hasOne(VirtualAccount::class);
    }

    // RELATIONSHIP 2: An Agent belongs to a Merchant
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // 🟢 NEW RELATIONSHIP 3: An Agent has many Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // ==========================================
    // HELPER METHODS (Make your controllers cleaner!)
    // ==========================================

    /**
     * Get the Agent's full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Quickly grab the total volume this agent has collected
     */
    public function totalCollectedVolume()
    {
        return $this->transactions()
            ->where('type', 'credit')
            ->where('status', 'successful')
            ->sum('amount');
    }
}