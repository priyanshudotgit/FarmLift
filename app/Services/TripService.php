<?php

namespace App\Services;

use App\Models\Trip;
use Illuminate\Support\Facades\Log;

class TripService
{
    /**
     * Atomically reserve capacity on a trip.
     * This prevents race conditions when multiple farmers book simultaneously.
     *
     * @param string $tripId
     * @param float $weight
     * @return bool
     */
    public function reserveCapacity(string $tripId, float $weight): bool
    {
        // ATOMIC BOOKING SYSTEM (CRITICAL LOGIC)
        $updated = Trip::where('_id', $tripId)
            ->where('available_capacity', '>=', $weight)
            ->update([
                '$inc' => ['available_capacity' => -$weight]
            ]);

        if (!$updated) {
            Log::warning("Failed to reserve {$weight}t on trip {$tripId} due to capacity or concurrency.");
            return false;
        }

        return true;
    }

    /**
     * Atomically release capacity back to a trip (e.g., booking cancelled).
     */
    public function releaseCapacity(string $tripId, float $weight): bool
    {
        return (bool) Trip::where('_id', $tripId)
            ->update([
                '$inc' => ['available_capacity' => $weight]
            ]);
    }
}
