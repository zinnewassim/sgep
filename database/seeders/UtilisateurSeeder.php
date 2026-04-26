<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Utilisateur;
use App\Models\Employe;
use App\Models\Departement;
use App\Models\Poste;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin account (no employee profile needed)
        $admin = Utilisateur::updateOrCreate(
            ['email' => 'admin@sgep.ma'],
            [
                'uuid' => (string) Str::uuid(),
                'nom' => 'Administrateur',
                'prenom' => 'SGEP',
                'mot_de_passe' => Hash::make('password'),
                'etat' => 'actif',
            ]
        );
        $admin->syncRoles(['admin']);

        // Sample Employé user — linked to a real employee profile
        $empUser = Utilisateur::updateOrCreate(
            ['email' => 'employe@sgep.ma'],
            [
                'uuid' => (string) Str::uuid(),
                'nom' => 'El Amrani',
                'prenom' => 'Youssef',
                'mot_de_passe' => Hash::make('password'),
                'etat' => 'actif',
            ]
        );
        $empUser->syncRoles(['employe']);

        // Link the employee user to the first employee record
        $it = Departement::where('code', 'IT')->first();
        $dev = Poste::where('code', 'DEV')->first();

        Employe::updateOrCreate(
            ['email' => 'employe@sgep.ma'],
            [
                'uuid' => (string) Str::uuid(),
                'utilisateur_id' => $empUser->id,
                'departement_id' => $it?->id,
                'poste_id' => $dev?->id,
                'matricule' => 'EMP000',
                'nom' => 'El Amrani',
                'prenom' => 'Youssef',
                'date_embauche' => '2023-01-15',
                'genre' => 'M',
                'cin' => 'AA00000',
                'statut' => 'actif',
            ]
        );
    }
}
