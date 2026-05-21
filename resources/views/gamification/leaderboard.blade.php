@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-slate-900 border border-slate-800 shadow-sm p-8 text-center text-white relative overflow-hidden rounded">
        <h2 class="text-2xl font-bold tracking-widest uppercase mb-1 relative z-10">Ranking Global</h2>
        <p class="text-slate-400 text-sm font-medium uppercase tracking-wide relative z-10">Métricas de Desempenho Operacional</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 shadow-sm overflow-hidden rounded">
        <div class="p-6">
            <div class="flex flex-col gap-2">
                @foreach ($topUsers as $index => $stat)
                    <div class="flex items-center p-4 border border-slate-800 {{ $stat->user_id == auth()->id() ? 'bg-slate-800 border-slate-700' : 'hover:bg-slate-800' }} transition rounded">
                        <div class="w-12 text-center font-bold text-xl text-slate-500">
                            #{{ $index + 1 }}
                        </div>
                        
                        <div class="w-12 h-12 bg-slate-950 mx-4 flex items-center justify-center text-slate-600 font-black uppercase tracking-widest text-lg rounded border border-slate-800">
                            {{ substr($stat->user->name, 0, 1) }}
                        </div>
                        
                        <div class="flex-1">
                            <a href="{{ route('profile.show', $stat->user) }}" class="text-lg font-bold text-white hover:text-slate-300 transition">{{ $stat->user->name }}</a>
                            <div class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1">
                                Lvl {{ $stat->level }} <span class="mx-2">|</span> <i class="fa-solid fa-fire text-slate-600 mx-1"></i> {{ $stat->streak_days }} dias
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <div class="text-xl font-black text-white tracking-tight">{{ number_format($stat->xp_total) }} <span class="text-sm font-bold text-slate-500">XP</span></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
