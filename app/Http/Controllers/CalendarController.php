<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Pointage;
use App\Models\Absence;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }

    public function getEvents(Request $request)
    {
        $start = $request->query('start', Carbon::now()->startOfMonth()->toDateString());
        $end = $request->query('end', Carbon::now()->endOfMonth()->toDateString());
        
        $events = [];

        // Add Absences to Calendar
        $absences = Absence::with('employe')
            ->where('date_debut', '>=', $start)
            ->orWhere('date_fin', '<=', $end)
            ->get();
            
        foreach ($absences as $absence) {
            $events[] = [
                'id' => 'a_' . $absence->id,
                'title' => 'Absence: ' . $absence->employe->nom . ' ' . $absence->employe->prenom,
                'start' => $absence->date_debut,
                'end' => Carbon::parse($absence->date_fin)->addDay()->toDateString(), // FullCalendar exclusive end date
                'color' => '#f43f5e', // rose-500
                'allDay' => true,
            ];
        }

        // Add Pointages (Attendances) to Calendar
        $pointages = Pointage::with('employe')
            ->whereBetween('date', [Carbon::parse($start)->toDateString(), Carbon::parse($end)->toDateString()])
            ->get();

        foreach ($pointages as $pointage) {
            $color = '#10b981'; // emerald-500 default present
            if ($pointage->statut == 'retard') {
                $color = '#f59e0b'; // amber-500
            } elseif ($pointage->statut == 'demi_journee') {
                $color = '#6366f1'; // indigo-500
            }

            $events[] = [
                'id' => 'p_' . $pointage->id,
                'title' => $pointage->employe->nom . ' - ' . ucfirst($pointage->statut),
                'start' => $pointage->heure_entree ? $pointage->date->toDateString() . 'T' . $pointage->heure_entree : $pointage->date->toDateString(),
                'end' => $pointage->heure_sortie ? $pointage->date->toDateString() . 'T' . $pointage->heure_sortie : null,
                'color' => $color,
            ];
        }

        return response()->json($events);
    }
}
