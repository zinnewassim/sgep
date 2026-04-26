@extends('layouts.app')

@section('title', 'Nouvel Employé')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ajouter un Employé</h1>
    <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm me-1"></i> Retour à la liste
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informations de l'employé</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('employees.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="matricule" class="form-label">Matricule</label>
                    <input type="text" name="matricule" id="matricule" class="form-control @error('matricule') is-invalid @enderror" value="{{ old('matricule') }}" required>
                    @error('matricule') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cin" class="form-label">CIN</label>
                    <input type="text" name="cin" id="cin" class="form-control @error('cin') is-invalid @enderror" value="{{ old('cin') }}">
                    @error('cin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                    @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required>
                    @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text" name="telephone" id="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
                    @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="departement_id" class="form-label">Département</label>
                    <select name="departement_id" id="departement_id" class="form-select @error('departement_id') is-invalid @enderror" required>
                        <option value="">Sélectionner un département</option>
                        @foreach($departements as $dept)
                            <option value="{{ $dept->id }}" {{ old('departement_id') == $dept->id ? 'selected' : '' }}>{{ $dept->libelle }}</option>
                        @endforeach
                    </select>
                    @error('departement_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="poste_id" class="form-label">Poste</label>
                    <select name="poste_id" id="poste_id" class="form-select @error('poste_id') is-invalid @enderror" required>
                        <option value="">Sélectionner un poste</option>
                        @foreach($postes as $poste)
                            <option value="{{ $poste->id }}" {{ old('poste_id') == $poste->id ? 'selected' : '' }}>{{ $poste->libelle }}</option>
                        @endforeach
                    </select>
                    @error('poste_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <select name="genre" id="genre" class="form-select @error('genre') is-invalid @enderror" required>
                        <option value="M" {{ old('genre') == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('genre') == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="date_embauche" class="form-label">Date d'embauche</label>
                    <input type="date" name="date_embauche" id="date_embauche" class="form-control @error('date_embauche') is-invalid @enderror" value="{{ old('date_embauche', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="date_naissance" class="form-label">Date de naissance</label>
                    <input type="date" name="date_naissance" id="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance') }}">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
