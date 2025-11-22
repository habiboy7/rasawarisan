<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerProduct extends Model
{
    protected $fillable = [
        'partner_id',
        'dish_id',
        'name',
        'price',
        'image_url',
        'description',
        'available'
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
