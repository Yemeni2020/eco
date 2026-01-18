<?php

use App\Models\Customer;

test('confirm password screen can be rendered', function () {
    $user = Customer::factory()->create();

    $response = $this->actingAs($user)->get(route('password.confirm'));

    $response->assertStatus(200);
});
