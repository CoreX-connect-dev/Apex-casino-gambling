<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use VanguardLTE\User;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;

class TestBalanceSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Roles if they don't exist
        $adminRole = Role::where('slug', 'admin')->first();
        if (!$adminRole) {
            $adminRole = Role::create([
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Admin Role',
                'level' => 6,
            ]);
        }

        $userRole = Role::where('slug', 'user')->first();
        if (!$userRole) {
            $userRole = Role::create([
                'name' => 'User',
                'slug' => 'user',
                'description' => 'User Role',
                'level' => 1,
            ]);
        }

        // 2. Create Admin User
        $admin = User::where('username', 'admin')->first();
        if (!$admin) {
            $admin = User::create([
                'username' => 'admin',
                'email' => 'admin@test.com',
                'password' => 'admin123', // setPasswordAttribute will bcrypt it
                'role_id' => $adminRole->id,
                'status' => 'Active',
                'balance' => 1000.00,
                'currency' => 'USD',
            ]);
            $admin->attachRole($adminRole);
        }

        // 3. Create regular User
        $user = User::where('username', 'testuser')->first();
        if (!$user) {
            $user = User::create([
                'username' => 'testuser',
                'email' => 'user@test.com',
                'password' => 'user123',
                'role_id' => $userRole->id,
                'parent_id' => $admin->id,
                'status' => 'Active',
                'balance' => 500.00,
                'currency' => 'USD',
            ]);
            $user->attachRole($userRole);
        }

        echo "Test users created:\n";
        echo "Admin: admin / admin123\n";
        echo "User: testuser / user123\n";
    }
}
