<?php

use App\Models\Customer;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

beforeEach(function () {
    if (! Features::canManageTwoFactorAuthentication()) {
        $this->markTestSkipped('Two-factor authentication is not enabled.');
    }

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);
});

test('two factor settings page can be rendered', function () {
    $user = Customer::factory()->withoutTwoFactor()->create();

    $this->actingAs($user, 'customer')
        ->withSession(['auth.password_confirmed_at' => time()])
        ->get(route('admin.setting.twofactor'))
        ->assertOk()
        ->assertSee('Two Factor Authentication')
        ->assertSee('Disabled');
});

test('two factor settings page requires password confirmation when enabled', function () {
    $user = Customer::factory()->create();

    $response = $this->actingAs($user, 'customer')
        ->get(route('admin.setting.twofactor'));

    $response->assertRedirect(route('password.confirm'));
});

test('two factor settings page returns forbidden response when two factor is disabled', function () {
    config(['fortify.features' => []]);

    $user = Customer::factory()->create();

    $response = $this->actingAs($user, 'customer')
        ->withSession(['auth.password_confirmed_at' => time()])
        ->get(route('admin.setting.twofactor'));

    $response->assertForbidden();
});

test('two factor authentication disabled when confirmation abandoned between requests', function () {
    $user = Customer::factory()->create();

    $user->forceFill([
        'two_factor_secret' => encrypt('test-secret'),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
        'two_factor_confirmed_at' => null,
    ])->save();

    $this->actingAs($user, 'customer');

    $component = Volt::test('settings.two-factor');

    $component->assertSet('twoFactorEnabled', false);

    $this->assertDatabaseHas('customers', [
        'id' => $user->id,
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
    ]);
});
