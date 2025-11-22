<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'partner_id',
        'region_id',
        'dish_id',
        'title',
        'slug',
        'category',
        'description',
        'poster_url',
        'location_name',
        'location_address',
        'location_lat',
        'location_lng',
        'start_date',
        'end_date',
        'ticket_price',
        'max_participants',
        'registration_url',
        'organizer_name',
        'organizer_email',
        'organizer_phone',
        'status',
        'rejection_reason',
        'is_featured',
        'view_count',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'approved_at' => 'datetime',
        'is_featured' => 'boolean',
        'ticket_price' => 'decimal:2',
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $base = Str::slug($event->title);
                $slug = $base;
                $counter = 2;
                while (Event::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$counter}";
                    $counter++;
                }
                $event->slug = $slug;
            }
        });
    }

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Many-to-many: users yang save event ini
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_saved_events')
            ->withTimestamps();
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', Carbon::now())
            ->orderBy('start_date', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('end_date', '<', Carbon::now())
            ->orderBy('start_date', 'desc');
    }

    public function scopeOngoing($query)
    {
        return $query->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Helpers
    public function isUpcoming()
    {
        return $this->start_date > Carbon::now();
    }

    public function isPast()
    {
        return $this->end_date < Carbon::now();
    }

    public function isOngoing()
    {
        return $this->start_date <= Carbon::now() && $this->end_date >= Carbon::now();
    }

    public function isFree()
    {
        return $this->ticket_price == 0;
    }

    public function incrementViewCount()
    {
        $this->increment('view_count');
    }
}