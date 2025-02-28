<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role_user')->truncate();
        DB::table('permission_role')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();

        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['display_name' => 'Administrator', 'description' => 'Has full access to the system']
        );

        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            ['display_name' => 'User', 'description' => 'Regular system user']
        );

        $permissions = [
            ['name' => 'manage-users', 'display_name' => 'Manage Users', 'description' => 'Can manage user accounts'],
            ['name' => 'create-projects', 'display_name' => 'Create Projects', 'description' => 'Can create new projects'],
        ];

        $permissionIds = [];
        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate(['name' => $perm['name']], $perm);
            $permissionIds[] = $permission->id;
        }

        $adminRole->permissions()->sync($permissionIds);
    }
}
