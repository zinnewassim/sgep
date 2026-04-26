@extends('layouts.app')

@section('title', 'Liste des Employés')

@section('content')

{{-- Page Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Employés</h1>
        <p class="text-sm text-slate-500 mt-1">{{ $employees->total() }} employé(s) au total</p>
    </div>
    @permission('manage-employees')
    <a href="{{ route('employees.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md transition-all hover:scale-105">
        <i class="fa-solid fa-plus"></i> Nouvel Employé
    </a>
    @endpermission
</div>

{{-- Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    {{-- Card Header --}}
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h2 class="text-sm font-semibold text-indigo-600 flex items-center gap-2">
            <i class="fa-solid fa-users"></i>
            Tous les employés
        </h2>
        <span class="text-xs text-slate-400">Mise à jour en temps réel</span>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm text-left" style="min-width: 700px;">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Matricule</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Employé</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Département</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Poste</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($employees as $emp)
                <tr class="hover:bg-slate-50/70 transition-colors group">
                    {{-- Matricule --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                            #{{ $emp->matricule }}
                        </span>
                    </td>

                    {{-- Employee Name + Avatar --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm font-bold shadow-sm flex-shrink-0"
                                 style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                                {{ strtoupper(substr($emp->nom, 0, 1) . substr($emp->prenom, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 leading-tight">{{ $emp->nom }} {{ $emp->prenom }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $emp->email }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Département --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                            <i class="fa-solid fa-building text-xs"></i>
                            {{ $emp->departement->libelle ?? '—' }}
                        </span>
                    </td>

                    {{-- Poste --}}
                    <td class="px-6 py-4 whitespace-nowrap text-slate-600 text-sm">
                        {{ $emp->poste->libelle ?? '—' }}
                    </td>

                    {{-- Statut --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if(($emp->statut ?? 'actif') === 'actif')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Actif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                Inactif
                            </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('employees.show', $emp) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-sky-600 bg-sky-50 hover:bg-sky-100 border border-sky-100 transition-all"
                               title="Voir détails">
                                <i class="fa-solid fa-eye"></i>
                                <span>Détails</span>
                            </a>
                            @permission('manage-employees')
                            <a href="{{ route('employees.edit', $emp) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-amber-600 bg-amber-50 hover:bg-amber-100 border border-amber-100 transition-all"
                               title="Modifier">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Modifier</span>
                            </a>
                            <form action="{{ route('employees.destroy', $emp) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Supprimer {{ $emp->nom }} {{ $emp->prenom }} ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-100 transition-all"
                                        title="Supprimer">
                                    <i class="fa-solid fa-trash-can"></i>
                                    <span>Supprimer</span>
                                </button>
                            </form>
                            @endpermission
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                <i class="fa-solid fa-users text-2xl text-slate-300"></i>
                            </div>
                            <p class="text-slate-500 font-medium">Aucun employé trouvé</p>
                            <p class="text-xs text-slate-400">Commencez par ajouter un nouvel employé</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($employees->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
        {{ $employees->links() }}
    </div>
    @endif
</div>

@endsection
