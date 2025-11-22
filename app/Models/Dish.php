<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Dish extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'region_id',
        'kabupaten_id',
        'short_description',
        'history',
        'recipe',
        'main_image_url',
        'popularity_score',
        'likes_count'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($dish) {
            if (empty($dish->slug)) {
                $base = Str::slug($dish->name);
                $slug = $base;
                $counter = 2;
                while (Dish::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$counter}";
                    $counter++;
                }
                $dish->slug = $slug;
            }
        });
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }


    public function kabupaten()
    {
        return $this->belongsTo(Region::class, 'kabupaten_id');
    }


    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'partner_products')
            ->withPivot('price', 'image_url');
    }

    // Relasi likes (polymorphic)
    public function likes()
    {
        return $this->morphMany(UserLike::class, 'likeable');
    }

    // Check if user liked this dish
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    // Update likes count
    public function updateLikesCount()
    {
        $this->likes_count = $this->likes()->count();
        $this->save();
    }


    public function favoritedBy()
    {
        return $this->morphMany(UserFavorite::class, 'favoritable');
    }
}
