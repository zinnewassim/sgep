<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Pointage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $pointages = Pointage::with('employe')->whereDate('date', $date)->get();
        
        return view('presence.index', compact('pointages', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employe::all();
        return view('presence.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'date' => 'required|date',
            'heure_entree' => 'nullable',
            'heure_sortie' => 'nullable',
            'statut' => 'required|in:present,retard,absent,demi_journee',
        ]);

        $pointage = Pointage::where('employe_id', $validated['employe_id'])
                            ->whereDate('date', $validated['date'])
                            ->first();

        if ($pointage) {
            $pointage->update($validated);
        } else {
            Pointage::create($validated);
        }

        return redirect()->route('presence.index')->with('success', 'Présence enregistrée avec succès.');
    }

    /**
     * Handle quick punch (Pointage Rapide) from the navbar.
     */
    public function quickPunch(Request $request)
    {
        $employe = Employe::where('utilisateur_id', auth()->id())->first();
        
        if (!$employe) {
            return redirect()->back()->with('error', 'Erreur : Votre compte n\'est pas rattaché à un profil employé pour effectuer un pointage.');
        }

        $today = Carbon::today()->toDateString();
        $now = Carbon::now()->toTimeString();

        $lat = $request->input('latitude');
        $lng = $request->input('longitude');

        // Check if pointage exists for today
        $pointage = \App\Models\Pointage::where('employe_id', $employe->id)->whereDate('date', $today)->first();

        if (!$pointage) {
            // Clock In
            \App\Models\Pointage::create([
                'employe_id' => $employe->id,
                'date' => $today,
                'heure_entree' => $now,
                'statut' => 'present',
                'source' => 'application',
                'latitude_entree' => $lat,
                'longitude_entree' => $lng,
            ]);
            
            // Add a welcome notification
            \App\Models\Notification::create([
                'utilisateur_id' => auth()->id(),
                'type' => 'info',
                'titre' => 'Pointage Entrée',
                'message' => 'Votre arrivée a été enregistrée à ' . date('H:i', strtotime($now)) . ($lat ? ' avec géolocalisation.' : '.'),
                'lu' => false,
            ]);

            return redirect()->back()->with('success', 'Pointage d\'arrivée enregistré avec succès à ' . date('H:i', strtotime($now)));
        } else if (!$pointage->heure_sortie) {
            // Clock Out
            $pointage->update([
                'heure_sortie' => $now,
                'latitude_sortie' => $lat,
                'longitude_sortie' => $lng,
            ]);
            
            // Add a goodbye notification
            \App\Models\Notification::create([
                'utilisateur_id' => auth()->id(),
                'type' => 'info',
                'titre' => 'Pointage Sortie',
                'message' => 'Votre départ a été enregistré à ' . date('H:i', strtotime($now)) . ($lat ? ' avec géolocalisation.' : '.'),
                'lu' => false,
            ]);

            return redirect()->back()->with('success', 'Pointage de sortie enregistré avec succès à ' . date('H:i', strtotime($now)));
        }

        return redirect()->back()->with('error', 'Vous avez déjà validé votre journée complète de pointage.');
    }

    /**
     * Exporter les pointages en CSV (Excel compatible)
     */
    public function exportCsv(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $pointages = \App\Models\Pointage::with('employe')->whereDate('date', $date)->get();

        $filename = "rapport_presences_{$date}.csv";
        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Matricule', 'Nom', 'Prenom', 'Date', 'Heure Entree', 'Heure Sortie', 'Statut'];

        $callback = function() use ($pointages, $columns) {
            $file = fopen('php://output', 'w');
            // Adding BOM for Excel UTF-8 display
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns, ';'); 

            foreach ($pointages as $p) {
                fputcsv($file, [
                    $p->employe->matricule ?? 'N/A',
                    $p->employe->nom,
                    $p->employe->prenom,
                    $p->date->format('Y-m-d'),
                    $p->heure_entree,
                    $p->heure_sortie,
                    $p->statut
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
