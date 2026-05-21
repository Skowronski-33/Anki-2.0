<?php

namespace App\Http\Controllers;

use App\Models\UserStat;
use App\Models\Achievement;
use Illuminate\Http\Request;

class GamificationController extends Controller
{
    public function leaderboard()
    {
        $topUsers = UserStat::with('user')->orderBy('xp_total', 'desc')->take(50)->get();
        return view('gamification.leaderboard', compact('topUsers'));
    }

    public function achievements()
    {
        $allAchievements = Achievement::all();
        $userAchievements = auth()->user()->achievements->pluck('id')->toArray();
        return view('gamification.achievements', compact('allAchievements', 'userAchievements'));
    }
}
