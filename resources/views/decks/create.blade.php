@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('decks.index') }}" class="text-slate-500 hover:text-white mr-4 transition">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-white uppercase tracking-tight">Criar Novo Deck</h2>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded shadow-sm p-8">
        <form action="{{ route('decks.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="name" class="block text-sm font-bold tracking-widest text-slate-400 uppercase mb-2">Nome do Deck</label>
                <input type="text" name="name" id="name" required class="w-full bg-slate-950 border border-slate-800 rounded px-4 py-3 text-white focus:outline-none focus:border-slate-500 transition">
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-bold tracking-widest text-slate-400 uppercase mb-2">Descrição</label>
                <textarea name="description" id="description" rows="3" class="w-full bg-slate-950 border border-slate-800 rounded px-4 py-3 text-white focus:outline-none focus:border-slate-500 transition"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="color" class="block text-sm font-bold tracking-widest text-slate-400 uppercase mb-2">Cor (Hex)</label>
                    <input type="color" name="color" id="color" value="#334155" class="w-full h-12 bg-slate-950 border border-slate-800 rounded p-1 cursor-pointer">
                </div>
                <div>
                    <label for="icon" class="block text-sm font-bold tracking-widest text-slate-400 uppercase mb-2">Ícone (FA Class)</label>
                    <input type="text" name="icon" id="icon" value="fa-solid fa-folder" placeholder="Ex: fa-solid fa-book" class="w-full bg-slate-950 border border-slate-800 rounded px-4 py-3 text-white focus:outline-none focus:border-slate-500 transition">
                </div>
            </div>

            <div class="mb-8 flex items-center">
                <input type="hidden" name="is_public" value="0">
                <input type="checkbox" name="is_public" id="is_public" value="1" class="w-5 h-5 bg-slate-950 border-slate-800 rounded text-slate-500 focus:ring-slate-500">
                <label for="is_public" class="ml-3 text-sm font-bold tracking-widest text-slate-300 uppercase">Tornar Público</label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-white hover:bg-slate-200 text-slate-900 px-8 py-3 rounded text-sm font-bold uppercase tracking-widest transition shadow">
                    Cadastrar Deck
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
