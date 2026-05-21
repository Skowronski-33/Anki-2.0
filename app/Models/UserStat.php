<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStat extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'xp_total', 'level', 'streak_days', 'last_study_date', 'cards_reviewed_total'];

    public function user() { return $this->belongsTo(User::class); }
}
