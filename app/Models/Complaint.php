<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'transaction_reference',
        'category',
        'message',
        'status',
    ];

    /**
     * Get the merchant that owns the complaint.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
