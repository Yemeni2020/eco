<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Log;

class LogSmsSender implements SmsSender
{
    public function __construct(private string $channel)
    {
    }

    public function send(string $phone, string $message, array $meta = []): void
    {
        Log::channel($this->channel)->info('sms.sent', [
            'phone' => $phone,
            'message' => $message,
            'meta' => $meta,
        ]);
    }
}
