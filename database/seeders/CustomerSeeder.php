<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make(env('DEMO_CUSTOMER_PASSWORD', 'password'));
        $primaryPhone = env('DEMO_CUSTOMER_PHONE', '+966500000000');

        Customer::firstOrCreate(
            ['phone_normalized' => $primaryPhone],
            [
                'name' => 'Demo Customer',
                'email' => 'demo+customer@example.com',
                'password' => $password,
                'phone' => $primaryPhone,
                'phone_normalized' => $primaryPhone,
            ],
        );

        $faker = fake();

        for ($index = 1; $index <= 9; $index++) {
            $phone = $faker->unique()->e164PhoneNumber();

            Customer::firstOrCreate(
                ['phone_normalized' => $phone],
                [
                    'name' => $faker->name(),
                    'email' => "demo+customer{$index}@example.com",
                    'password' => $password,
                    'phone' => $phone,
                    'phone_normalized' => $phone,
                ],
            );
        }
    }
}
