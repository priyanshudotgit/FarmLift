<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Booking extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'bookings';

    const STATUS_PENDING   = 'Pending';
    const STATUS_CONFIRMED = 'Confirmed';
    const STATUS_PICKED_UP = 'PickedUp';
    const STATUS_DELIVERED = 'Delivered';
    const STATUS_CANCELLED = 'Cancelled';

    protected $fillable = [
        'trip_id',
        'farmer_id',
        'weight',
        'price',
        'status',
        'produce_type',
        'notes',
        'pickup_address',
    ];

    protected $casts = [
        'weight' => 'float',
        'price'  => 'float',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING   => 'bg-yellow-100 text-yellow-800',
            self::STATUS_CONFIRMED => 'bg-blue-100 text-blue-800',
            self::STATUS_PICKED_UP => 'bg-purple-100 text-purple-800',
            self::STATUS_DELIVERED => 'bg-green-100 text-green-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            default                => 'bg-gray-100 text-gray-800',
        };
    }

    public function statusIcon(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING   => '⏳',
            self::STATUS_CONFIRMED => '✅',
            self::STATUS_PICKED_UP => '🚚',
            self::STATUS_DELIVERED => '📦',
            self::STATUS_CANCELLED => '❌',
            default                => '•',
        };
    }
}
