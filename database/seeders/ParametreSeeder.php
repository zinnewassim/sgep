<?php

namespace Database\Seeders;

use App\Models\Parametre;
use Illuminate\Database\Seeder;

class ParametreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Parametre::firstOrCreate(['cle' => 'SITE_NAME'], ['valeur' => 'SGEP Personnel', 'description' => 'Nom de l\'application']);
        Parametre::firstOrCreate(['cle' => 'COMPANY_NAME'], ['valeur' => 'SGEP Maroc S.A.', 'description' => 'Nom de l\'entreprise']);
        Parametre::firstOrCreate(['cle' => 'MAX_RETARE_MINUTES'], ['valeur' => '30', 'description' => 'Maximum retard autorisé']);
    }
}
