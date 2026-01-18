<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('json add to cart returns payload with counts', function () {
    $product = Product::factory()->create(['price' => 39.99]);

    $response = $this->postJson(route('cart.items.store', ['locale' => app()->getLocale()]), [
        'product_id' => $product->id,
        'qty' => 2,
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'ok',
            'message',
            'cart_count',
            'item_count',
            'items' => ['*' => ['product_id', 'qty', 'price', 'total']],
            'totals' => ['subtotal', 'total'],
        ])
        ->assertJsonPath('cart_count', 2)
        ->assertJsonPath('items.0.product_id', $product->id);

    $this->assertDatabaseHas('cart_items', [
        'product_id' => $product->id,
    ]);
});
