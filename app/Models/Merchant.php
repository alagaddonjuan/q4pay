<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Merchant extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable; 

    // ==========================================
    // 1. MASS ASSIGNMENT SECURITY
    // ==========================================
    protected $fillable = [
        'business_name', 
        'email',
        'contact_email', 
        'password',
        'transaction_pin',
        'wallet_balance',
        'q4i_api_key',
        // 'inbound_flat_fee', // REMOVED: Must be set securely by Admin only!
        // 'outbound_flat_fee', // REMOVED: Must be set securely by Admin only!
        'business_type',
        'fee_tier', // standard, pro, enterprise
        'total_processed_volume',
        'kyc_status',
        'bvn',
        'nin',
        'vas_requested',
        'vas_approved',
        'is_active' 
    ];

    // ==========================================
    // 2. DATA PRIVACY (Hidden from API Responses)
    // ==========================================
    protected $hidden = [
        'password',
        'transaction_pin', // 🟢 FIXED: Never leak the PIN to the frontend!
        'remember_token',
    ];

    // ==========================================
    // 3. STRICT TYPE CASTING
    // ==========================================
    protected $casts = [
        'wallet_balance' => 'decimal:2',
        'inbound_flat_fee' => 'decimal:2',
        'outbound_flat_fee' => 'decimal:2',
        'total_processed_volume' => 'decimal:2',
        'vas_requested' => 'boolean',
        'vas_approved' => 'boolean',
        'is_active' => 'boolean',
        'two_factor_enabled' => 'boolean',
    ];

    // ==========================================
    // 4. RELATIONSHIPS (The B2B Ecosystem Anchors)
    // ==========================================

    /**
     * The Merchant's dedicated compliance data.
     */
    public function kyc()
    {
        return $this->hasOne(MerchantKyc::class);
    }

    /**
     * The Merchant's API credentials.
     */
    public function apiKeys()
    {
        return $this->hasOne(ApiKey::class);
    }

    /**
     * The Merchant's notification endpoint.
     */
    public function webhookEndpoint()
    {
        return $this->hasOne(WebhookEndpoint::class);
    }

    /**
     * All Sub-Agents created by this Merchant.
     */
    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    /**
     * 🟢 NEW: A "HasManyThrough" shortcut to get all Virtual Accounts
     * instantly without querying the Agent model first!
     */
    public function virtualAccounts()
    {
        return $this->hasManyThrough(VirtualAccount::class, Agent::class);
    }

    /**
     * The Merchant's unified ledger history.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * The Merchant's linked payout bank accounts.
     */
    public function bankAccounts()
    {
        return $this->hasMany(MerchantBankAccount::class);
    }
    
    // ==========================================
    // 5. QUERY SCOPES & HELPERS
    // ==========================================

    /**
     * Get only active, fully approved merchants.
     * Usage: Merchant::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('kyc_status', 'approved');
    }

    /**
     * Get the current active merchant context (whether logged in as owner or team member)
     */
    public static function current()
    {
        $user = auth()->user(); // checks default guard, or we can check explicitly
        if (!$user) {
            if (auth('merchant')->check()) {
                $user = auth('merchant')->user();
            } elseif (auth('team_member')->check()) {
                $user = auth('team_member')->user();
            }
        }

        if ($user instanceof \App\Models\MerchantTeamMember) {
            return $user->merchant;
        }

        return $user;
    }
}