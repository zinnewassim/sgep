<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\AbsenceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth', 'check.session'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:view-dashboard');
    
    // Management Routes (Admin/HR only)
    Route::middleware(['permission:manage-employees'])->group(function () {
        Route::resource('employees', EmployeeController::class);
    });

    Route::middleware(['permission:manage-presence'])->group(function () {
        Route::get('/presence', [PresenceController::class, 'index'])->name('presence.index');
        Route::get('/presence/export', [PresenceController::class, 'exportCsv'])->name('presence.export');
        Route::get('/presence/create', [PresenceController::class, 'create'])->name('presence.create');
        Route::post('/presence', [PresenceController::class, 'store'])->name('presence.store');
    });

    // Absences (Management restricted to handle, but maybe all can view their own?)
    Route::middleware(['permission:manage-presence'])->group(function () {
        Route::resource('absences', AbsenceController::class);
    });
    
    // Quick features and actions
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::post('/quick-pointage', [PresenceController::class, 'quickPunch'])->name('presence.quick_punch');

    // Calendar & Full events overview
    Route::get('/calendar', [\App\Http\Controllers\CalendarController::class, 'index'])->name('calendar.index')->middleware('permission:view-dashboard');
    Route::get('/api/calendar/events', [\App\Http\Controllers\CalendarController::class, 'getEvents'])->name('calendar.events')->middleware('permission:view-dashboard');
});
