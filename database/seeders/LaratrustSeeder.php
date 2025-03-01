<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class LaratrustSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'manage-users', 'display_name' => 'Manage Users', 'description' => 'Can manage user accounts'],
            ['name' => 'create-projects', 'display_name' => 'Create Projects', 'description' => 'Can create new projects'],
            ['name' => 'manage-issues', 'display_name' => 'Manage Issues', 'description' => 'Can create, edit, and delete issues'],
        ];

        $permissionIds = [];
        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate(['name' => $perm['name']], $perm);
            $permissionIds[] = $permission->id;
        }

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->sync($permissionIds);
        }

        $adminUser = User::where('email', 'admin@admin.com')->first();
        if ($adminUser) {
            $manageUsersPermission = Permission::where('name', 'manage-users')->first();
            if ($manageUsersPermission) {
                $adminUser->permissions()->sync([$manageUsersPermission->id]);
            }
        }
    }
}
