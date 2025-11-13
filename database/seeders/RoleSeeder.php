<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Admin', 'Manager', 'User'];

        $roleModels = collect($roles)->mapWithKeys(function (string $role) {
            return [$role => Role::firstOrCreate(['name' => $role, 'guard_name' => 'web'])];
        });

        $permissions = Permission::all()->pluck('name', 'name');

        /** @var \Spatie\Permission\Models\Role $adminRole */
        $adminRole = $roleModels->get('Admin');
        $adminRole->syncPermissions($permissions->keys()->all());

        /** @var \Spatie\Permission\Models\Role $managerRole */
        $managerRole = $roleModels->get('Manager');
        $managerRole->syncPermissions([
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'profiles.view',
            'profiles.update',
            'sections.view',
            'sections.create',
            'sections.update',
            'sections.delete',
            'classes.view',
            'classes.create',
            'classes.update',
            'classes.delete',
        ]);

        /** @var \Spatie\Permission\Models\Role $userRole */
        $userRole = $roleModels->get('User');
        $userRole->syncPermissions([
            'profiles.view',
            'profiles.update',
        ]);
    }
}
