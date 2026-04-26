<?php

namespace Database\Seeders;

use App\Models\ReglePresence;
use Illuminate\Database\Seeder;

class ReglePresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReglePresence::firstOrCreate([
            'label' => 'Standard Horaires',
            'description' => 'Horaires de bureau standard Maroc (08:30 - 17:30)',
            'start_time' => '08:30:00',
            'end_time' => '17:30:00',
            'grace_period_minutes' => 15,
        ]);

        ReglePresence::firstOrCreate([
            'label' => 'Shift Soir',
            'description' => 'Horaires de soir (14:00 - 22:00)',
            'start_time' => '14:00:00',
            'end_time' => '22:00:00',
            'grace_period_minutes' => 10,
        ]);
    }
}
