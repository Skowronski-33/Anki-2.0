<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReviewLog;
use App\Models\StudySession;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // 1. Future Due (Forecast) - Next 30 days
        $futureDue = ['dates' => [], 'counts' => []];
        $today = Carbon::today();
        for ($i = 0; $i <= 30; $i++) {
            $date = $today->copy()->addDays($i)->format('Y-m-d');
            $count = StudySession::where('user_id', $userId)
                ->whereDate('next_review_at', $date)
                ->count();
            // Also include overdue in today (index 0)
            if ($i === 0) {
                $overdue = StudySession::where('user_id', $userId)
                    ->whereDate('next_review_at', '<', $today)
                    ->count();
                $count += $overdue;
            }
            $futureDue['dates'][] = $date;
            $futureDue['counts'][] = $count;
        }

        // 2. Reviews History (Last 14 days)
        $history = ['dates' => [], 'counts' => []];
        for ($i = 13; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i)->format('Y-m-d');
            $count = ReviewLog::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->count();
            $history['dates'][] = $date;
            $history['counts'][] = $count;
        }

        // 3. Card Counts (State: Mature, Young, Learning)
        // Mature = interval >= 21
        // Young = interval > 1 && < 21
        // Learning = interval <= 1
        $matureCount = StudySession::where('user_id', $userId)->where('interval_days', '>=', 21)->count();
        $youngCount = StudySession::where('user_id', $userId)->where('interval_days', '>', 1)->where('interval_days', '<', 21)->count();
        $learningCount = StudySession::where('user_id', $userId)->where('interval_days', '<=', 1)->count();
        $cardCounts = [$matureCount, $youngCount, $learningCount];

        // 4. Answer Buttons (Rating distribution)
        $ratingLogs = ReviewLog::where('user_id', $userId)
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')->toArray();
        
        $buttons = [
            'Errei' => $ratingLogs[1] ?? 0, 
            'Difícil' => $ratingLogs[3] ?? 0, 
            'Bom' => $ratingLogs[4] ?? 0, 
            'Fácil' => $ratingLogs[5] ?? 0
        ];

        return view('stats.index', compact('futureDue', 'history', 'cardCounts', 'buttons'));
    }
}
