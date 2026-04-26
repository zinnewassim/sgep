<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employe;
use App\Models\Pointage;
use App\Models\Absence;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employe::all();
        $today = Carbon::today();

        foreach ($employees as $emp) {
            // Seed pointage for yesterday
            Pointage::create([
                'employe_id' => $emp->id,
                'date' => $today->copy()->subDay(),
                'heure_entree' => '08:30:00',
                'heure_sortie' => '17:30:00',
                'statut' => 'present',
            ]);

            // Seed some random behavior
            if ($emp->matricule == 'EMP003') {
                // Late today
                Pointage::create([
                    'employe_id' => $emp->id,
                    'date' => $today,
                    'heure_entree' => '09:15:00',
                    'statut' => 'retard',
                ]);
            } elseif ($emp->matricule == 'EMP004') {
                // Absent today
                Absence::create([
                    'employe_id' => $emp->id,
                    'type' => 'conge_paye',
                    'date_debut' => $today,
                    'date_fin' => $today->copy()->addDays(2),
                    'statut' => 'approuve',
                ]);
            } else {
                // Present today
                Pointage::create([
                    'employe_id' => $emp->id,
                    'date' => $today,
                    'heure_entree' => '08:00:00',
                    'statut' => 'present',
                ]);
            }
        }
    }
}
