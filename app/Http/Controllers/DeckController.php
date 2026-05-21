<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    public function index()
    {
        $decks = auth()->user()->decks()->withCount('cards')->get();
        return view('decks.index', compact('decks'));
    }

    public function create()
    {
        return view('decks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'color' => 'nullable|string',
            'icon' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        $deck = auth()->user()->decks()->create($validated);
        
        app(\App\Services\GamificationService::class)->checkAchievements(auth()->user());

        return redirect()->route('decks.show', $deck)->with('success', 'Deck criado! Adicione suas cartas abaixo.');
    }

    public function show(Deck $deck)
    {
        if ($deck->user_id !== auth()->id() && !$deck->is_public) {
            abort(403);
        }
        $deck->load('cards');
        return view('decks.show', compact('deck'));
    }

    public function edit(Deck $deck)
    {
        if ($deck->user_id !== auth()->id()) abort(403);
        return view('decks.edit', compact('deck'));
    }

    public function update(Request $request, Deck $deck)
    {
        if ($deck->user_id !== auth()->id()) abort(403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'color' => 'nullable|string',
            'icon' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        $deck->update($validated);
        return redirect()->route('decks.show', $deck)->with('success', 'Deck atualizado!');
    }

    public function destroy(Deck $deck)
    {
        if ($deck->user_id !== auth()->id()) abort(403);
        $deck->delete();
        return redirect()->route('decks.index')->with('success', 'Deck deletado.');
    }
}
