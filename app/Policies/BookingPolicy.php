<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        // Either the farmer who booked or the driver of the trip
        return $user->id === $booking->farmer_id || 
               $user->id === $booking->trip->driver_id;
    }

    public function create(User $user): bool
    {
        return $user->isFarmer();
    }

    public function updateStatus(User $user, Booking $booking): bool
    {
        // Only driver can update status of the booking
        return $user->isDriver() && $user->id === $booking->trip->driver_id;
    }
}
