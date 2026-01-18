<?php

use App\Models\AttributeDefinition;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\InventoryLevel;
use App\Models\InventoryLocation;
use App\Models\MediaAsset;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ProductVariant;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('creates a product with options, variants, media, inventory, and attributes', function () {
    $user = Customer::factory()->create();
    Sanctum::actingAs($user);

    $category = Category::factory()->create();

    InventoryLocation::firstOrCreate(
        ['code' => 'MAIN'],
        ['name' => 'Main warehouse', 'address' => 'Primary fulfillment center']
    );

    AttributeDefinition::updateOrCreate(
        ['key' => 'material'],
        ['label_translations' => ['en' => 'Material'], 'type' => 'TEXT']
    );
    AttributeDefinition::updateOrCreate(
        ['key' => 'power_source'],
        ['label_translations' => ['en' => 'Power source'], 'type' => 'SELECT', 'options' => ['USB', 'Battery']]
    );
    AttributeDefinition::updateOrCreate(
        ['key' => 'connectivity'],
        ['label_translations' => ['en' => 'Connectivity'], 'type' => 'MULTISELECT', 'options' => ['Bluetooth', 'Wi-Fi']]
    );

    $slugEn = Str::slug('Nova Smart Lamp ' . Str::random(6));
    $slugAr = 'مصباح-نوفا-' . Str::random(4);

    $payload = [
        'name_translations' => ['en' => 'Nova Smart Lamp', 'ar' => 'مصباح نوفا الذكي'],
        'slug_translations' => ['en' => $slugEn, 'ar' => $slugAr],
        'summary_translations' => ['en' => 'Warm ambient light with smart controls.', 'ar' => 'إضاءة دافئة مع تحكم ذكي.'],
        'description_translations' => ['en' => 'A compact lamp with adaptive light modes.', 'ar' => 'مصباح صغير مع أوضاع إضاءة ذكية.'],
        'price' => 149.0,
        'compare_at_price' => 189.0,
        'category_ids' => [$category->id],
        'is_active' => true,
        'options' => [
            [
                'code' => 'color',
                'name_translations' => ['en' => 'Color', 'ar' => 'اللون'],
                'position' => 1,
                'values' => [
                    ['value' => 'red', 'label_translations' => ['en' => 'Red', 'ar' => 'أحمر'], 'swatch_hex' => '#D73A31', 'position' => 1],
                    ['value' => 'blue', 'label_translations' => ['en' => 'Blue', 'ar' => 'أزرق'], 'swatch_hex' => '#2F80ED', 'position' => 2],
                ],
            ],
            [
                'code' => 'size',
                'name_translations' => ['en' => 'Size', 'ar' => 'المقاس'],
                'position' => 2,
                'values' => [
                    ['value' => 's', 'label_translations' => ['en' => 'Small', 'ar' => 'صغير'], 'position' => 1],
                    ['value' => 'm', 'label_translations' => ['en' => 'Medium', 'ar' => 'متوسط'], 'position' => 2],
                ],
            ],
        ],
        'variants' => [
            [
                'sku' => 'NOVA-RED-S',
                'price_cents' => 14900,
                'compare_at_cents' => 18900,
                'currency' => 'USD',
                'has_sensor' => true,
                'is_active' => true,
                'option_values' => [
                    ['option_code' => 'color', 'value' => 'red'],
                    ['option_code' => 'size', 'value' => 's'],
                ],
                'inventory' => [['location_code' => 'MAIN', 'on_hand' => 12, 'reserved' => 1]],
            ],
            [
                'sku' => 'NOVA-RED-M',
                'price_cents' => 15900,
                'currency' => 'USD',
                'is_active' => true,
                'option_values' => [
                    ['option_code' => 'color', 'value' => 'red'],
                    ['option_code' => 'size', 'value' => 'm'],
                ],
                'inventory' => [['location_code' => 'MAIN', 'on_hand' => 8, 'reserved' => 0]],
            ],
            [
                'sku' => 'NOVA-BLUE-S',
                'price_cents' => 14900,
                'currency' => 'USD',
                'is_active' => true,
                'option_values' => [
                    ['option_code' => 'color', 'value' => 'blue'],
                    ['option_code' => 'size', 'value' => 's'],
                ],
                'inventory' => [['location_code' => 'MAIN', 'on_hand' => 10, 'reserved' => 0]],
            ],
            [
                'sku' => 'NOVA-BLUE-M',
                'price_cents' => 15900,
                'currency' => 'USD',
                'is_active' => true,
                'option_values' => [
                    ['option_code' => 'color', 'value' => 'blue'],
                    ['option_code' => 'size', 'value' => 'm'],
                ],
                'inventory' => [['location_code' => 'MAIN', 'on_hand' => 6, 'reserved' => 0]],
            ],
        ],
        'media' => [
            ['url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=1200&q=80', 'type' => 'image', 'option_code' => 'color', 'value' => 'red', 'position' => 0, 'is_primary' => true],
            ['url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1200&q=80', 'type' => 'image', 'option_code' => 'color', 'value' => 'red', 'position' => 1],
            ['url' => 'https://images.unsplash.com/photo-1503602642458-232111445657?auto=format&fit=crop&w=1200&q=80', 'type' => 'image', 'option_code' => 'color', 'value' => 'blue', 'position' => 2],
            ['url' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=1200&q=80', 'type' => 'image', 'option_code' => 'color', 'value' => 'blue', 'position' => 3],
        ],
        'attributes' => [
            ['definition_key' => 'material', 'value' => 'Anodized aluminum'],
            ['definition_key' => 'power_source', 'value' => 'USB'],
            ['definition_key' => 'connectivity', 'value' => ['Bluetooth', 'Wi-Fi']],
        ],
    ];

    $response = $this->postJson('/api/admin/products', $payload);

    $response->assertStatus(200)
        ->assertJsonPath('data.slug', $slugEn)
        ->assertJsonPath('data.options.0.code', 'color')
        ->assertJsonCount(4, 'data.variants')
        ->assertJsonCount(4, 'data.media');

    expect(Product::count())->toBe(1);
    expect(ProductOption::count())->toBe(2);
    expect(ProductOptionValue::count())->toBe(4);
    expect(ProductVariant::count())->toBe(4);
    expect(MediaAsset::count())->toBe(4);
    expect(InventoryLevel::count())->toBe(4);
    expect(AttributeValue::count())->toBe(3);
});
