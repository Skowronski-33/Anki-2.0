<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FlashQuest') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
            .flip-card { perspective: 1000px; }
            .flip-card-inner { transition: transform 0.6s; transform-style: preserve-3d; }
            .flip-card.flipped .flip-card-inner { transform: rotateY(180deg); }
            .flip-card-front, .flip-card-back { backface-visibility: hidden; }
            .flip-card-back { transform: rotateY(180deg); }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 shadow-xl hidden md:flex flex-col">
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <span class="text-xl font-bold text-white tracking-widest uppercase"><i class="fa-solid fa-layer-group text-slate-400 mr-2"></i> FlashQuest</span>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded transition">
                    <i class="fa-solid fa-chart-line w-6 text-slate-400"></i> <span class="text-sm font-medium uppercase tracking-wide">Painel</span>
                </a>
                <a href="{{ route('decks.index') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded transition">
                    <i class="fa-solid fa-folder w-6 text-slate-400"></i> <span class="text-sm font-medium uppercase tracking-wide">Decks</span>
                </a>
                <a href="{{ route('leaderboard') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded transition">
                    <i class="fa-solid fa-list-ol w-6 text-slate-400"></i> <span class="text-sm font-medium uppercase tracking-wide">Ranking</span>
                </a>
                <a href="{{ route('achievements') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded transition">
                    <i class="fa-solid fa-certificate w-6 text-slate-400"></i> <span class="text-sm font-medium uppercase tracking-wide">Conquistas</span>
                </a>
                <a href="{{ route('profile.show', auth()->user()) }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded transition">
                    <i class="fa-solid fa-user w-6 text-slate-400"></i> <span class="text-sm font-medium uppercase tracking-wide">Perfil</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-y-auto">
            
            <!-- Topbar / Gamification Header -->
            <header class="bg-white border-b border-slate-200 shadow-sm h-16 flex items-center justify-between px-6 shrink-0">
                <div class="flex items-center space-x-4">
                    <!-- Mobile menu button -->
                    <button class="md:hidden text-slate-500 hover:text-slate-900">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <!-- Gamification Status -->
                    <div class="hidden sm:flex items-center space-x-4 bg-slate-50 border border-slate-200 px-4 py-1.5 rounded text-sm font-semibold text-slate-700 tracking-wide uppercase">
                        <div class="flex items-center" title="XP Total">
                            <i class="fa-solid fa-star text-slate-400 mr-2"></i> <span id="nav-xp">{{ auth()->user()->stats->xp_total ?? 0 }}</span> XP
                        </div>
                        <div class="w-px h-4 bg-slate-300"></div>
                        <div class="flex items-center" title="Nível Atual">
                            <i class="fa-solid fa-shield text-slate-400 mr-2"></i> LVL <span id="nav-lvl">{{ auth()->user()->stats->level ?? 1 }}</span>
                        </div>
                        <div class="w-px h-4 bg-slate-300"></div>
                        <div class="flex items-center" title="Ofensiva (Dias Seguidos)">
                            <i class="fa-solid fa-fire text-slate-400 mr-2"></i> <span id="nav-streak">{{ auth()->user()->stats->streak_days ?? 0 }}</span> DIAS
                        </div>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-slate-500 hover:text-slate-900 transition ml-4 uppercase tracking-wide">
                            <i class="fa-solid fa-right-from-bracket mr-1"></i> Sair
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                @yield('content')
                {{ $slot ?? '' }}
            </main>
        </div>
        
        <!-- Micro-animations Script -->
        <script>
            function updateGamificationHeader(xp, level, streak) {
                $('#nav-xp').text(xp).parent().addClass('scale-125 text-green-500 transition').removeClass('text-yellow-500');
                $('#nav-lvl').text(level);
                $('#nav-streak').text(streak);
                setTimeout(() => {
                    $('#nav-xp').parent().removeClass('scale-125 text-green-500').addClass('text-yellow-500');
                }, 500);
            }
        </script>
        @stack('scripts')
    </body>
</html>
