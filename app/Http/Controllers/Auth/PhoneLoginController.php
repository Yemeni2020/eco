<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerOtp;
use App\Services\PhoneNormalizer;
use App\Services\Sms\SmsSender;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class PhoneLoginController extends Controller
{
    private const OTP_TTL_MINUTES = 5;
    private const OTP_RATE_LIMIT = 5;
    private const OTP_RATE_DECAY = 60;

    public function __construct(
        private PhoneNormalizer $normalizer,
        private SmsSender $smsSender,
    ) {
    }

    public function showRequestForm()
    {
        return view('auth.phone-login.request');
    }

    public function requestOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string'],
        ]);

        try {
            $phone = $this->normalizer->normalize($request->input('phone'));
        } catch (\InvalidArgumentException $exception) {
            return back()->withErrors(['phone' => __('Please provide a valid phone number.')]);
        }

        $limitKey = $this->rateLimitKey($phone);

        if (RateLimiter::tooManyAttempts($limitKey, self::OTP_RATE_LIMIT)) {
            return back()->withErrors([
                'phone' => __('Too many attempts. Please try again in :seconds seconds.', [
                    'seconds' => RateLimiter::availableIn($limitKey),
                ]),
            ]);
        }

        RateLimiter::hit($limitKey, self::OTP_RATE_DECAY);

        $code = random_int(100000, 999999);

        CustomerOtp::create([
            'phone' => $request->input('phone'),
            'phone_normalized' => $phone,
            'code_hash' => Hash::make((string) $code),
            'expires_at' => Carbon::now()->addMinutes(self::OTP_TTL_MINUTES),
            'attempts' => 0,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $this->smsSender->send($phone, __('Your verification code is :code', ['code' => $code]));

        session()->flash('customer_phone', $phone);

        return redirect()->route('phone.login.verify')->with('status', __('OTP sent to :phone', ['phone' => $phone]));
    }

    public function showVerifyForm(Request $request)
    {
        $phone = session('customer_phone') ?? $request->query('phone');

        return view('auth.phone-login.verify', [
            'phone' => $phone,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
        ]);

        $phone = $this->resolvePhone($request);

        if (! $phone) {
            return back()->withErrors(['phone' => __('Missing phone number for verification.')]);
        }

        $otp = CustomerOtp::where('phone_normalized', $phone)
            ->whereNull('used_at')
            ->orderByDesc('id')
            ->first();

        if (! $otp || $otp->isExpired()) {
            return back()->withErrors(['code' => __('The one-time code has expired. Please request a new code.')]);
        }

        if (! $otp->matches($request->input('code'))) {
            $otp->incrementAttempts();

            return back()->withErrors(['code' => __('The provided code is invalid.')]);
        }

        $otp->markUsed();

        $customer = Customer::firstOrCreate(
            ['phone_normalized' => $phone],
            [
                'phone' => $phone,
                'phone_normalized' => $phone,
            ],
        );

        if ($customer->isBlocked()) {
        return redirect()->route('login')->withErrors([
                'phone' => __('Your account is blocked. Contact support for assistance.'),
            ]);
        }

        Auth::guard('customer')->login($customer);

        return redirect()->intended('/');
    }

    private function rateLimitKey(string $phone): string
    {
        return sprintf('customer-otp:%s', $phone);
    }

    private function resolvePhone(Request $request): ?string
    {
        $candidate = $request->input('phone') ?? session('customer_phone');

        if (! $candidate) {
            return null;
        }

        try {
            return $this->normalizer->normalize($candidate);
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }
}
