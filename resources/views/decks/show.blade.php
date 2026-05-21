@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header do Deck -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-lg flex items-center justify-center text-white text-2xl" style="background-color: {{ $deck->color ?? '#4f46e5' }}">
                <i class="{{ $deck->icon ?? 'fa-solid fa-layer-group' }}"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $deck->name }}</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $deck->cards->count() }} cards registrados</p>
            </div>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('study.index', $deck) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                <i class="fa-solid fa-play mr-2"></i> Estudar Agora
            </a>
            <form action="{{ route('decks.destroy', $deck) }}" method="POST" onsubmit="return confirm('Deletar deck?');">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg transition">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Adicionar Card -->
        <div class="md:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Adicionar Card</h3>
                <form action="{{ route('cards.store', $deck) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Frente (Pergunta)</label>
                            <textarea name="front" rows="3" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Verso (Resposta)</label>
                            <textarea name="back" rows="3" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dica (Opcional)</label>
                            <input type="text" name="hint" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition">
                            + Salvar Card
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de Cards -->
        <div class="md:col-span-2 space-y-4">
            @forelse ($deck->cards as $card)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 flex justify-between items-start group">
                    <div class="grid grid-cols-2 gap-4 flex-1 pr-4">
                        <div>
                            <span class="text-xs text-gray-400 block mb-1 uppercase font-semibold">Frente</span>
                            <div class="text-sm text-gray-800 dark:text-gray-200">{{ $card->front }}</div>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block mb-1 uppercase font-semibold">Verso</span>
                            <div class="text-sm text-gray-800 dark:text-gray-200">{{ $card->back }}</div>
                        </div>
                    </div>
                    <div class="opacity-0 group-hover:opacity-100 transition">
                        <form action="{{ route('cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Remover card?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 p-2"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-lg">
                    Ainda não há cards neste deck. Comece a criar ao lado!
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
