<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class StreakService
{
    public function updateStreak(User $user)
    {
        $stats = $user->stats;
        if (!$stats) return;

        $lastStudy = $stats->last_study_date ? Carbon::parse($stats->last_study_date) : null;
        $today = now()->startOfDay();

        if (!$lastStudy) {
            $stats->streak_days = 1;
        } elseif ($lastStudy->isYesterday()) {
            $stats->streak_days += 1;
        } elseif ($lastStudy->isBefore(now()->subDays(1)->startOfDay())) {
            $stats->streak_days = 1; // streak broken
        }
        // if today, do nothing to streak_days

        $stats->last_study_date = $today;
        $stats->save();
    }
}
