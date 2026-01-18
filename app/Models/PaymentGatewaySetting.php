<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewaySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway',
        'is_enabled',
        'display_name',
        'credentials',
        'sandbox_mode',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'sandbox_mode' => 'boolean',
        'credentials' => 'array',
    ];
}
