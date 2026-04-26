@extends('layouts.app')

@section('title', 'Détails Employé')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profil de l'Employé</h1>
    <div>
        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning shadow-sm text-white">
            <i class="fas fa-edit fa-sm me-1"></i> Modifier
        </a>
        <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm me-1"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name={{ $employee->nom }}+{{ $employee->prenom }}&size=150&background=4e73df&color=ffffff" class="rounded-circle mb-3" alt="Avatar">
                <h4 class="font-weight-bold">{{ $employee->nom }} {{ $employee->prenom }}</h4>
                <p class="text-muted">{{ $employee->poste->libelle }}</p>
                <div class="badge bg-primary px-3 py-2">{{ $employee->matricule }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informations Personnelles</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Email:</div>
                    <div class="col-sm-8">{{ $employee->email }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Téléphone:</div>
                    <div class="col-sm-8">{{ $employee->telephone ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Département:</div>
                    <div class="col-sm-8">{{ $employee->departement->libelle }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">CIN:</div>
                    <div class="col-sm-8">{{ $employee->cin ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Genre:</div>
                    <div class="col-sm-8">{{ $employee->genre == 'M' ? 'Masculin' : 'Féminin' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Date d'embauche:</div>
                    <div class="col-sm-8">{{ \Carbon\Carbon::parse($employee->date_embauche)->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
