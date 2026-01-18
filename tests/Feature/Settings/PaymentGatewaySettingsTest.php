<?php

use App\Domain\Payments\Gateways\ApplePayGateway;
use App\Domain\Payments\Gateways\MadaGateway;
use App\Domain\Payments\Gateways\StcPayGateway;
use App\Domain\Payments\PaymentGatewayResolver;
use App\Domain\Payments\Repositories\PaymentGatewaySettingsRepository;
use App\Models\Admin;
use App\Models\Order;
use App\Models\PaymentGatewaySetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

test('admin can update payment gateways and secrets remain encrypted', function () {
    $admin = Admin::create([
        'name' => 'Store Admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'is_active' => true,
    ]);

    $this->actingAs($admin, 'admin');

    $response = $this->post(route('admin.settings.payments'), [
        'gateways' => [
            'mada' => [
                'display_name' => 'Mada Pay',
                'is_enabled' => '1',
                'sandbox_mode' => '0',
                'merchant_id' => 'MADA-123',
                'terminal_id' => 'TERM-MADA',
                'api_key' => 'mada-key',
                'secret' => 'mada-secret',
            ],
            'stcpay' => [
                'display_name' => 'STC Pay Express',
                'is_enabled' => '1',
                'sandbox_mode' => '1',
                'merchant_id' => 'STC-456',
                'terminal_id' => 'TERM-STC',
                'api_key' => 'stc-api',
                'secret' => 'stc-secret',
            ],
            'applepay' => [
                'display_name' => 'Apple Pay',
                'is_enabled' => '1',
                'sandbox_mode' => '1',
                'merchant_id' => 'APPLE-999',
                'apple_merchant_id' => 'apple-merchant',
                'api_key' => 'apple-key',
                'secret' => 'apple-secret',
            ],
        ],
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('payment_settings_status', 'Payment gateway settings saved.');

    $this->assertDatabaseHas('payment_gateway_settings', [
        'gateway' => 'mada',
        'display_name' => 'Mada Pay',
        'is_enabled' => 1,
        'sandbox_mode' => 0,
    ]);

    $this->assertDatabaseHas('payment_gateway_settings', [
        'gateway' => 'stcpay',
        'display_name' => 'STC Pay Express',
    ]);

    $mada = PaymentGatewaySetting::where('gateway', 'mada')->first();

    expect($mada->getCredential('merchant_id'))->toBe('MADA-123');
    expect($mada->getCredential('secret'))->toBe('mada-secret');

    $credentialsRaw = DB::table('payment_gateway_settings')
        ->where('gateway', 'mada')
        ->value('credentials');

    $decoded = json_decode($credentialsRaw, true);
    expect($decoded['secret'])->not->toBe('mada-secret');
    expect($decoded['api_key'])->not->toBe('mada-key');

    $repository = app(PaymentGatewaySettingsRepository::class);
    $enabled = $repository->enabledOptions();

    expect($enabled->pluck('gateway')->toArray())->toEqualCanonicalizing(['mada', 'stcpay', 'applepay']);
    expect($enabled->pluck('label')->toArray())->toContain('Mada Pay');

    $resolver = app(PaymentGatewayResolver::class);
    $order = new Order([
        'order_number' => 'ORDER-1',
        'total' => 150.00,
    ]);

    $madaGateway = $resolver->resolve('mada');
    expect($madaGateway)->toBeInstanceOf(MadaGateway::class);
    expect($madaGateway->initiatePayment($order)->payload['merchant_id'])->toBe('MADA-123');

    $stcGateway = $resolver->resolve('stcpay');
    expect($stcGateway)->toBeInstanceOf(StcPayGateway::class);
    expect($stcGateway->initiatePayment($order)->payload['merchant_id'])->toBe('STC-456');

    $appleGateway = $resolver->resolve('applepay');
    expect($appleGateway)->toBeInstanceOf(ApplePayGateway::class);
});
