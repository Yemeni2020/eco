<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

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

    public const SECRET_PLACEHOLDER = '••••••••';

    public function setCredential(string $key, ?string $value): self
    {
        $credentials = $this->credentials ?? [];

        if ($value === null || $value === '') {
            unset($credentials[$key]);
        } else {
            $credentials[$key] = Crypt::encryptString($value);
        }

        $this->credentials = $credentials;

        return $this;
    }

    public function getCredential(string $key): ?string
    {
        $value = $this->credentials[$key] ?? null;

        if (! $value) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (DecryptException) {
            return null;
        }
    }

    public function hasCredential(string $key): bool
    {
        return array_key_exists($key, $this->credentials ?? []);
    }
}
