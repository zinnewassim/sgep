<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poste;
use App\Models\Departement;

class PosteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rh = Departement::where('code', 'RH')->first();
        $it = Departement::where('code', 'IT')->first();

        if ($it) {
            Poste::updateOrCreate(['code' => 'DEV'], [
                'libelle' => 'Développeur Full Stack',
                'departement_id' => $it->id,
                'grade' => 'Senior'
            ]);
        }

        if ($rh) {
            Poste::updateOrCreate(['code' => 'MGR_RH'], [
                'libelle' => 'Manager RH',
                'departement_id' => $rh->id,
                'grade' => 'Directeur'
            ]);
        }
    }
}
