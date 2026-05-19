<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Booking;
use App\Services\TripService;
use App\Http\Requests\StoreBookingRequest;
use App\Events\BookingRequested;
use App\Events\BookingStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request, TripService $tripService)
    {
        $data = $request->validated();
        $trip = Trip::findOrFail($data['trip_id']);
        
        $weight = (float) $data['weight'];

        // Atomic capacity reservation
        if (!$tripService->reserveCapacity((string) $trip->_id, $weight)) {
            return back()->with('error', 'Not enough capacity available on this trip.');
        }

        $price = $trip->price_per_ton * $weight;

        $booking = Booking::create([
            'trip_id' => (string) $trip->_id,
            'farmer_id' => (string) Auth::id(),
            'weight' => $weight,
            'price' => $price,
            'status' => Booking::STATUS_PENDING,
            'produce_type' => $data['produce_type'],
            'pickup_address' => $data['pickup_address'],
            'notes' => $data['notes'] ?? null,
        ]);

        // Fire Event — wrapped in try-catch so notification failures
        // never prevent a successful booking from being saved
        try {
            event(new BookingRequested($booking));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('BookingRequested event failed: ' . $e->getMessage());
        }

        return redirect()->route('farmer.dashboard')->with('success', 'Booking requested successfully.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        // Check authorization using policy
        Gate::authorize('updateStatus', $booking);

        $request->validate([
            'status' => 'required|in:' . implode(',', [
                Booking::STATUS_CONFIRMED,
                Booking::STATUS_PICKED_UP,
                Booking::STATUS_DELIVERED,
                Booking::STATUS_CANCELLED
            ])
        ]);

        $previousStatus = $booking->status;
        $newStatus = $request->status;

        $booking->update(['status' => $newStatus]);

        if ($newStatus === Booking::STATUS_CANCELLED && $previousStatus !== Booking::STATUS_CANCELLED) {
            // Restore capacity
            app(TripService::class)->releaseCapacity($booking->trip_id, $booking->weight);
        }

        // Fire Event
        event(new BookingStatusUpdated($booking, $previousStatus));

        return back()->with('success', 'Booking status updated.');
    }
}
