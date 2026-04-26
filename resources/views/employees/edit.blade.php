@extends('layouts.app')

@section('title', 'Modifier Employé')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Modifier l'Employé : {{ $employee->nom }}</h1>
    <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm me-1"></i> Retour à la liste
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Mettre à jour les informations</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('employees.update', $employee) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="matricule" class="form-label">Matricule</label>
                    <input type="text" name="matricule" id="matricule" class="form-control @error('matricule') is-invalid @enderror" value="{{ old('matricule', $employee->matricule) }}" required>
                    @error('matricule') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cin" class="form-label">CIN</label>
                    <input type="text" name="cin" id="cin" class="form-control @error('cin') is-invalid @enderror" value="{{ old('cin', $employee->cin) }}">
                    @error('cin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $employee->nom) }}" required>
                    @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $employee->prenom) }}" required>
                    @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $employee->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text" name="telephone" id="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone', $employee->telephone) }}">
                    @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="departement_id" class="form-label">Département</label>
                    <select name="departement_id" id="departement_id" class="form-select @error('departement_id') is-invalid @enderror" required>
                        @foreach($departements as $dept)
                            <option value="{{ $dept->id }}" {{ old('departement_id', $employee->departement_id) == $dept->id ? 'selected' : '' }}>{{ $dept->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="poste_id" class="form-label">Poste</label>
                    <select name="poste_id" id="poste_id" class="form-select @error('poste_id') is-invalid @enderror" required>
                        @foreach($postes as $poste)
                            <option value="{{ $poste->id }}" {{ old('poste_id', $employee->poste_id) == $poste->id ? 'selected' : '' }}>{{ $poste->libelle }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <select name="genre" id="genre" class="form-select" required>
                        <option value="M" {{ old('genre', $employee->genre) == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('genre', $employee->genre) == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="date_embauche" class="form-label">Date d'embauche</label>
                    <input type="date" name="date_embauche" id="date_embauche" class="form-control" value="{{ old('date_embauche', $employee->date_embauche) }}" required>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-warning px-4 text-white">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
