@extends('layouts.app')

@section('content')
@php
    $stats = auth()->user()->stats;
    $xp = $stats->xp_total ?? 0;
    $level = $stats->level ?? 1;
    $streak = $stats->streak_days ?? 0;
    $reviewed = $stats->cards_reviewed_total ?? 0;
    
    $currentLevelXp = pow($level - 1, 2) * 200;
    $nextLevelXp = pow($level, 2) * 200;
    $xpForCurrentLevel = $xp - $currentLevelXp;
    $xpNeededForNextLevel = $nextLevelXp - $currentLevelXp;
    $progressPercentage = min(100, max(0, ($xpForCurrentLevel / $xpNeededForNextLevel) * 100));
@endphp

<div class="max-w-7xl mx-auto space-y-6">
    <div class="bg-slate-800 border border-slate-700 p-8 flex flex-col md:flex-row items-center justify-between rounded shadow-sm">
        <div>
            <h2 class="text-2xl font-black text-white tracking-tight uppercase">Painel de Controle</h2>
            <p class="text-slate-400 text-sm font-bold uppercase tracking-widest mt-1">Operador logado: <span class="text-white">{{ auth()->user()->name }}</span></p>
        </div>
        <div class="mt-6 md:mt-0">
            <a href="{{ route('decks.index') }}" class="bg-white hover:bg-slate-200 text-slate-900 px-8 py-3 rounded text-sm font-bold uppercase tracking-widest transition flex items-center">
                <i class="fa-solid fa-folder-open mr-2 text-slate-600"></i> Acessar Material
            </a>
        </div>
    </div>

    @if($streak == 0 && $reviewed == 0)
        <div class="bg-slate-800 border border-slate-700 p-10 rounded shadow-sm text-center">
            <div class="text-5xl text-slate-600 mb-6"><i class="fa-solid fa-flag"></i></div>
            <h3 class="text-2xl font-black text-white uppercase tracking-widest mb-3">Seu Treinamento Começa Agora</h3>
            <p class="text-slate-400 font-medium mb-8 max-w-lg mx-auto">Prepare seu material operacional para iniciar as revisões, ganhar XP e evoluir de nível.</p>
            <a href="{{ route('decks.create') }}" class="bg-indigo-600 hover:bg-indigo-500 border border-indigo-500 text-white px-8 py-3 rounded text-sm font-bold uppercase tracking-widest transition inline-flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Criar meu primeiro deck
            </a>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Card de XP -->
        <div class="bg-slate-800 border border-slate-700 p-6 rounded shadow-sm">
            <div class="w-12 h-12 bg-amber-500/10 text-amber-500 border border-amber-500/20 rounded-lg flex items-center justify-center text-xl mb-4">
                <i class="fa-solid fa-star"></i>
            </div>
            <div class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">XP Acumulado</div>
            <div class="text-3xl font-black text-white tracking-tight">{{ $xp }}</div>
        </div>
        
        <!-- Card de Nível -->
        <div class="bg-slate-800 border border-slate-700 p-6 rounded shadow-sm flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-blue-500/10 text-blue-500 border border-blue-500/20 rounded-lg flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-shield"></i>
                </div>
                <div class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Nível Operacional</div>
                <div class="text-3xl font-black text-white tracking-tight">{{ $level }}</div>
            </div>
            <div class="mt-4">
                <div class="w-full bg-slate-950 rounded-full h-2 border border-slate-700 overflow-hidden">
                    <div class="bg-blue-500 h-full rounded-full transition-all duration-1000" style="width: {{ $progressPercentage }}%"></div>
                </div>
                <div class="text-[10px] text-slate-500 font-bold tracking-widest uppercase mt-2 text-right">
                    {{ $xpForCurrentLevel }} / {{ $xpNeededForNextLevel }} XP
                </div>
            </div>
        </div>
        
        <!-- Card de Ofensiva -->
        <div class="bg-slate-800 border border-slate-700 p-6 rounded shadow-sm">
            <div class="w-12 h-12 bg-orange-500/10 text-orange-500 border border-orange-500/20 rounded-lg flex items-center justify-center text-xl mb-4">
                <i class="fa-solid fa-fire"></i>
            </div>
            <div class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Ofensiva (Dias)</div>
            <div class="text-3xl font-black text-white tracking-tight">{{ $streak }}</div>
        </div>
        
        <!-- Card de Revisões -->
        <div class="bg-slate-800 border border-slate-700 p-6 rounded shadow-sm">
            <div class="w-12 h-12 bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 rounded-lg flex items-center justify-center text-xl mb-4">
                <i class="fa-solid fa-check-double"></i>
            </div>
            <div class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Cards Revisados</div>
            <div class="text-3xl font-black text-white tracking-tight">{{ $reviewed }}</div>
        </div>
    </div>
</div>
@endsection
