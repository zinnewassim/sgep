@extends('layouts.app')

@section('title', 'Nouvelle Absence')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Enregistrer une Absence</h1>
    <a href="{{ route('absences.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm me-1"></i> Retour
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('absences.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="employe_id" class="form-label">Employé</label>
                    <select name="employe_id" id="employe_id" class="form-select" required>
                        <option value="">Sélectionner un employé</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->nom }} {{ $emp->prenom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">Type d'absence</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="conge_paye">Congé payé</option>
                        <option value="conge_maladie">Congé maladie</option>
                        <option value="absence_justifiee">Absence justifiée</option>
                        <option value="absence_injustifiee">Absence injustifiée</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="date_debut" class="form-label">Date de début</label>
                    <input type="date" name="date_debut" id="date_debut" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="date_fin" class="form-label">Date de fin</label>
                    <input type="date" name="date_fin" id="date_fin" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select name="statut" id="statut" class="form-select" required>
                        <option value="en_attente">En attente</option>
                        <option value="approuve">Approuvé</option>
                        <option value="refuse">Refusé</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
