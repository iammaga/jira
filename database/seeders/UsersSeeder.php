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
        // Создание администратора
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );

        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['display_name' => 'Administrator', 'description' => 'Has full access to the system']
        );

        // Привязка роли admin к пользователю в role_user
        $admin->roles()->sync([$adminRole->id]);

        // Создание обычного пользователя
        $user = User::updateOrCreate(
            ['email' => 'user@user.com'],
            ['name' => 'User', 'password' => Hash::make('password')]
        );

        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            ['display_name' => 'User', 'description' => 'Regular system user']
        );

        // Привязка роли user к пользователю в role_user
        $user->roles()->sync([$userRole->id]);
    }
}
