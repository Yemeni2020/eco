<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::firstOrCreate(
            ['email' => 'admin@otex.com'],
            [
                'name' => 'Platform Administrator',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'User@1234')),
            ],
        );

        $superAdminRole = Role::where('slug', 'super-admin')->first();
        if ($superAdminRole) {
            $admin->assignRole($superAdminRole->slug);
        }
    }
}
