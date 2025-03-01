<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \DB::table('role_user')->truncate();
        \DB::table('permission_user')->truncate();
        \DB::table('permission_role')->truncate();
        \DB::table('users')->truncate();
        \DB::table('roles')->truncate();
        \DB::table('permissions')->truncate();

        $this->call([
            RolesAndPermissionsSeeder::class,
            UsersSeeder::class,
            ProjectsSeeder::class,
            IssueTypesSeeder::class,
            PrioritiesSeeder::class,
            StatusesSeeder::class,
            IssuesSeeder::class,
            LaratrustSeeder::class,
        ]);
    }
}
