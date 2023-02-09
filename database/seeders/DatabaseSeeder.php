<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Entreprise;
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

    $entreprise = Entreprise::create([
        'name' => 'Monexpertbudget',
        'address' => 'address1',
        'country' => 'country1',
        'city' => 'country2',
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
