<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'Dashboard',
            'RolesAndAdmins',
            'Roles',
            'AllRoles',
            'AddRole',
            'EditRole',
            'DeleteRole',
            'ShowRole',
            'Admins',
            'AllAdmins',
            'AddAdmin',
            'EditAdmin',
            'DeleteAdmin',
            'Users',
            'AllUsers',
            'AddUser',
            'EditUser',
            'DeleteUser',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'admin']);

        // Assign all permissions to "admin" role
        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);
    }
}
