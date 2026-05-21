@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center mb-2">
        <a href="{{ route('decks.index') }}" class="text-slate-500 hover:text-white mr-4 transition">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-white uppercase tracking-tight flex items-center gap-3">
            <div class="w-10 h-10 rounded flex items-center justify-center text-white" style="background-color: {{ empty($deck->color) ? '#334155' : $deck->color }}">
                <i class="{{ empty($deck->icon) ? 'fa-solid fa-folder' : $deck->icon }} text-lg"></i>
            </div>
            {{ $deck->name }}
        </h2>
    </div>

    <!-- Add Card Form -->
    <div class="bg-slate-900 border border-slate-800 shadow-sm rounded p-6 mb-6 mt-4">
        <h3 class="font-bold text-white uppercase tracking-widest text-sm mb-4"><i class="fa-solid fa-plus-circle text-slate-500 mr-2"></i> Adicionar Nova Carta</h3>
        <form action="{{ route('cards.store', $deck) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="front" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Frente (Pergunta)</label>
                    <textarea name="front" id="front" rows="2" required class="w-full bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition px-4 py-2 resize-none overflow-hidden" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
                </div>
                <div>
                    <label for="back" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Verso (Resposta)</label>
                    <textarea name="back" id="back" rows="2" required class="w-full bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition px-4 py-2 resize-none overflow-hidden" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
                </div>
            </div>
            <div class="mb-4">
                <label for="hint" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Dica (Opcional)</label>
                <input type="text" name="hint" id="hint" class="w-full bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition px-4 py-2">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-white hover:bg-slate-200 text-slate-900 font-bold py-2 px-6 rounded text-sm uppercase tracking-widest transition">
                    Salvar Carta
                </button>
            </div>
        </form>
    </div>

    <!-- Cards List -->
    <div class="bg-slate-900 border border-slate-800 shadow-sm rounded overflow-hidden">
        <div class="p-6 border-b border-slate-800 flex justify-between items-center">
            <h3 class="font-bold text-slate-300 uppercase tracking-widest text-sm">Cartões do Deck ({{ $deck->cards->count() }})</h3>
        </div>
        <div class="p-6">
            @if($deck->cards->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($deck->cards as $card)
                        <div class="bg-slate-950 border border-slate-800 p-4 rounded flex justify-between items-start">
                            <div class="min-w-0 pr-4">
                                <div class="font-bold text-white mb-2 break-all">{{ $card->front }}</div>
                                <div class="text-sm text-slate-400 break-all">{{ $card->back }}</div>
                            </div>
                            <div class="flex gap-2 text-slate-500">
                                <span class="text-xs font-bold bg-slate-800 px-2 py-1 rounded">Nível {{ $card->repetition_level }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 text-slate-500 font-medium">
                    Nenhum cartão adicionado a este deck ainda.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
