<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // 🟢 ADDED: Required for Mobile App/API authentication

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    // ==========================================
    // 1. MASS ASSIGNMENT SECURITY
    // ==========================================
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'store_name',
        'wallet_balance',  // 🟢 ADDED: So escrow payouts don't fail!
        'transaction_pin', // 🟢 ADDED: For secure withdrawals
        'is_active',       // To easily suspend bad actors
    ];

    // ==========================================
    // 2. DATA PRIVACY
    // ==========================================
    protected $hidden = [
        'password',
        'remember_token',
        'transaction_pin', // 🟢 FIXED: Never leak the withdrawal PIN!
    ];

    // ==========================================
    // 3. STRICT TYPE CASTING
    // ==========================================
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'wallet_balance' => 'decimal:2', // 🟢 ADDED: Strict fintech decimal casting
            'is_active' => 'boolean',
            'two_factor_enabled' => 'boolean',
        ];
    }

    // ==========================================
    // 4. FILAMENT DASHBOARD ACCESS
    // ==========================================
    public function canAccessPanel(Panel $panel): bool
    {
        // If Filament is strictly your VENDOR dashboard, this is correct.
        // It allows active vendors to manage their store.
        return $this->is_active ?? true; 
    }

    // ==========================================
    // 5. RELATIONSHIPS (The Social Commerce Anchors)
    // ==========================================

    /**
     * The vendor's catalog of products.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    /**
     * Every escrow transaction where this user is the Vendor.
     */
    public function escrowTransactions()
    {
        return $this->hasMany(EscrowTransaction::class, 'vendor_id');
    }

    /**
     * The vendor's linked bank accounts for withdrawing their wallet balance.
     */
    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class, 'user_id');
    }

    /**
     * Any disputes raised by buyers against this vendor.
     */
    public function disputes()
    {
        return $this->hasMany(Dispute::class, 'vendor_id');
    }
}