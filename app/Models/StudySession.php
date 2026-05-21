<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySession extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'deck_id', 'card_id', 'rating', 'interval_days', 'ease_factor', 'next_review_at', 'reviewed_at'];

    public function user() { return $this->belongsTo(User::class); }
    public function deck() { return $this->belongsTo(Deck::class); }
    public function card() { return $this->belongsTo(Card::class); }
}
