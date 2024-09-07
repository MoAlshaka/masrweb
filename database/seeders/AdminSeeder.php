<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::create([
            'name' => 'Admin',
            'username' => 'masrweb',
            'roles_name' => 'Owner',
            'password' => bcrypt('admin123'),
        ]);
        $role = Role::create(['name' => 'Owner', 'guard_name' => 'admin']);

        // Assign the "Owner" role to the user
        if ($role && !$admin->hasRole($role)) {
            $admin->assignRole($role);
        }
    }
}
