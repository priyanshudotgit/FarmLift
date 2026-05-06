<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class FarmerProfile extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'farmer_profiles';

    protected $fillable = [
        'user_id',
        'farm_location',
        'gst_number',
        'farm_name',
        'address',
    ];

    protected $casts = [
        'farm_location' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Set farm location as GeoJSON Point.
     */
    public function setFarmLocationAttribute(array $coords): void
    {
        $this->attributes['farm_location'] = [
            'type'        => 'Point',
            'coordinates' => [(float) $coords['lng'], (float) $coords['lat']],
        ];
    }
}
