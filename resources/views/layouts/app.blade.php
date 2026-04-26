<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SGEP') }} - @yield('title', 'Tableau de Bord')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 (Legacy Support) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Simple-DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .font-outfit {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .sidebar {
            background: linear-gradient(180deg, #0f172a 0%, #020617 100%);
        }
        .sidebar-item-active {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(99, 102, 241, 0.15) 100%);
            border-right: 3px solid #8b5cf6;
            color: #ffffff !important;
            font-weight: 600;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
        .premium-shadow {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        }
        .premium-card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .premium-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            border-color: rgba(139, 92, 246, 0.3);
        }
    </style>
</head>
<body class="h-full overflow-hidden">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-slate-50">
        <!-- Sidebar for Mobile -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 flex md:hidden" role="dialog" aria-modal="true" style="display: none;">
            <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm" @click="sidebarOpen = false"></div>
            <div class="relative flex flex-col flex-1 w-full max-w-xs sidebar text-white border-r border-slate-800">
                <div class="flex items-center justify-between h-16 px-6 border-b border-slate-800">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.png') }}" alt="SGEP Logo" class="w-8 h-8 rounded-lg shadow-lg">
                        <span class="text-2xl font-bold tracking-tight text-white font-outfit">SGEP</span>
                    </div>
                    <button @click="sidebarOpen = false" class="p-2 -mr-2 text-slate-400 hover:text-white focus:outline-none">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto w-full">
                    <!-- Nav items repeat here for mobile -->
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium transition-colors rounded-xl group {{ Request::is('dashboard*') ? 'sidebar-item-active' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <i class="mr-3 text-lg fa-solid fa-gauge-high {{ Request::is('dashboard*') ? 'text-white' : 'text-slate-400 group-hover:text-violet-400' }}"></i> Tableau de bord
                    </a>
                    <a href="{{ route('calendar.index') }}" class="flex items-center px-4 py-3 text-sm font-medium transition-colors rounded-xl group {{ Request::is('calendar*') ? 'sidebar-item-active' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <i class="mr-3 text-lg fa-solid fa-calendar-alt {{ Request::is('calendar*') ? 'text-white' : 'text-slate-400 group-hover:text-violet-400' }}"></i> Calendrier d'Équipe
                    </a>
                    @permission('manage-employees')
                    <div x-data="{ open: {{ Request::is('employees*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 text-sm font-medium transition-all rounded-xl group text-slate-300 hover:bg-slate-800/50 hover:text-white">
                            <div class="flex items-center">
                                <i class="mr-3 text-lg text-center fa-solid fa-users-gear text-slate-400 group-hover:text-violet-400"></i>
                                Ressources Humaines
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="open" x-collapse x-cloak class="pl-11 pr-2 space-y-1 mt-1">
                            <a href="{{ route('employees.index') }}" class="flex items-center px-3 py-2 text-sm font-medium transition-all rounded-lg group {{ Request::is('employees*') ? 'text-violet-400 bg-violet-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-3 {{ Request::is('employees*') ? 'bg-violet-500' : 'bg-slate-600 group-hover:bg-violet-400' }}"></span>
                                Liste des employés
                            </a>
                        </div>
                    </div>
                    @endpermission
                    @permission('manage-presence')
                    <div x-data="{ open: {{ Request::is('presence*') || Request::is('absences*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 text-sm font-medium transition-all rounded-xl group text-slate-300 hover:bg-slate-800/50 hover:text-white">
                            <div class="flex items-center">
                                <i class="mr-3 text-lg text-center fa-solid fa-layer-group text-slate-400 group-hover:text-violet-400"></i>
                                Pointages & Absences
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="open" x-collapse x-cloak class="pl-11 pr-2 space-y-1 mt-1">
                            <a href="{{ route('presence.index') }}" class="flex items-center px-3 py-2 text-sm font-medium transition-all rounded-lg group {{ Request::is('presence*') ? 'text-violet-400 bg-violet-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-3 {{ Request::is('presence*') ? 'bg-violet-500' : 'bg-slate-600 group-hover:bg-violet-400' }}"></span>
                                Historique présences
                            </a>
                            <a href="{{ route('absences.index') }}" class="flex items-center px-3 py-2 text-sm font-medium transition-all rounded-lg group {{ Request::is('absences*') ? 'text-violet-400 bg-violet-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-3 {{ Request::is('absences*') ? 'bg-violet-500' : 'bg-slate-600 group-hover:bg-violet-400' }}"></span>
                                Validations absences
                            </a>
                        </div>
                    </div>
                    @endpermission
                </nav>
            </div>
        </div>

        <!-- Static Sidebar for Desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0 border-r border-slate-800 sidebar shadow-2xl">
            <div class="flex flex-col flex-grow pt-5 overflow-y-auto w-full">
                <div class="flex items-center flex-shrink-0 px-6 mb-8 mt-2">
                    <div class="flex items-center space-x-3 group cursor-pointer">
                        <div class="relative flex items-center justify-center w-10 h-10 rounded-xl overflow-hidden shadow-lg transition-transform duration-300 group-hover:scale-105">
                            <img src="{{ asset('images/logo.png') }}" alt="SGEP Logo" class="w-full h-full object-cover">
                            <div class="absolute inset-0 border border-white/10 rounded-xl"></div>
                        </div>
                        <span class="text-2xl font-bold tracking-tight font-outfit text-white">SGEP</span>
                    </div>
                </div>
                <div class="flex flex-col flex-1 px-4 space-y-1">
                    <p class="px-4 mb-2 text-xs font-semibold tracking-wider uppercase text-slate-400">Principal</p>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium transition-all rounded-xl group {{ Request::is('dashboard*') ? 'sidebar-item-active' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <i class="mr-3 w-5 text-center fa-solid fa-gauge-high {{ Request::is('dashboard*') ? 'text-white' : 'text-slate-400 group-hover:text-violet-400' }}"></i> 
                        Tableau de bord
                    </a>
                    
                    <a href="{{ route('calendar.index') }}" class="flex items-center px-4 py-2.5 mt-1 text-sm font-medium transition-all rounded-xl group {{ Request::is('calendar*') ? 'sidebar-item-active' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <i class="mr-3 w-5 text-center fa-solid fa-calendar-alt {{ Request::is('calendar*') ? 'text-white' : 'text-slate-400 group-hover:text-violet-400' }}"></i> 
                        Calendrier d'Équipe
                    </a>

                    @permission('manage-employees')
                    <p class="px-4 mt-6 mb-2 text-xs font-semibold tracking-wider uppercase text-slate-500">Personnel</p>
                    <div x-data="{ open: {{ Request::is('employees*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2.5 text-sm font-medium transition-all rounded-xl group text-slate-300 hover:bg-slate-800/50 hover:text-white">
                            <div class="flex items-center">
                                <i class="mr-3 w-5 text-center fa-solid fa-users-gear text-slate-400 group-hover:text-violet-400"></i>
                                Ressources Humaines
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 text-slate-400" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="open" x-collapse x-cloak class="pl-11 pr-2 space-y-1 mt-1">
                            <a href="{{ route('employees.index') }}" class="flex items-center px-3 py-2 text-sm font-medium transition-all rounded-lg group {{ Request::is('employees*') ? 'text-violet-400 bg-violet-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-3 {{ Request::is('employees*') ? 'bg-violet-500' : 'bg-slate-600 group-hover:bg-violet-400' }}"></span>
                                Liste des employés
                            </a>
                        </div>
                    </div>
                    @endpermission

                    @permission('manage-presence')
                    <p class="px-4 mt-6 mb-2 text-xs font-semibold tracking-wider uppercase text-slate-500">Opérations</p>
                    <div x-data="{ open: {{ Request::is('presence*') || Request::is('absences*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2.5 text-sm font-medium transition-all rounded-xl group text-slate-300 hover:bg-slate-800/50 hover:text-white">
                            <div class="flex items-center">
                                <i class="mr-3 w-5 text-center fa-solid fa-layer-group text-slate-400 group-hover:text-violet-400"></i>
                                Pointages & Absences
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 text-slate-400" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="open" x-collapse x-cloak class="pl-11 pr-2 space-y-1 mt-1">
                            <a href="{{ route('presence.index') }}" class="flex items-center px-3 py-2 text-sm font-medium transition-all rounded-lg group {{ Request::is('presence*') ? 'text-violet-400 bg-violet-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-3 {{ Request::is('presence*') ? 'bg-violet-500' : 'bg-slate-600 group-hover:bg-violet-400' }}"></span>
                                Historique présences
                            </a>
                            <a href="{{ route('absences.index') }}" class="flex items-center px-3 py-2 text-sm font-medium transition-all rounded-lg group {{ Request::is('absences*') ? 'text-violet-400 bg-violet-500/10' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-3 {{ Request::is('absences*') ? 'bg-violet-500' : 'bg-slate-600 group-hover:bg-violet-400' }}"></span>
                                Validations absences
                            </a>
                        </div>
                    </div>
                    @endpermission
                    
                    <div class="mt-auto pb-6">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm font-medium transition-all rounded-xl text-slate-400 hover:bg-rose-500/10 hover:text-rose-400 group">
                                <i class="mr-3 w-5 text-center fa-solid fa-right-from-bracket text-slate-500 group-hover:text-rose-400"></i>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col flex-1 overflow-hidden md:pl-64">
            <!-- Header -->
            <header class="sticky top-0 z-10 flex h-16 flex-shrink-0 glass-header shadow-sm">
                <button @click="sidebarOpen = true" class="px-4 border-r border-slate-200 text-slate-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-violet-500 md:hidden">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <div class="flex justify-between flex-1 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center flex-1">
                        <h2 class="text-xl font-bold text-slate-800 font-outfit tracking-tight">@yield('title')</h2>
                    </div>
                    <div class="flex items-center ml-4 md:ml-6 space-x-4">
                        <!-- Quick Punch Action — only for users linked to an employee profile -->
                        @if(Auth::check() && Auth::user()->employe)
                        <div x-data="geoPunch()" class="relative hidden sm:flex items-center">
                            <form x-ref="form" action="{{ route('presence.quick_punch') }}" method="POST">
                                @csrf
                                <input type="hidden" name="latitude" x-model="lat">
                                <input type="hidden" name="longitude" x-model="lng">
                                <button type="button" @click="punch" :disabled="loading" class="flex items-center space-x-2 px-3 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-xl shadow-md transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fa-solid fa-fingerprint text-lg" :class="loading ? 'animate-spin fa-spinner' : 'animate-pulse'"></i>
                                    <span class="text-sm font-semibold tracking-wide" x-text="loading ? 'Localisation...' : 'Pointage Rapide'">Pointage Rapide</span>
                                </button>
                            </form>
                        </div>
                        @endif

                        <!-- Notifications Dropdown -->
                        <div x-data="{ notifOpen: false }" class="relative">
                            <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="relative p-2 text-slate-400 transition-colors hover:text-slate-500 hover:bg-slate-50 rounded-lg">
                                <i class="fa-regular fa-bell text-xl"></i>
                                @if(Auth::check() && Auth::user()->unreadNotifications()->count() > 0)
                                    <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                                    </span>
                                @endif
                            </button>

                            <!-- Dropdown panel -->
                            <div x-cloak x-show="notifOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50 px-0">
                                <div class="p-4 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                                    <h3 class="text-sm font-bold tracking-tight text-slate-800">Notifications</h3>
                                    @if(Auth::check() && Auth::user()->unreadNotifications()->count() > 0)
                                    <form action="{{ route('notifications.readAll') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">Tout marquer comme lu</button>
                                    </form>
                                    @endif
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    @forelse(Auth::check() ? Auth::user()->unreadNotifications()->latest()->take(5)->get() : [] as $notification)
                                        <div class="p-4 border-b border-slate-50 hover:bg-slate-50 transition-colors group relative">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 mt-0.5">
                                                    @if($notification->type == 'info')
                                                        <i class="fa-solid fa-circle-info text-blue-500"></i>
                                                    @elseif($notification->type == 'alert')
                                                        <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                                                    @else
                                                        <i class="fa-solid fa-bell text-indigo-500"></i>
                                                    @endif
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <p class="text-sm font-semibold text-slate-800">{{ $notification->titre }}</p>
                                                    <p class="text-xs text-slate-500 mt-1">{{ $notification->message }}</p>
                                                    <p class="text-xs text-slate-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-8 text-center">
                                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-50 mb-3">
                                                <i class="fa-regular fa-bell-slash text-slate-400 text-lg"></i>
                                            </div>
                                            <p class="text-sm text-slate-500 font-medium">Aucune nouvelle notification</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Profile dropdown -->
                        <div class="relative ml-3 group">
                            <div class="flex items-center space-x-3 cursor-pointer p-1.5 rounded-xl transition-all hover:bg-slate-100">
                                <span class="hidden lg:block text-right">
                                    <p class="text-sm font-bold text-slate-800 leading-none mb-1">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</p>
                                    <p class="text-xs font-semibold text-violet-600 uppercase tracking-tighter">{{ Auth::user()->roles->first()->display_name ?? 'Utilisateur' }}</p>
                                </span>
                                <img class="w-10 h-10 rounded-xl border-2 border-white premium-shadow" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nom . ' ' . Auth::user()->prenom) }}&background=8b5cf6&color=fff&bold=true" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none bg-slate-50/50" 
                  x-data="{ pageLoaded: false }" 
                  x-init="setTimeout(() => pageLoaded = true, 100)" 
                  x-show="pageLoaded" 
                  x-transition:enter="transition ease-out duration-500 transform" 
                  x-transition:enter-start="opacity-0 translate-y-8" 
                  x-transition:enter-end="opacity-100 translate-y-0"
                  x-cloak>
                <div class="py-8">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <!-- Hidden session data for SweetAlert2 -->
                        @if(session('success'))
                            <div id="flash-success" data-message="{{ session('success') }}" class="hidden"></div>
                        @endif
                        @if(session('error'))
                            <div id="flash-error" data-message="{{ session('error') }}" class="hidden"></div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS (Legacy) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 & Simple-DataTables JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

    <script>
        // Initialize SweetAlert2 for Flash Messages
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            const successFlash = document.getElementById('flash-success');
            if (successFlash) {
                Toast.fire({
                    icon: 'success',
                    title: successFlash.getAttribute('data-message')
                });
            }

            const errorFlash = document.getElementById('flash-error');
            if (errorFlash) {
                Toast.fire({
                    icon: 'error',
                    title: errorFlash.getAttribute('data-message')
                });
            }

            // Initialize Simple-DataTables for any table with class .datatable
            const dataTables = document.querySelectorAll(".datatable");
            dataTables.forEach(table => {
                new simpleDatatables.DataTable(table, {
                    searchable: true,
                    fixedHeight: true,
                    labels: {
                        placeholder: "Rechercher...",
                        perPage: "éléments par page",
                        noRows: "Aucune entrée trouvée",
                        info: "Affichage de {start} à {end} sur {rows} entrées",
                    }
                });
            });
        });
    </script>
    
    <!-- Alpine JS -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('geoPunch', () => ({
                loading: false,
                lat: null,
                lng: null,
                punch() {
                    this.loading = true;
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                this.lat = position.coords.latitude;
                                this.lng = position.coords.longitude;
                                this.$refs.form.submit();
                            },
                            (error) => {
                                console.warn('Geolocation blocked or failed. Proceeding without it.');
                                this.$refs.form.submit();
                            },
                            { timeout: 5000, maximumAge: 0 }
                        );
                    } else {
                        // Geolocation not supported, submit anyway
                        this.$refs.form.submit();
                    }
                }
            }))
        })
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
