<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>FlashQuest</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,600,800,900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-300 flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 border-r border-slate-800 hidden md:flex flex-col z-20 shrink-0">
            <div class="h-20 flex items-center px-6 border-b border-slate-800">
                <div class="text-xl font-black text-white tracking-widest uppercase flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-slate-500"></i> FQ
                </div>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded transition font-bold uppercase tracking-widest text-sm">
                    <i class="fa-solid fa-chart-pie w-6 opacity-70"></i> Painel
                </a>
                <a href="{{ route('decks.index') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded transition font-bold uppercase tracking-widest text-sm">
                    <i class="fa-solid fa-folder w-6 opacity-70"></i> Decks
                </a>
                <a href="{{ route('leaderboard') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded transition font-bold uppercase tracking-widest text-sm">
                    <i class="fa-solid fa-list-ol w-6 opacity-70"></i> Ranking
                </a>
                <a href="{{ route('stats.index') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded transition font-bold uppercase tracking-widest text-sm">
                    <i class="fa-solid fa-chart-line w-6 opacity-70"></i> Estatísticas
                </a>
                <a href="{{ route('achievements') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded transition font-bold uppercase tracking-widest text-sm">
                    <i class="fa-solid fa-certificate w-6 opacity-70"></i> Conquistas
                </a>
                <a href="{{ route('profile.show', auth()->user()) }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded transition font-bold uppercase tracking-widest text-sm">
                    <i class="fa-solid fa-user w-6 opacity-70"></i> Perfil
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-y-auto relative bg-slate-950">
            
            <!-- Topbar / Gamification Header -->
            <header class="bg-slate-900 border-b border-slate-800 h-20 flex items-center justify-between px-6 shrink-0 z-30 sticky top-0">
                <div class="flex items-center space-x-4">
                    <!-- Mobile menu button -->
                    <button class="md:hidden text-slate-400 hover:text-white bg-slate-800 p-2 rounded">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <!-- Gamification Status -->
                    <div class="hidden sm:flex items-center bg-slate-950 border border-slate-800 p-1 rounded">
                        <div class="flex items-center px-4 py-1.5" title="XP Total">
                            <i class="fa-solid fa-star text-slate-600 text-xs mr-2"></i>
                            <span id="nav-xp" class="text-white font-bold">{{ auth()->user()->stats->xp_total ?? 0 }}</span> <span class="text-slate-500 text-xs ml-1 font-bold uppercase tracking-widest">XP</span>
                        </div>
                        <div class="w-px h-6 bg-slate-800"></div>
                        <div class="flex items-center px-4 py-1.5" title="Nível Atual">
                            <i class="fa-solid fa-shield text-slate-600 text-xs mr-2"></i>
                            <span class="text-slate-500 text-xs mr-1 font-bold uppercase tracking-widest">LVL</span> <span id="nav-lvl" class="text-white font-bold">{{ auth()->user()->stats->level ?? 1 }}</span>
                        </div>
                        <div class="w-px h-6 bg-slate-800"></div>
                        <div class="flex items-center px-4 py-1.5" title="Ofensiva (Dias Seguidos)">
                            <i class="fa-solid fa-fire text-slate-600 text-xs mr-2"></i>
                            <span id="nav-streak" class="text-white font-bold">{{ auth()->user()->stats->streak_days ?? 0 }}</span> <span class="text-slate-500 text-xs ml-1 font-bold uppercase tracking-widest">DIAS</span>
                        </div>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-white hover:bg-slate-800 px-4 py-2 rounded transition">
                            <i class="fa-solid fa-power-off mr-2 opacity-70"></i> Sair
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 lg:p-10 relative z-10">
                @if (session('success'))
                    <div class="mb-6 bg-slate-900 border border-slate-700 text-white p-4 rounded text-sm font-bold shadow-sm flex items-center">
                        <i class="fa-solid fa-check text-slate-400 mr-3 text-lg"></i> {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 bg-slate-900 border border-red-900 text-red-400 p-4 rounded text-sm font-bold shadow-sm flex items-center">
                        <i class="fa-solid fa-triangle-exclamation mr-3 text-lg"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
        
        @stack('scripts')
        <script>
            function updateGamificationHeader(xp, level, streak) {
                $('#nav-xp').text(xp);
                $('#nav-lvl').text(level);
                $('#nav-streak').text(streak);
            }
        </script>
    </body>
</html>
