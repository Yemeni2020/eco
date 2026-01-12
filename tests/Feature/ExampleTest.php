<?php

test('returns a successful response', function () {
    $response = $this->get(route('home', ['locale' => config('app.locale')]));

    $response->assertStatus(200);
});
