<?php

namespace Database\Seeders;

use App\Models\Paie;
use App\Models\Employe;
use Illuminate\Database\Seeder;

class PaieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employes = Employe::all();

        foreach ($employes as $index => $employe) {
            // Un bulletin pour le mois de Mars 2026
            Paie::firstOrCreate([
                'employe_id' => $employe->id,
                'mois' => 3,
                'annee' => 2026,
            ], [
                'salaire_base' => 6000 + ($index * 300),
                'primes' => 500,
                'deductions' => 250,
                'salaire_net' => 6000 + ($index * 300) + 500 - 250,
            ]);
        }
    }
}
