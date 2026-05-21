@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Meus Decks</h2>
        <a href="{{ route('decks.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold transition">
            <i class="fa-solid fa-plus mr-2"></i> Criar Deck
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($decks as $deck)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white" style="background-color: {{ $deck->color ?? '#4f46e5' }}">
                            <i class="{{ $deck->icon ?? 'fa-solid fa-layer-group' }} text-xl"></i>
                        </div>
                        @if($deck->is_public)
                            <span class="text-xs font-semibold bg-gray-100 text-gray-600 px-2 py-1 rounded-full"><i class="fa-solid fa-earth-americas mr-1"></i> Público</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">{{ $deck->name }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2">{{ $deck->description ?? 'Sem descrição' }}</p>
                    
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <span><i class="fa-solid fa-clone mr-1"></i> {{ $deck->cards_count }} cards</span>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('study.index', $deck) }}" class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold py-2 rounded-lg text-center transition">
                            Estudar
                        </a>
                        <a href="{{ route('decks.show', $deck) }}" class="bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold px-4 py-2 rounded-lg text-center border border-gray-200 transition">
                            <i class="fa-solid fa-gear"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-6xl text-gray-300 dark:text-gray-600 mb-4"><i class="fa-solid fa-box-open"></i></div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Nenhum deck encontrado</h3>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Crie seu primeiro deck para começar a aprender.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
