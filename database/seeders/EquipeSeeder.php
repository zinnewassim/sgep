<?php

namespace Database\Seeders;

use App\Models\Equipe;
use Illuminate\Database\Seeder;

class EquipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Equipe::firstOrCreate([
            'code' => 'DEV_TEAM',
            'libelle' => 'Développement Logiciel',
        ]);

        Equipe::firstOrCreate([
            'code' => 'RH_TEAM',
            'libelle' => 'Ressources Humaines & Admin',
        ]);

        Equipe::firstOrCreate([
            'code' => 'SALES_TEAM',
            'libelle' => 'Force de Vente & Marketing',
        ]);
    }
}
