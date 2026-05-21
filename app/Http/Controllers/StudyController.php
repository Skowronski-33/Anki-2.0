<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;
use App\Services\SpacedRepetitionService;
use App\Services\GamificationService;
use App\Services\StreakService;

class StudyController extends Controller
{
    public function index(Deck $deck)
    {
        if ($deck->user_id !== auth()->id() && !$deck->is_public) abort(403);
        return view('study.index', compact('deck'));
    }

    public function nextCards(Deck $deck)
    {
        if ($deck->user_id !== auth()->id() && !$deck->is_public) abort(403);

        $userId = auth()->id();
        
        // Get cards due for review
        $dueCards = $deck->cards()->whereHas('studySessions', function($q) use ($userId) {
            $q->where('user_id', $userId)
              ->where('next_review_at', '<=', now());
        })->get();

        // Get new cards (no study session)
        $newCards = $deck->cards()->whereDoesntHave('studySessions', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->get();

        $allCards = $dueCards->concat($newCards)->take(20); // Limit to 20 per session for UX

        return response()->json(['cards' => $allCards]);
    }

    public function answer(Request $request, Deck $deck, SpacedRepetitionService $sm2, GamificationService $gamification, StreakService $streakService)
    {
        $validated = $request->validate([
            'card_id' => 'required|exists:cards,id',
            'rating' => 'required|integer|min:0|max:5',
        ]);

        $user = auth()->user();

        // Process SM-2
        $sm2->processReview($user->id, $validated['card_id'], $validated['rating']);

        // Gamification
        $xp = 0;
        if ($validated['rating'] >= 4) $xp = 10;
        elseif ($validated['rating'] == 3) $xp = 5;
        
        if ($xp > 0) {
            $gamification->addXp($user, $xp, 'Card revisado corretamente');
        }

        // Streak
        $streakService->updateStreak($user);

        // Update stats
        $stats = $user->stats;
        if($stats) {
            $stats->cards_reviewed_total += 1;
            $stats->save();
        }

        return response()->json([
            'success' => true,
            'xp_earned' => $xp,
            'current_xp' => $user->stats->xp_total ?? 0,
            'level' => $user->stats->level ?? 1,
            'streak' => $user->stats->streak_days ?? 0,
        ]);
    }
}
