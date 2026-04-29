<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Trip extends Model
{
    protected $connection = 'mongodb';
    
    protected $collection = 'trips';

    protected $fillable = [
        'transporter_id',
        'origin',
        'destination',
        'departure_date',
        'capacity',
        'price_per_kg',
        'status'
    ];
}
