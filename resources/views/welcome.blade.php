<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FlashQuest - Preparação de Alta Performance</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-300 font-sans min-h-screen flex flex-col">
    
    <nav class="flex justify-between items-center p-6 lg:px-12 bg-slate-900 border-b border-slate-800 shadow-sm sticky top-0 z-50">
        <div class="text-xl font-black text-white tracking-widest uppercase flex items-center gap-2">
            <i class="fa-solid fa-layer-group text-slate-500"></i> FlashQuest
        </div>
        
        <div class="flex gap-4 items-center">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-bold text-slate-400 hover:text-white px-4 py-2 uppercase text-sm tracking-widest transition">Acessar Painel</a>
            @else
                <a href="{{ route('login') }}" class="font-bold text-slate-400 hover:text-white px-4 py-2 uppercase text-sm tracking-widest transition">Entrar</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-white hover:bg-slate-200 text-slate-900 font-bold py-2 px-6 text-sm uppercase tracking-widest transition border border-white rounded">Matrícula</a>
                @endif
            @endauth
        </div>
    </nav>

    <main class="flex-1 flex flex-col items-center justify-center p-6 text-center z-10 relative mt-10">
        <div class="max-w-4xl">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Sistema de Repetição Espaçada</div>
            <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tighter text-white uppercase">
                Preparação de <br/>Alta Performance.
            </h1>
            <p class="text-lg md:text-xl text-slate-400 mb-10 max-w-2xl mx-auto font-medium">
                Metodologia comprovada de cartões de memória. Foque na disciplina e deixe o algoritmo gerenciar suas revisões diárias.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white font-bold text-sm py-4 px-10 uppercase tracking-widest transition flex items-center justify-center gap-2 rounded">
                    Iniciar Preparação
                </a>
            </div>
        </div>

    </main>

    <footer class="bg-slate-950 text-slate-600 py-8 text-center text-xs font-bold uppercase tracking-widest border-t border-slate-900">
        FlashQuest &copy; {{ date('Y') }} - Sistema de Estudo.
    </footer>

</body>
</html>
