<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Event;
use App\Models\Partner;
use App\Models\UserLike;
use App\Models\UserFavorite;
use App\Models\Dish;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $savedEvents
 * @property-read \App\Models\Partner|null $partner
 * 
 * @method \Illuminate\Database\Eloquent\Relations\HasMany events()
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany savedEvents()
 * @method \Illuminate\Database\Eloquent\Relations\HasOne partner()
 */

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'phone',
        'role',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    // Events yang di-save user ini
    public function savedEvents()
    {
        return $this->belongsToMany(Event::class, 'user_saved_events')
            ->withTimestamps();
    }

    public function partner()
    {
        return $this->hasOne(Partner::class);
    }


    // User's likes 
    public function likes()
    {
        return $this->hasMany(UserLike::class);
    }

    // Dishes that user liked
    public function likedDishes()
    {
        return $this->morphedByMany(Dish::class, 'likeable', 'user_likes')->withTimestamps();;
    }

    // User's favorites
    public function favorites()
    {
        return $this->hasMany(UserFavorite::class);
    }

    // Favorite dishes
    public function favoriteDishes()
    {
        return $this->morphedByMany(Dish::class, 'favoritable', 'user_favorites');
    }

    // Favorite partners
    public function favoritePartners()
    {
        return $this->morphedByMany(Partner::class, 'favoritable', 'user_favorites');
    }
}
