<?php

use App\Models\Customer;
use App\Models\CustomerOtp;
use App\Services\PhoneNormalizer;
use App\Services\Sms\SmsSender;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

test('otp requests are rate limited', function () {
    $phone = '0500000000';
    $normalized = app(PhoneNormalizer::class)->normalize($phone);
    $limitKey = sprintf('customer-otp:%s', $normalized);

    RateLimiter::clear($limitKey);

    foreach (range(1, 5) as $attempt) {
        $this->post(route('phone.login.request'), ['phone' => $phone]);
    }

    $response = $this->post(route('phone.login.request'), ['phone' => $phone]);

    $response->assertSessionHasErrors('phone');
});

test('verifying otp logs in a new customer', function () {
    $phone = '0500000000';
    $normalized = app(PhoneNormalizer::class)->normalize($phone);
    $code = null;

    $sms = \Mockery::spy(SmsSender::class);
    $sms->shouldReceive('send')->once()->andReturnUsing(function ($recipient, $message) use (&$code) {
        preg_match('/\d{4,6}/', $message, $matches);
        $code = $matches[0] ?? null;
    });
    app()->instance(SmsSender::class, $sms);

    $this->post(route('phone.login.request'), ['phone' => $phone])
        ->assertRedirect(route('phone.login.verify'));

    $this->post(route('phone.login.verify.submit'), ['phone' => $phone, 'code' => $code])
        ->assertRedirect('/');

    $this->assertDatabaseHas('customers', ['phone_normalized' => $normalized]);
    $this->assertAuthenticated('customer');
});

test('blocked customer cannot complete otp login', function () {
    $phone = '0500000000';
    $normalized = app(PhoneNormalizer::class)->normalize($phone);

    $customer = Customer::factory()->create([
        'phone' => $normalized,
        'phone_normalized' => $normalized,
        'blocked_at' => now(),
    ]);

    $otp = CustomerOtp::create([
        'phone' => $phone,
        'phone_normalized' => $normalized,
        'code_hash' => Hash::make('123456'),
        'expires_at' => Carbon::now()->addMinutes(5),
        'attempts' => 0,
    ]);

    $response = $this->post(route('phone.login.verify.submit'), [
        'phone' => $phone,
        'code' => '123456',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('phone');
    $this->assertGuest('customer');
});
