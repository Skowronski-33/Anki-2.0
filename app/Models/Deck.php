<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'category', 'color', 'icon', 'is_public'];

    public function user() { return $this->belongsTo(User::class); }
    public function cards() { return $this->hasMany(Card::class); }
    public function studySessions() { return $this->hasMany(StudySession::class); }
}
