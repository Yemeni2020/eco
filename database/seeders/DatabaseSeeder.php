<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Database\Seeders\AttributeDefinitionSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\DemoCatalogSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SiteSettingsSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $defaultCustomerPhone = env('DEMO_CUSTOMER_PHONE', '+966500000000');

        Customer::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo Customer',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'phone' => $defaultCustomerPhone,
                'phone_normalized' => $defaultCustomerPhone,
            ]
        );

        if (Category::count() === 0) {
            Category::factory()->count(6)->create();
        }

        if (Product::count() < 40) {
            Product::factory()->count(40)->create();
        }

        $this->call(ColorSeeder::class);
        $this->call(AttributeDefinitionSeeder::class);
        $this->call(ProductSeeder::class);

        if (app()->environment(['local', 'development'])) {
            $this->call(DemoCatalogSeeder::class);
        }

        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(SiteSettingsSeeder::class);
    }
}
