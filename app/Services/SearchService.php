<?php

namespace App\Services;

use App\Models\Trip;

class SearchService
{
    /**
     * Find active trips within a 30km radius of the provided coordinates.
     *
     * @param float $lng
     * @param float $lat
     * @param float $radiusKm Default is 30km
     * @param float $minCapacity Required capacity
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findTripsNearby(float $lng, float $lat, float $radiusKm = 30, float $minCapacity = 0)
    {
        // Radius of earth in km
        $earthRadius = 6378.1;
        $radians = $radiusKm / $earthRadius;

        // Using MongoDB geoWithin centerSphere query on waypoints array of GeoJSON Points
        return Trip::where('status', Trip::STATUS_SCHEDULED)
            ->where('available_capacity', '>=', $minCapacity)
            ->where('waypoints', 'geoWithin', [
                '$centerSphere' => [
                    [$lng, $lat],
                    $radians
                ]
            ])
            ->with('driver')
            ->orderBy('departure_date', 'asc')
            ->get();
    }
}
