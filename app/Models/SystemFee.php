<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type',
        'fee_tier',
        'provider_cost',
        'provider_cost_type',
        'merchant_charge',
        'merchant_charge_type',
        'cap_amount',
    ];

    protected $casts = [
        'provider_cost' => 'decimal:4',
        'merchant_charge' => 'decimal:4',
        'cap_amount' => 'decimal:2',
    ];
}
