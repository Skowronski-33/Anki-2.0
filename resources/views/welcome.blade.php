<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
<body class="antialiased bg-slate-50 text-slate-900 font-sans min-h-screen flex flex-col">
    
    <nav class="flex justify-between items-center p-6 lg:px-12 bg-white border-b border-slate-200 shadow-sm sticky top-0 z-50">
        <div class="text-xl font-black text-slate-900 tracking-widest uppercase flex items-center gap-2">
            <i class="fa-solid fa-layer-group text-slate-400"></i> FlashQuest
        </div>
        
        <div class="flex gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-bold text-slate-600 hover:text-slate-900 px-4 py-2 uppercase text-sm tracking-widest transition">Acessar Painel</a>
            @else
                <a href="{{ route('login') }}" class="font-bold text-slate-600 hover:text-slate-900 px-4 py-2 uppercase text-sm tracking-widest transition">Entrar</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-2 px-6 rounded-none text-sm uppercase tracking-widest transition">Matrícula</a>
                @endif
            @endauth
        </div>
    </nav>

    <main class="flex-1 flex flex-col items-center justify-center p-6 text-center z-10 relative">
        <div class="max-w-4xl">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Sistema de Repetição Espaçada</div>
            <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tighter text-slate-900 uppercase">
                Preparação de <br/>Alta Performance.
            </h1>
            <p class="text-lg md:text-xl text-slate-600 mb-10 max-w-2xl mx-auto font-medium">
                Metodologia comprovada de cartões de memória. Foque na disciplina e deixe o algoritmo gerenciar suas revisões diárias.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm py-4 px-10 uppercase tracking-widest transition flex items-center justify-center gap-2">
                    Iniciar Preparação
                </a>
                <a href="#metodologia" class="bg-white border border-slate-300 hover:bg-slate-50 text-slate-900 font-bold text-sm py-4 px-10 uppercase tracking-widest transition flex items-center justify-center gap-2">
                    Conhecer Método
                </a>
            </div>
        </div>

        <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl text-left" id="metodologia">
            <div class="bg-white p-8 border border-slate-200 shadow-sm hover:border-slate-400 transition">
                <div class="text-3xl text-slate-400 mb-4">
                    <i class="fa-solid fa-microchip"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900 mb-2 uppercase tracking-widest">Algoritmo SM-2</h3>
                <p class="text-slate-600 text-sm font-medium">Revisões calculadas pela curva de esquecimento. Omitimos o supérfluo e apresentamos o que você está prestes a esquecer.</p>
            </div>
            
            <div class="bg-white p-8 border border-slate-200 shadow-sm hover:border-slate-400 transition">
                <div class="text-3xl text-slate-400 mb-4">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900 mb-2 uppercase tracking-widest">Métricas Operacionais</h3>
                <p class="text-slate-600 text-sm font-medium">Acompanhe seu rendimento absoluto. Meça revisões, sequências (streaks) e nível de retenção de informações.</p>
            </div>

            <div class="bg-white p-8 border border-slate-200 shadow-sm hover:border-slate-400 transition">
                <div class="text-3xl text-slate-400 mb-4">
                    <i class="fa-solid fa-folder-tree"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900 mb-2 uppercase tracking-widest">Organização de Decks</h3>
                <p class="text-slate-600 text-sm font-medium">Módulo limpo e estruturado para você criar e gerenciar seu próprio material, suportando sintaxe Markdown.</p>
            </div>
        </div>
    </main>

    <footer class="bg-slate-900 text-slate-500 py-8 text-center text-xs font-bold uppercase tracking-widest">
        FlashQuest &copy; {{ date('Y') }} - Sistema de Estudo.
    </footer>

</body>
</html>
