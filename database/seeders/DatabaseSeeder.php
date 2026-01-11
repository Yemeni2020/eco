<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\ColorSeeder;
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
        User::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo Customer',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (Category::count() === 0) {
            Category::factory()->count(6)->create();
        }

        if (Product::count() < 40) {
            Product::factory()->count(40)->create();
        }

        $this->call(ColorSeeder::class);
    }
}
