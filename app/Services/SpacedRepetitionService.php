<?php

namespace App\Services;

use App\Models\StudySession;
use App\Models\Card;
use Carbon\Carbon;

class SpacedRepetitionService
{
    /**
     * Calculates the next review date and ease factor based on SM-2.
     * Rating: 0 (Blackout) to 5 (Perfect)
     */
    public function processReview(int $userId, int $cardId, int $rating)
    {
        $card = Card::findOrFail($cardId);
        
        $session = StudySession::firstOrNew([
            'user_id' => $userId,
            'deck_id' => $card->deck_id,
            'card_id' => $cardId,
        ]);

        $interval = $session->interval_days ?? 0;
        $easeFactor = $session->ease_factor ?? 2.5;

        if ($rating >= 3) {
            if ($interval == 0) {
                $interval = 1;
            } elseif ($interval == 1) {
                $interval = 6;
            } else {
                $interval = (int)round($interval * $easeFactor);
            }
        } else {
            $interval = 1; // Reset on failure
        }

        // Update Ease Factor (SM-2 formula)
        $easeFactor = $easeFactor + (0.1 - (5 - $rating) * (0.08 + (5 - $rating) * 0.02));
        if ($easeFactor < 1.3) $easeFactor = 1.3;

        $session->rating = $rating;
        $session->interval_days = $interval;
        $session->ease_factor = $easeFactor;
        $session->reviewed_at = now();
        $session->next_review_at = now()->addDays($interval);
        $session->save();

        \App\Models\ReviewLog::create([
            'user_id' => $userId,
            'card_id' => $cardId,
            'deck_id' => $card->deck_id,
            'rating' => $rating,
            'interval_days' => $interval,
            'ease_factor' => $easeFactor,
        ]);

        return $session;
    }
}
