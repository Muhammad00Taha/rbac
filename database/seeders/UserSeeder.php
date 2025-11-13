<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific test users with known roles
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        $manager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
            ]
        );

        // Assign roles (Role existence ensured by RoleSeeder)
        if (method_exists($admin, 'assignRole') && ! $admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }

        if (method_exists($manager, 'assignRole') && ! $manager->hasRole('Manager')) {
            $manager->assignRole('Manager');
        }

        // Create additional random users; their roles will be assigned by the factory
        User::factory()->count(10)->create();
    }
}
