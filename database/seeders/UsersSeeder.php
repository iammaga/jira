<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        dump("Admin created with ID: " . $admin->id);

        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Administrator',
                'description' => 'Has full access to the system',
            ]
        );
        dump("Admin role created with ID: " . $adminRole->id);

        $admin->roles()->sync([$adminRole->id]);
        dump("Admin roles count after sync: " . $admin->roles()->count());
        dump("role_user content: " . json_encode(\DB::table('role_user')->get()->toArray()));

        $user = User::updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
            ]
        );
        dump("User created with ID: " . $user->id);

        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            [
                'display_name' => 'User',
                'description' => 'Regular system user',
            ]
        );
        dump("User role created with ID: " . $userRole->id);

        $user->roles()->sync([$userRole->id]);
        dump("User roles count after sync: " . $user->roles()->count());
        dump("role_user content: " . json_encode(\DB::table('role_user')->get()->toArray()));
    }
}
