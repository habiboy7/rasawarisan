<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLike extends Model
{
    protected $fillable = ['user_id', 'likeable_type', 'likeable_id'];

    // Polymorphic relation
    public function likeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
