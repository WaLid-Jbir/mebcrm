<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Entreprise;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

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

    //================================================

    $entreprise = Entreprise::create([
        'name' => 'Monexpertbudget',
        'address' => 'Paris',
        'country' => 'France',
        'city' => 'Paris',
    ]);

    $user1 = User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'entreprise_id' => $entreprise->id,
    ]);


    $role = Role::create(['name' => 'Admin']);
    $user1->assignRole($role);
    }
}
