<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'Admin'
        ]);
        
        $manager = Role::create([
            'name' => 'Manager',
        ]);

        $adherant = Role::create([
            'name' => 'Adherant',
        ]);
    }
}
