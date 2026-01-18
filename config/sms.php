<?php

return [
    'default' => env('SMS_DRIVER', 'log'),

    'drivers' => [
        'log' => [
            'channel' => env('SMS_LOG_CHANNEL', 'stack'),
        ],
    ],

    'providers' => [
        'twilio' => [
            'sid' => env('TWILIO_SID'),
            'token' => env('TWILIO_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],
    ],
];
