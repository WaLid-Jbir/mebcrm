<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultiplePermissions = [
            ['name' => 'view_users', 'guard_name' => 'web'],
            ['name' => 'create_users', 'guard_name' => 'web'],
            ['name' => 'update_users', 'guard_name' => 'web'],
            ['name' => 'delete_users', 'guard_name' => 'web'],
    
            ['name' => 'view_roles', 'guard_name' => 'web'],
            ['name' => 'create_roles', 'guard_name' => 'web'],
            ['name' => 'update_roles', 'guard_name' => 'web'],
            ['name' => 'delete_roles', 'guard_name' => 'web'],
    
            ['name' => 'view_permissions', 'guard_name' => 'web'],
            ['name' => 'create_permissions', 'guard_name' => 'web'],
            ['name' => 'update_permissions', 'guard_name' => 'web'],
            ['name' => 'delete_permissions', 'guard_name' => 'web'],
    
            ['name' => 'view_entreprises', 'guard_name' => 'web'],
            ['name' => 'create_entreprises', 'guard_name' => 'web'],
            ['name' => 'update_entreprises', 'guard_name' => 'web'],
            ['name' => 'delete_entreprises', 'guard_name' => 'web'],
            
            ['name' => 'view_prospects', 'guard_name' => 'web'],
            ['name' => 'create_prospects', 'guard_name' => 'web'],
            ['name' => 'update_prospects', 'guard_name' => 'web'],
            ['name' => 'delete_prospects', 'guard_name' => 'web'],
        ];
        
        Permission::insert($createMultiplePermissions);
    }
}
