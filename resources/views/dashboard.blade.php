@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <h3 class="text-2xl font-bold text-slate-800 font-outfit">Bonjour, {{ Auth::user()->prenom }} !</h3>
    <p class="text-slate-500">Voici un aperçu de l'activité du personnel aujourd'hui.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Total Employees -->
    <div class="premium-card p-6 flex items-center">
        <div class="flex-shrink-0 w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mr-4">
            <i class="fa-solid fa-users text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Total Employés</p>
            <h4 class="text-2xl font-bold text-slate-800">{{ $stats['total_employees'] }}</h4>
        </div>
    </div>

    <!-- Present Today -->
    <div class="premium-card p-6 flex items-center">
        <div class="flex-shrink-0 w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mr-4">
            <i class="fa-solid fa-user-check text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Présents</p>
            <h4 class="text-2xl font-bold text-slate-800">{{ $stats['present_today'] }}</h4>
        </div>
    </div>

    <!-- Late Today -->
    <div class="premium-card p-6 flex items-center border-l-4 border-amber-400">
        <div class="flex-shrink-0 w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mr-4">
            <i class="fa-solid fa-user-clock text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Retards</p>
            <h4 class="text-2xl font-bold text-slate-800">{{ $stats['late_today'] }}</h4>
        </div>
    </div>

    <!-- Absent Today -->
    <div class="premium-card p-6 flex items-center border-l-4 border-rose-400">
        <div class="flex-shrink-0 w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mr-4">
            <i class="fa-solid fa-user-xmark text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Absents</p>
            <h4 class="text-2xl font-bold text-slate-800">{{ $stats['absent_today'] }}</h4>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Activity Table -->
    <div class="lg:col-span-2">
        <div class="premium-card overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h5 class="font-bold text-slate-800 font-outfit">Activités Récentes de Pointage</h5>
                <a href="{{ route('presence.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">Voir tout <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Employé</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Entrée</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Sortie</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recent_pointages as $pointage)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 mr-3 text-xs font-bold border border-slate-200">
                                            {{ substr($pointage->employe->prenom, 0, 1) }}{{ substr($pointage->employe->nom, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-semibold text-slate-700">{{ $pointage->employe->nom }} {{ $pointage->employe->prenom }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $pointage->date->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-700 text-center">
                                    {{ $pointage->heure_entree ? \Carbon\Carbon::parse($pointage->heure_entree)->format('H:i') : '--:--' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-700 text-center">
                                    {{ $pointage->heure_sortie ? \Carbon\Carbon::parse($pointage->heure_sortie)->format('H:i') : '--:--' }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'present' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                            'retard' => 'bg-amber-50 text-amber-700 border-amber-100',
                                            'absent' => 'bg-rose-50 text-rose-700 border-rose-100',
                                        ];
                                        $class = $statusClasses[$pointage->statut] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $class }}">
                                        {{ ucfirst($pointage->statut) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">
                                    Aucune activité récente à afficher
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions or side info -->
    <div class="lg:col-span-1 space-y-6">
        <div class="premium-card p-6 bg-indigo-600 text-white border-0 overflow-hidden relative group">
            <div class="relative z-10">
                <h5 class="text-lg font-bold mb-2 font-outfit">Enregistrer une présence</h5>
                <p class="text-indigo-100 text-sm mb-6">Ajouter manuellement un pointage pour un employé.</p>
                <a href="{{ route('presence.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-indigo-600 rounded-xl text-sm font-bold hover:bg-indigo-50 transition-colors">
                    Nouveau Pointage <i class="fa-solid fa-plus ml-2"></i>
                </a>
            </div>
            <i class="fa-solid fa-clock-rotate-left absolute -bottom-4 -right-4 text-8xl text-indigo-500/20 transform -rotate-12 group-hover:scale-110 transition-transform duration-500"></i>
        </div>

        <!-- Payroll Widget (Improved) -->
        <div class="premium-card p-6 bg-white overflow-hidden relative border-l-4 border-indigo-500 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                    <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Paie : {{ $stats['payroll_status']['month'] }}</span>
            </div>
            
            <h5 class="font-bold text-slate-800 mb-1 font-outfit">Clôture de la Paie</h5>
            <p class="text-slate-500 text-sm mb-4">
                {{ $stats['payroll_status']['count'] }} sur {{ $stats['payroll_status']['total'] }} bulletins générés ce mois.
            </p>

            <div class="w-full bg-slate-100 rounded-full h-1.5 mb-6">
                <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $stats['payroll_status']['percentage'] }}%"></div>
            </div>

            <button class="w-full flex items-center justify-center px-4 py-2 bg-indigo-50 text-indigo-700 font-bold text-sm rounded-xl hover:bg-indigo-100 transition-colors">
                Générer les bulletins <i class="fa-solid fa-chevron-right ml-2 text-[10px]"></i>
            </button>
        </div>
    </div>
</div>
@endsection
