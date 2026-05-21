<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Deck;
use Illuminate\Http\Request;
use App\Services\GamificationService;

class CardController extends Controller
{
    public function store(Request $request, Deck $deck)
    {
        if ($deck->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'front' => 'required|string',
            'back' => 'required|string',
            'hint' => 'nullable|string',
            'tag' => 'nullable|string',
        ]);

        $deck->cards()->create($validated);
        
        if ($deck->cards()->count() == 10) {
            app(GamificationService::class)->addXp(auth()->user(), 100, 'Criou um deck com 10 cards!');
        }

        return redirect()->back()->with('success', 'Card adicionado!');
    }

    public function update(Request $request, Card $card)
    {
        if ($card->deck->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'front' => 'required|string',
            'back' => 'required|string',
            'hint' => 'nullable|string',
            'tag' => 'nullable|string',
        ]);

        $card->update($validated);
        return redirect()->back()->with('success', 'Card atualizado!');
    }

    public function destroy(Card $card)
    {
        if ($card->deck->user_id !== auth()->id()) abort(403);
        $card->delete();
        return redirect()->back()->with('success', 'Card removido!');
    }
}
