<?php

namespace Database\Seeders;

use App\Models\Entreprise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntrepriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Entreprise::create([
            'name' => 'Monexpertbudget',
            'address' => 'Paris',
            'country' => 'France',
            'city' => 'Paris',
        ]);
    }
}
