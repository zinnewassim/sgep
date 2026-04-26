@extends('layouts.app')

@section('title', 'Nouveau Pointage')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Enregistrer un Pointage</h1>
    <a href="{{ route('presence.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm me-1"></i> Retour
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('presence.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="employe_id" class="form-label">Employé</label>
                    <select name="employe_id" id="employe_id" class="form-select" required>
                        <option value="">Sélectionner un employé</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ request('employe_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->nom }} {{ $emp->prenom }} ({{ $emp->matricule }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ request('date', date('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="heure_entree" class="form-label">Heure d'arrivée</label>
                    <input type="time" name="heure_entree" id="heure_entree" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="heure_sortie" class="form-label">Heure de départ</label>
                    <input type="time" name="heure_sortie" id="heure_sortie" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select name="statut" id="statut" class="form-select" required>
                        <option value="present">Présent</option>
                        <option value="retard">Retard</option>
                        <option value="absent">Absent</option>
                        <option value="demi_journee">Demi-journée</option>
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
