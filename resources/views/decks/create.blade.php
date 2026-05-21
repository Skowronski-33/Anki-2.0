@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Criar Novo Deck</h2>
        <a href="{{ route('decks.index') }}" class="text-gray-500 hover:text-gray-700">Voltar</a>
    </div>

    <form action="{{ route('decks.store') }}" method="POST">
        @csrf
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome do Deck</label>
                <input type="text" name="name" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Ex: Inglês Básico">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descrição</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="O que você vai aprender com este deck?"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Categoria</label>
                    <input type="text" name="category" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Ex: Idiomas">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cor Base (HEX)</label>
                    <input type="color" name="color" value="#4f46e5" class="w-full h-10 rounded-lg cursor-pointer">
                </div>
            </div>

            <div class="flex items-center">
                <input type="hidden" name="is_public" value="0">
                <input type="checkbox" name="is_public" value="1" id="is_public" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <label for="is_public" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Tornar Deck Público (outros usuários poderão clonar)</label>
            </div>
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition">
                Criar Deck
            </button>
        </div>
    </form>
</div>
@endsection
