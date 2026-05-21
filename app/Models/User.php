<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function stats() { return $this->hasOne(UserStat::class); }
    public function decks() { return $this->hasMany(Deck::class); }
    public function studySessions() { return $this->hasMany(StudySession::class); }
    public function achievements() { return $this->belongsToMany(Achievement::class, 'user_achievements')->withPivot('unlocked_at')->withTimestamps(); }
    public function followers() { return $this->belongsToMany(User::class, 'user_follows', 'followed_id', 'follower_id'); }
    public function following() { return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'followed_id'); }
    public function activityFeed() { return $this->hasMany(ActivityFeed::class); }
}
