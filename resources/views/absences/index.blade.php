@extends('layouts.app')

@section('title', 'Gestion des Absences & Congés')

@section('content')

{{-- Page Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Absences & Congés</h1>
        <p class="text-sm text-slate-500 mt-1">Gestion des demandes et suivi des absences</p>
    </div>
    <a href="{{ route('absences.create') }}" 
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md transition-all hover:scale-105">
        <i class="fa-solid fa-plus"></i> Nouvelle Demande
    </a>
</div>

{{-- Main Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    {{-- Card Header --}}
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h2 class="text-sm font-semibold text-indigo-600 flex items-center gap-2">
            <i class="fa-solid fa-calendar-check"></i>
            Liste des absences
        </h2>
        <span class="text-xs text-slate-400">Total: {{ $absences->total() }} demande(s)</span>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm text-left" style="min-width: 800px;">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Employé</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Type / Motif</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Période</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Durée</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Statut</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($absences as $a)
                <tr class="hover:bg-slate-50/70 transition-colors group">
                    {{-- Employé --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm font-bold shadow-sm"
                                 style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                {{ strtoupper(substr($a->employe->nom, 0, 1) . substr($a->employe->prenom, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 leading-tight">{{ $a->employe->nom }} {{ $a->employe->prenom }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $a->employe->matricule }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Type / Motif --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col">
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 w-fit">
                                <i class="fa-solid fa-tag text-[10px]"></i>
                                {{ str_replace('_', ' ', ucfirst($a->type)) }}
                            </span>
                            @if($a->motif)
                            <p class="text-xs text-slate-400 mt-1 italic truncate max-w-[150px]">{{ $a->motif }}</p>
                            @endif
                        </div>
                    </td>

                    {{-- Période --}}
                    <td class="px-6 py-4 whitespace-nowrap text-slate-600 font-medium">
                        <div class="flex items-center gap-2">
                            <span class="text-xs">{{ $a->date_debut->format('d/m/Y') }}</span>
                            <i class="fa-solid fa-arrow-right text-[10px] text-slate-300"></i>
                            <span class="text-xs">{{ $a->date_fin->format('d/m/Y') }}</span>
                        </div>
                    </td>

                    {{-- Durée --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $days = $a->date_debut->diffInDays($a->date_fin) + 1;
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                            <i class="fa-regular fa-calendar-days"></i>
                            {{ $days }} jour(s)
                        </span>
                    </td>

                    {{-- Statut --}}
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @php
                            $statusConfig = [
                                'approuve' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100', 'label' => 'Approuvé', 'dot' => 'bg-emerald-500'],
                                'en_attente' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-100', 'label' => 'En attente', 'dot' => 'bg-amber-500'],
                                'refuse' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-100', 'label' => 'Refusé', 'dot' => 'bg-rose-500'],
                                'annule' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-500', 'border' => 'border-slate-200', 'label' => 'Annulé', 'dot' => 'bg-slate-400'],
                            ];
                            $config = $statusConfig[$a->statut] ?? $statusConfig['en_attente'];
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
                            {{ $config['label'] }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('absences.show', $a->id) ?? '#' }}" 
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-sky-600 bg-sky-50 hover:bg-sky-100 border border-sky-100 transition-all"
                               title="Détails">
                                <i class="fa-solid fa-eye"></i>
                                <span>Détails</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                <i class="fa-solid fa-calendar-day text-2xl text-slate-300"></i>
                            </div>
                            <p class="text-slate-500 font-medium">Aucune absence enregistrée</p>
                            <p class="text-xs text-slate-400">Toutes les demandes de congés et d'absences apparaîtront ici</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($absences->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
        {{ $absences->links() }}
    </div>
    @endif
</div>

@endsection
