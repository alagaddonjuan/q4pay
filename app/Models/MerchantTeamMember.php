<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MerchantTeamMember extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'merchant_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'transaction_pin',
        'role',
        'status',
        'invite_token',
        'two_factor_secret',
        'two_factor_enabled',
        'notification_preferences',
        'profile_picture'
    ];

    protected $hidden = [
        'password',
        'transaction_pin',
        'remember_token',
        'invite_token'
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
