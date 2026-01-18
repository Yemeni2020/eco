<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class CustomerOtp extends Model
{
    protected $table = 'customer_otps';

    protected $fillable = [
        'phone',
        'phone_normalized',
        'code_hash',
        'expires_at',
        'used_at',
        'attempts',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function matches(string $code): bool
    {
        return Hash::check($code, $this->code_hash);
    }

    public function markUsed(): self
    {
        $this->used_at = Carbon::now();
        $this->save();

        return $this;
    }

    public function incrementAttempts(): self
    {
        $this->increment('attempts');
        return $this;
    }
}
