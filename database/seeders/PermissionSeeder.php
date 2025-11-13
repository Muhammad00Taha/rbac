<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User management
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'users.assignRoles',

            // Profile management
            'profiles.view',
            'profiles.update',
            'profiles.delete',

            // Role & permission management
            'roles.manage',
            'permissions.manage',

            // Section management
            'sections.view',
            'sections.create',
            'sections.update',
            'sections.delete',

            // Class management
            'classes.view',
            'classes.create',
            'classes.update',
            'classes.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                []
            );
        }
    }
}

