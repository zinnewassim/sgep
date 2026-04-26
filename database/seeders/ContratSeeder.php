<?php

namespace Database\Seeders;

use App\Models\Contrat;
use App\Models\Employe;
use Illuminate\Database\Seeder;

class ContratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employes = Employe::all();
        $types = ['CDI', 'CDD', 'Stage'];

        foreach ($employes as $index => $employe) {
            Contrat::firstOrCreate([
                'employe_id' => $employe->id,
            ], [
                'type_contrat' => $types[$index % 2], // Alterne entre CDI et CDD
                'date_debut' => now()->startOfYear()->subMonths($index + 6),
                'date_fin' => ($index % 2 == 1) ? now()->addYear() : null, // CDD a une fin
                'salaire_base' => 6500.00 + ($index * 500), // Salaire progressif
            ]);
        }
    }
}
