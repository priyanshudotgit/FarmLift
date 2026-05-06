<?php

namespace App\Listeners;

use App\Events\BookingRequested;
use App\Jobs\SendNotificationJob;
use App\Models\Trip;

class NotifyDriverOnBooking
{
    public function handle(BookingRequested $event): void
    {
        $booking = $event->booking;
        $trip    = Trip::find($booking->trip_id);

        if (! $trip) {
            return;
        }

        $farmerName = $booking->farmer->name ?? 'A farmer';
        $message    = "New booking request from {$farmerName} for {$booking->weight} tons on trip to {$trip->destination_name}.";

        SendNotificationJob::dispatch($trip->driver_id, $message, 'booking_request', [
            'booking_id' => (string) $booking->_id,
            'trip_id'    => (string) $trip->_id,
        ]);
    }
}
