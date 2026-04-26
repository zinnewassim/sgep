<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Pointage;
use App\Models\Absence;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $today = Carbon::today();
        
        $stats = [
            'total_employees' => Employe::count(),
            'present_today' => Pointage::where('date', $today)->where('statut', 'present')->count(),
            'absent_today' => Pointage::where('date', $today)->where('statut', 'absent')->count() + Absence::where('date_debut', '<=', $today)->where('date_fin', '>=', $today)->count(),
            'late_today' => Pointage::where('date', $today)->where('statut', 'retard')->count(),
        ];

        // Recent activity
        $recent_pointages = Pointage::with('employe')->orderBy('created_at', 'desc')->take(5)->get();

        // Payroll stats
        $payroll_month = Carbon::now()->subMonth()->month;
        $payroll_year = Carbon::now()->subMonth()->year;
        $payrolls_generated = \App\Models\Paie::where('mois', $payroll_month)->where('annee', $payroll_year)->count();
        $total_to_generate = \App\Models\Employe::count();
        
        $stats['payroll_status'] = [
            'month' => Carbon::now()->subMonth()->translatedFormat('F'),
            'count' => $payrolls_generated,
            'total' => $total_to_generate,
            'percentage' => $total_to_generate > 0 ? round(($payrolls_generated / $total_to_generate) * 100) : 0
        ];

        return view('dashboard', compact('stats', 'recent_pointages'));
    }
}
