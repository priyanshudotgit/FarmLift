<?php

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;

class TripPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Trip $trip): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isDriver();
    }

    public function update(User $user, Trip $trip): bool
    {
        return $user->isDriver() && $user->id === $trip->driver_id;
    }

    public function delete(User $user, Trip $trip): bool
    {
        return $user->isDriver() && $user->id === $trip->driver_id;
    }
}
