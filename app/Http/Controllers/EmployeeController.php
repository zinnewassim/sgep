<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Departement;
use App\Models\Poste;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function __construct()
    {
        // Permission middleware could also be handled in routes/web.php
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employe::with(['departement', 'poste'])->paginate(10);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departements = Departement::all();
        $postes = Poste::all();
        return view('employees.create', compact('departements', 'postes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:employes,email',
            'telephone' => 'nullable|string|max:20',
            'departement_id' => 'required|exists:departements,id',
            'poste_id' => 'required|exists:poste,id',
            'matricule' => 'required|string|unique:employes,matricule',
            'date_embauche' => 'required|date',
            'genre' => 'required|in:M,F',
            'cin' => 'nullable|string|unique:employes,cin',
        ]);

        $validated['uuid'] = (string) Str::uuid();

        Employe::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employé créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employe $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employe $employee)
    {
        $departements = Departement::all();
        $postes = Poste::all();
        return view('employees.edit', compact('employee', 'departements', 'postes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employe $employee)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:employes,email,' . $employee->id,
            'telephone' => 'nullable|string|max:20',
            'departement_id' => 'required|exists:departements,id',
            'poste_id' => 'required|exists:poste,id',
            'matricule' => 'required|string|unique:employes,matricule,' . $employee->id,
            'date_embauche' => 'required|date',
            'genre' => 'required|in:M,F',
            'cin' => 'nullable|string|unique:employes,cin,' . $employee->id,
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employé mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employe $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employé supprimé avec succès.');
    }
}
