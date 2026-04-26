<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employe;
use App\Models\Departement;
use App\Models\Poste;
use Illuminate\Support\Str;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $it = Departement::where('code', 'IT')->first();
        $rh = Departement::where('code', 'RH')->first();
        $dev = Poste::where('code', 'DEV')->first();
        $mgr = Poste::where('code', 'MGR_RH')->first();

        $employees = [
            [
                'nom' => 'El Amrani',
                'prenom' => 'Youssef',
                'email' => 'youssef@sgep.ma',
                'matricule' => 'EMP001',
                'departement_id' => $it->id,
                'poste_id' => $dev->id,
                'date_embauche' => '2023-01-15',
                'genre' => 'M',
                'cin' => 'AB12345'
            ],
            [
                'nom' => 'Mansouri',
                'prenom' => 'Fatima Zahra',
                'email' => 'fatima@sgep.ma',
                'matricule' => 'EMP002',
                'departement_id' => $rh->id,
                'poste_id' => $mgr->id,
                'date_embauche' => '2022-06-10',
                'genre' => 'F',
                'cin' => 'CD56789'
            ],
            [
                'nom' => 'Benali',
                'prenom' => 'Mohamed',
                'email' => 'mohamed@sgep.ma',
                'matricule' => 'EMP003',
                'departement_id' => $it->id,
                'poste_id' => $dev->id,
                'date_embauche' => '2023-03-20',
                'genre' => 'M',
                'cin' => 'EF10111'
            ],
            [
                'nom' => 'Jabrane',
                'prenom' => 'Amina',
                'email' => 'amina@sgep.ma',
                'matricule' => 'EMP004',
                'departement_id' => $it->id,
                'poste_id' => $dev->id,
                'date_embauche' => '2023-05-01',
                'genre' => 'F',
                'cin' => 'GH21212'
            ],
            [
                'nom' => 'Idrissi',
                'prenom' => 'Hassan',
                'email' => 'hassan@sgep.ma',
                'matricule' => 'EMP005',
                'departement_id' => $rh->id,
                'poste_id' => $mgr->id,
                'date_embauche' => '2021-11-25',
                'genre' => 'M',
                'cin' => 'IJ31313'
            ],
        ];

        foreach ($employees as $data) {
            $data['uuid'] = (string) Str::uuid();
            Employe::updateOrCreate(['email' => $data['email']], $data);
        }
    }
}
