<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'entreprise_id' => 1
        ]);
        $user_admin->assignRole('Admin');

        //==========================

        $user_manager = User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'entreprise_id' => 1
        ]);
        $user_manager->assignRole('Manager');

        //==========================

        $user_adherant = User::factory()->create([
            'name' => 'Adherant',
            'email' => 'adherant@example.com',
            'entreprise_id' => 1
        ]);
        $user_adherant->assignRole('Adherant');
    }
}
