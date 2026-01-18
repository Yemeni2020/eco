<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissionSet = [
            ['name' => 'View admin dashboard', 'slug' => 'view_dashboard'],
            ['name' => 'Manage products', 'slug' => 'manage_products'],
            ['name' => 'Manage orders', 'slug' => 'manage_orders'],
            ['name' => 'Manage customers', 'slug' => 'manage_customers'],
            ['name' => 'Manage settings', 'slug' => 'manage_settings'],
            ['name' => 'Manage payments', 'slug' => 'manage_payments'],
        ];

        foreach ($permissionSet as $permission) {
            Permission::updateOrCreate(['slug' => $permission['slug']], $permission);
        }

        $superAdmin = Role::updateOrCreate(
            ['slug' => 'super-admin'],
            ['name' => 'Super Admin', 'is_default' => true]
        );

        $manager = Role::updateOrCreate(
            ['slug' => 'admin-manager'],
            ['name' => 'Admin Manager']
        );

        $allPermissionIds = Permission::pluck('id')->all();
        $superAdmin->permissions()->sync($allPermissionIds);

        $manager->permissions()->sync(
            Permission::whereIn('slug', ['view_dashboard', 'manage_customers', 'manage_orders'])->pluck('id')->all()
        );
    }
}
