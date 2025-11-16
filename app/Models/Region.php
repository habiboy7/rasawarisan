<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Region extends Model
{
  protected $fillable = [
    'name',
    'slug',
    'type',
    'parent_id',
    'center_lat',
    'center_lng',
    'geojson',
  ];

  // Generate slug otomatis saat disimpan
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($region) {
      if (empty($region->slug)) {
        $baseSlug = Str::slug($region->name);
        $slug = $baseSlug;
        $counter = 2;

        // cek apakah slug sudah dipakai
        while (Region::where('slug', $slug)->exists()) {
          $slug = "{$baseSlug}-{$counter}";
          $counter++;
        }

        $region->slug = $slug;
      }
    });
  }

  public function parent()
  {
    return $this->belongsTo(Region::class, 'parent_id');
  }

  public function children()
  {
    return $this->hasMany(Region::class, 'parent_id');
  }

  public function dishes()
  {
    return $this->hasMany(Dish::class);
  }

  // Relasi region → partners (UMKM)
  public function partners()
  {
    return $this->hasMany(Partner::class);
  }
}
