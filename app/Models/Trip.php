<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Trip extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'trips';

    const STATUS_SCHEDULED = 'Scheduled';
    const STATUS_ACTIVE    = 'Active';
    const STATUS_COMPLETED = 'Completed';

    protected $fillable = [
        'driver_id',
        'origin',
        'destination',
        'waypoints',
        'departure_date',
        'total_capacity',
        'available_capacity',
        'price_per_ton',
        'status',
        'notes',
    ];

    protected $casts = [
        'departure_date'     => 'datetime',
        'total_capacity'     => 'float',
        'available_capacity' => 'float',
        'price_per_ton'      => 'float',
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'trip_id');
    }

    public function getOriginNameAttribute(): string
    {
        return $this->origin['name'] ?? 'Unknown';
    }

    public function getDestinationNameAttribute(): string
    {
        return $this->destination['name'] ?? 'Unknown';
    }

    public function getCapacityPercentAttribute(): float
    {
        if ($this->total_capacity <= 0) {
            return 0;
        }
        $used = $this->total_capacity - $this->available_capacity;
        return round(($used / $this->total_capacity) * 100, 1);
    }

    public function isScheduled(): bool
    {
        return $this->status === self::STATUS_SCHEDULED;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}
