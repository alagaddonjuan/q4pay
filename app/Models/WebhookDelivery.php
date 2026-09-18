<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'event',
        'webhook_url',
        'payload',
        'response_headers',
        'response_body',
        'response_status',
        'is_successful',
        'processing_time_ms',
    ];

    protected $casts = [
        'payload' => 'array',
        'response_headers' => 'array',
        'is_successful' => 'boolean',
    ];
}
