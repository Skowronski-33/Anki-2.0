@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="bg-white border border-slate-200 shadow-sm p-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight uppercase">Resumo Operacional</h2>
            <p class="text-slate-500 mt-1 text-sm font-medium">Bem-vindo(a), Candidato(a) {{ auth()->user()->name }}.</p>
        </div>
        <div class="hidden md:block">
            <a href="{{ route('decks.index') }}" class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2 rounded text-sm font-bold uppercase tracking-wide transition">
                Acessar Decks
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 border border-slate-200 shadow-sm text-center">
            <div class="text-3xl text-slate-400 mb-3"><i class="fa-solid fa-star"></i></div>
            <div class="text-xs text-slate-500 uppercase font-bold tracking-widest mb-1">XP Acumulado</div>
            <div class="text-3xl font-black text-slate-900">{{ auth()->user()->stats->xp_total ?? 0 }}</div>
        </div>
        <div class="bg-white p-6 border border-slate-200 shadow-sm text-center">
            <div class="text-3xl text-slate-400 mb-3"><i class="fa-solid fa-shield"></i></div>
            <div class="text-xs text-slate-500 uppercase font-bold tracking-widest mb-1">Patente (Nível)</div>
            <div class="text-3xl font-black text-slate-900">{{ auth()->user()->stats->level ?? 1 }}</div>
        </div>
        <div class="bg-white p-6 border border-slate-200 shadow-sm text-center">
            <div class="text-3xl text-slate-400 mb-3"><i class="fa-solid fa-fire"></i></div>
            <div class="text-xs text-slate-500 uppercase font-bold tracking-widest mb-1">Dias Consecutivos</div>
            <div class="text-3xl font-black text-slate-900">{{ auth()->user()->stats->streak_days ?? 0 }}</div>
        </div>
        <div class="bg-white p-6 border border-slate-200 shadow-sm text-center">
            <div class="text-3xl text-slate-400 mb-3"><i class="fa-solid fa-check-double"></i></div>
            <div class="text-xs text-slate-500 uppercase font-bold tracking-widest mb-1">Cards Revisados</div>
            <div class="text-3xl font-black text-slate-900">{{ auth()->user()->stats->cards_reviewed_total ?? 0 }}</div>
        </div>
    </div>
</div>
@endsection
