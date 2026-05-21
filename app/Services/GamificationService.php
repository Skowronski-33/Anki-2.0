<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserStat;
use App\Models\Achievement;
use App\Models\ActivityFeed;

class GamificationService
{
    public function addXp(User $user, int $amount, string $reason)
    {
        $stats = $user->stats ?? new UserStat(['user_id' => $user->id]);
        $stats->xp_total += $amount;
        
        $newLevel = floor(sqrt($stats->xp_total / 200)) + 1;
        
        if ($newLevel > $stats->level) {
            $stats->level = $newLevel;
            // Can trigger a LevelUp Event here for notifications
            ActivityFeed::create([
                'user_id' => $user->id,
                'content' => "Alcançou o nível {$newLevel}!",
                'type' => 'level_up'
            ]);
        }
        
        $stats->save();
        $this->checkAchievements($user);
    }

    public function checkAchievements(User $user)
    {
        $stats = $user->stats()->first();
        if (!$stats) return;
        
        $achievements = Achievement::whereNotIn('id', $user->achievements->pluck('id'))->get();

        foreach ($achievements as $achievement) {
            $unlocked = false;
            
            switch ($achievement->condition_type) {
                case 'level':
                    if ($stats->level >= $achievement->condition_value) $unlocked = true;
                    break;
                case 'cards_reviewed':
                    if ($stats->cards_reviewed_total >= $achievement->condition_value) $unlocked = true;
                    break;
                case 'streak':
                    if ($stats->streak_days >= $achievement->condition_value) $unlocked = true;
                    break;
                case 'decks_created':
                    if ($user->decks()->count() >= $achievement->condition_value) $unlocked = true;
                    break;
            }

            if ($unlocked) {
                $user->achievements()->attach($achievement->id);
                $this->addXp($user, $achievement->xp_reward, 'Conquista desbloqueada: ' . $achievement->name);
                
                ActivityFeed::create([
                    'user_id' => $user->id,
                    'content' => "Desbloqueou a conquista: {$achievement->name}",
                    'type' => 'achievement'
                ]);
            }
        }
    }
}
