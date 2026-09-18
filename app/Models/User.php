<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'favorite_games',
    'bio',
    'avatar_url',
    'favorite_genre',
    'preferred_platform',
    'play_style',
    'gaming_status',
    'profile_color',
    'profile_visibility',
    'show_favorites',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function gameComments(): HasMany
    {
        return $this->hasMany(GameComment::class);
    }

    public function gameRatings(): HasMany
    {
        return $this->hasMany(GameRating::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'favorite_games' => 'array',
            'profile_visibility' => 'boolean',
            'show_favorites' => 'boolean',
            'password' => 'hashed',
        ];
    }
}
