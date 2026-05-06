<?php

namespace App\Listeners;

use App\Events\BookingStatusUpdated;
use App\Jobs\SendNotificationJob;

class NotifyFarmerOnStatusChange
{
    public function handle(BookingStatusUpdated $event): void
    {
        $booking = $event->booking;
        $status  = $booking->status;

        $message = match ($status) {
            'Confirmed' => "Your booking has been confirmed! The driver will pick up your goods soon.",
            'PickedUp'  => "Your goods have been picked up and are on the way. 🚚",
            'Delivered' => "Your goods have been delivered successfully! 📦",
            'Cancelled' => "Your booking has been cancelled by the driver.",
            default     => "Your booking status has been updated to: {$status}.",
        };

        SendNotificationJob::dispatch($booking->farmer_id, $message, 'booking_status', [
            'booking_id' => (string) $booking->_id,
            'status'     => $status,
        ]);
    }
}
