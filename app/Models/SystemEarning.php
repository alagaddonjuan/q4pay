<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemEarning extends Model
{
    protected $fillable = [
        'transaction_ref',
        'merchant_id',
        'type',
        'amount',
    ];
}
