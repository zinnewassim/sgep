<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departement;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departement::firstOrCreate(['code' => 'RH'], ['libelle' => 'Ressources Humaines']);
        Departement::firstOrCreate(['code' => 'IT'], ['libelle' => 'Informatique']);
        Departement::firstOrCreate(['code' => 'FIN'], ['libelle' => 'Finance']);
        Departement::firstOrCreate(['code' => 'OPS'], ['libelle' => 'Opérations']);
    }
}
