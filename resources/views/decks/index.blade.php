@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-center bg-slate-900 border border-slate-800 p-6 rounded shadow-sm">
        <h2 class="text-2xl font-bold text-white tracking-tight uppercase">Decks</h2>
        <a href="{{ route('decks.create') }}" class="mt-4 md:mt-0 bg-white hover:bg-slate-200 text-slate-900 px-6 py-2 rounded text-sm font-bold uppercase tracking-widest transition shadow">
            <i class="fa-solid fa-plus mr-2"></i> Novo Deck
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($decks as $deck)
            <div class="bg-slate-900 border border-slate-800 rounded shadow-sm hover:border-slate-600 transition flex flex-col">
                <div class="p-6 flex-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded flex items-center justify-center text-white" style="background-color: {{ empty($deck->color) ? '#334155' : $deck->color }}">
                            <i class="{{ empty($deck->icon) ? 'fa-solid fa-folder' : $deck->icon }} text-lg"></i>
                        </div>
                        @if($deck->is_public)
                            <span class="text-xs font-bold bg-slate-800 text-slate-400 px-3 py-1 rounded uppercase tracking-widest"><i class="fa-solid fa-globe mr-1"></i> Público</span>
                        @else
                            <span class="text-xs font-bold bg-slate-800 text-slate-500 px-3 py-1 rounded uppercase tracking-widest"><i class="fa-solid fa-lock mr-1"></i> Privado</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 uppercase tracking-tight">{{ $deck->name }}</h3>
                    <p class="text-slate-400 text-sm mb-4 line-clamp-2 font-medium">{{ $deck->description ?? 'Sem descrição fornecida.' }}</p>
                    
                    <div class="flex items-center justify-between text-xs font-bold text-slate-500 uppercase tracking-widest mb-6">
                        <span><i class="fa-solid fa-clone mr-1"></i> {{ $deck->cards_count }} cards</span>
                    </div>
                </div>

                <div class="p-4 border-t border-slate-800 flex gap-2">
                    <a href="{{ route('study.index', $deck) }}" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 rounded text-center text-sm uppercase tracking-widest transition border border-slate-700">
                        Estudar
                    </a>
                    <a href="{{ route('decks.show', $deck) }}" class="bg-transparent hover:bg-slate-800 text-slate-400 hover:text-white font-bold px-4 py-2 rounded text-center border border-slate-700 transition">
                        <i class="fa-solid fa-gear"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-slate-900 rounded border border-slate-800 border-dashed">
                <div class="text-5xl text-slate-700 mb-4"><i class="fa-solid fa-folder-open"></i></div>
                <h3 class="text-lg font-bold text-white uppercase tracking-widest">Nenhum Deck Encontrado</h3>
                <p class="text-slate-500 mt-2 font-medium">Inicie a criação de seu material operacional.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
