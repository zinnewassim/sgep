<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absences = Absence::with('employe')->paginate(10);
        return view('absences.index', compact('absences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employe::all();
        return view('absences.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'type' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'statut' => 'required|in:en_attente,approuve,refuse,annule',
        ]);

        Absence::create($validated);

        return redirect()->route('absences.index')->with('success', 'Absence enregistrée avec succès.');
    }
}
