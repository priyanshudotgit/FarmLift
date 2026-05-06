<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class DriverProfile extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'driver_profiles';

    protected $fillable = [
        'user_id',
        'truck_model',
        'plate_number',
        'max_payload',
        'refrigeration',
        'license_number',
    ];

    protected $casts = [
        'refrigeration' => 'boolean',
        'max_payload'   => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
