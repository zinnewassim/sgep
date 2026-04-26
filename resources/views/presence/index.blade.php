@extends('layouts.app')

@section('title', 'Historique des Présences')

@section('content')

{{-- Page Header --}}
<div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Présences</h1>
        <p class="text-sm text-slate-500 mt-1">Suivi quotidien des pointages et retards</p>
    </div>
    <div class="flex items-center gap-3">
        <form action="{{ route('presence.index') }}" method="GET" class="flex items-center gap-2">
            <input type="date" name="date" 
                   class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                   value="{{ $date }}" onchange="this.form.submit()">
        </form>
        
        <a href="{{ route('presence.export', ['date' => $date]) }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-md transition-all hover:scale-105">
            <i class="fa-solid fa-file-csv"></i> Excel/CSV
        </a>
        
        <a href="{{ route('presence.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md transition-all hover:scale-105">
            <i class="fa-solid fa-plus"></i> Enregistrer
        </a>
    </div>
</div>

{{-- Main Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    {{-- Card Header --}}
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h2 class="text-sm font-semibold text-indigo-600 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left"></i>
            Pointages du {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
        </h2>
        <span class="text-xs text-slate-400">Total: {{ count($pointages) }} enregistrement(s)</span>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm text-left" style="min-width: 800px;">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Employé</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Arrivée</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Départ</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Durée</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pointages as $p)
                <tr class="hover:bg-slate-50/70 transition-colors group">
                    {{-- Employé --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm font-bold shadow-sm"
                                 style="background: linear-gradient(135deg, #0ea5e9, #2563eb);">
                                {{ strtoupper(substr($p->employe->nom, 0, 1) . substr($p->employe->prenom, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 leading-tight">{{ $p->employe->nom }} {{ $p->employe->prenom }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($p->date)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Arrivée --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2 text-slate-700">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <i class="fa-solid fa-right-to-bracket text-xs"></i>
                            </div>
                            <span class="font-medium font-mono text-sm">{{ $p->heure_entree ? \Carbon\Carbon::parse($p->heure_entree)->format('H:i') : '--:--' }}</span>
                        </div>
                    </td>

                    {{-- Départ --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2 text-slate-700">
                            <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600">
                                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                            </div>
                            <span class="font-medium font-mono text-sm">{{ $p->heure_sortie ? \Carbon\Carbon::parse($p->heure_sortie)->format('H:i') : '--:--' }}</span>
                        </div>
                    </td>

                    {{-- Durée --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($p->heure_entree && $p->heure_sortie)
                            @php
                                $start = \Carbon\Carbon::parse($p->heure_entree);
                                $end = \Carbon\Carbon::parse($p->heure_sortie);
                                $diff = $start->diff($end);
                            @endphp
                            <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">
                                {{ $diff->format('%hh %Im') }}
                            </span>
                        @else
                            <span class="text-xs text-slate-300 italic">En cours...</span>
                        @endif
                    </td>

                    {{-- Statut --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusConfig = [
                                'present' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100', 'label' => 'Présent', 'dot' => 'bg-emerald-500'],
                                'retard' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-100', 'label' => 'Retard', 'dot' => 'bg-amber-500'],
                                'absent' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-100', 'label' => 'Absent', 'dot' => 'bg-rose-500'],
                                'demi_journee' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-100', 'label' => '1/2 Journée', 'dot' => 'bg-blue-500'],
                            ];
                            $config = $statusConfig[$p->statut] ?? $statusConfig['present'];
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
                            {{ $config['label'] }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('presence.create', ['employe_id' => $p->employe_id, 'date' => $p->date]) }}" 
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 transition-all"
                               title="Modifier">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Editer</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                <i class="fa-solid fa-calendar-xmark text-2xl text-slate-300"></i>
                            </div>
                            <p class="text-slate-500 font-medium">Aucun pointage trouvé pour cette date</p>
                            <p class="text-xs text-slate-400">Veuillez sélectionner une autre date ou enregistrer un nouveau pointage</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
