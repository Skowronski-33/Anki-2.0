@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header Perfil -->
    <div class="bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="h-24 bg-slate-900"></div>
        <div class="px-8 flex flex-col md:flex-row justify-between items-start md:items-end -mt-10 pb-6">
            <div class="flex flex-col md:flex-row items-center md:items-end gap-6">
                <div class="w-24 h-24 bg-white border border-slate-200 p-1">
                    <div class="w-full h-full bg-slate-100 flex items-center justify-center text-4xl font-black text-slate-400">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
                <div class="text-center md:text-left mb-2">
                    <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">{{ $user->name }}</h2>
                    <p class="text-slate-500 text-sm font-medium tracking-wide uppercase">Ingresso em {{ $user->created_at->format('m/Y') }}</p>
                </div>
            </div>
            <div class="mt-4 md:mt-0 w-full md:w-auto text-center">
                @if(auth()->id() !== $user->id)
                    <button class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-2 px-6 text-sm uppercase tracking-widest transition">
                        Acompanhar
                    </button>
                @else
                    <a href="{{ route('profile.edit') }}" class="border border-slate-300 hover:bg-slate-50 text-slate-900 font-bold py-2 px-6 text-sm uppercase tracking-widest transition inline-block">
                        Atualizar Dados
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stats Sidebar -->
        <div class="md:col-span-1 space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-900 mb-4 border-b border-slate-200 pb-2 uppercase tracking-wide text-sm">Prontuário</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-semibold text-sm uppercase tracking-wide"><i class="fa-solid fa-star text-slate-400 w-6"></i> XP Total</span>
                        <span class="font-black text-slate-900">{{ number_format($user->stats->xp_total ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-semibold text-sm uppercase tracking-wide"><i class="fa-solid fa-shield text-slate-400 w-6"></i> Patente</span>
                        <span class="font-black text-slate-900">{{ $user->stats->level ?? 1 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-semibold text-sm uppercase tracking-wide"><i class="fa-solid fa-fire text-slate-400 w-6"></i> Ofensiva</span>
                        <span class="font-black text-slate-900">{{ $user->stats->streak_days ?? 0 }} dias</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-semibold text-sm uppercase tracking-wide"><i class="fa-solid fa-check-double text-slate-400 w-6"></i> Revisões</span>
                        <span class="font-black text-slate-900">{{ $user->stats->cards_reviewed_total ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Últimas Conquistas -->
            <div class="bg-white border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-900 mb-4 border-b border-slate-200 pb-2 uppercase tracking-wide text-sm">Últimos Méritos</h3>
                <div class="space-y-4">
                    @forelse($user->achievements->take(3) as $achievement)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 text-slate-500 flex items-center justify-center text-xl">
                                <i class="{{ $achievement->icon }}"></i>
                            </div>
                            <div>
                                <div class="font-bold text-sm text-slate-900">{{ $achievement->name }}</div>
                                <div class="text-xs text-slate-500 uppercase tracking-widest font-semibold">{{ \Carbon\Carbon::parse($achievement->pivot->unlocked_at)->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 text-center py-2">Nenhum mérito registrado.</p>
                    @endforelse
                </div>
                @if($user->achievements->count() > 3)
                    <div class="mt-5 text-center border-t border-slate-100 pt-3">
                        <a href="{{ route('achievements') }}" class="text-xs font-bold text-slate-900 uppercase tracking-widest hover:underline">Ver Histórico Completo</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Decks Públicos -->
        <div class="md:col-span-2">
            <h3 class="text-lg font-bold text-slate-900 mb-4 uppercase tracking-wide border-b border-slate-200 pb-2">Material Operacional Aberto</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                @forelse($user->decks as $deck)
                    <div class="bg-white border border-slate-200 shadow-sm p-5 hover:border-slate-400 transition">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 flex items-center justify-center text-slate-700 text-lg">
                                <i class="{{ $deck->icon ?? 'fa-solid fa-folder' }}"></i>
                            </div>
                            <h4 class="font-bold text-slate-900 uppercase tracking-tight">{{ $deck->name }}</h4>
                        </div>
                        <p class="text-sm text-slate-500 mb-4 line-clamp-2">{{ $deck->description }}</p>
                        <a href="{{ route('study.index', $deck) }}" class="text-slate-900 border border-slate-900 hover:bg-slate-900 hover:text-white px-3 py-1 text-xs font-bold uppercase tracking-widest transition">Acessar &rarr;</a>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-10 bg-slate-50 border border-slate-200 border-dashed">
                        <p class="text-slate-500 uppercase font-semibold text-sm tracking-wide">Nenhum material disponibilizado pelo candidato.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
