<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'user_id',
        'region_id',
        'kabupaten_id',
        'name',
        'description',
        'logo_url',
        'address',
        'lat',
        'lng',
        'phone',
        'email',
        'website',
        'is_verified'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Region::class, 'kabupaten_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(PartnerProduct::class);
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'partner_products')
            ->withPivot('price', 'image_url');
    }
}
