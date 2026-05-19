<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Booking;
use App\Models\DriverProfile;
use App\Http\Requests\StoreTripRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class DriverController extends Controller
{
    /**
     * Driver Dashboard — real data from the database.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $trips = Trip::where('driver_id', (string) $user->_id)
            ->with(['bookings.farmer'])
            ->orderBy('departure_date', 'desc')
            ->get();

        // All bookings across all of this driver's trips
        $allBookings = $trips->flatMap(fn($trip) => $trip->bookings);

        // Active trips (Scheduled or Active)
        $activeTrips = $trips->whereIn('status', [Trip::STATUS_SCHEDULED, Trip::STATUS_ACTIVE]);
        $activeTripsCount = $activeTrips->count();

        // Total earnings (non-cancelled bookings)
        $totalEarnings = $allBookings->whereNotIn('status', [Booking::STATUS_CANCELLED])->sum('price');

        // Pending booking requests
        $pendingRequests = $allBookings->where('status', Booking::STATUS_PENDING)->count();

        // Completed trips
        $completedTrips = $trips->where('status', Trip::STATUS_COMPLETED)->count();

        // Total trips
        $totalTrips = $trips->count();

        // Total bookings
        $totalBookings = $allBookings->count();

        // Total weight moved (delivered only)
        $totalWeight = $allBookings->where('status', Booking::STATUS_DELIVERED)->sum('weight');

        // Delivered bookings count
        $deliveredBookings = $allBookings->where('status', Booking::STATUS_DELIVERED)->count();

        // Recent bookings (last 5)
        $recentBookings = $allBookings->sortByDesc('created_at')->take(5);

        return view('driver.dashboard', compact(
            'trips',
            'activeTrips',
            'activeTripsCount',
            'totalEarnings',
            'pendingRequests',
            'completedTrips',
            'totalTrips',
            'totalBookings',
            'totalWeight',
            'deliveredBookings',
            'recentBookings'
        ));
    }

    /**
     * Load Board — shows all trips created by this driver with booking details.
     */
    public function loadboard()
    {
        $user = Auth::user();

        $trips = Trip::where('driver_id', (string) $user->_id)
            ->with(['bookings.farmer'])
            ->orderBy('departure_date', 'desc')
            ->get();

        return view('driver.loadboard', compact('trips'));
    }

    /**
     * Earnings — revenue breakdown by trip and booking.
     */
    public function earnings()
    {
        $user = Auth::user();

        $trips = Trip::where('driver_id', (string) $user->_id)
            ->with(['bookings.farmer'])
            ->orderBy('departure_date', 'desc')
            ->get();

        $allBookings = $trips->flatMap(fn($trip) => $trip->bookings);
        $nonCancelled = $allBookings->whereNotIn('status', [Booking::STATUS_CANCELLED]);

        // Earnings Summary
        $totalEarnings = $nonCancelled->sum('price');
        $confirmedEarnings = $allBookings->whereIn('status', [
            Booking::STATUS_CONFIRMED,
            Booking::STATUS_PICKED_UP,
            Booking::STATUS_DELIVERED,
        ])->sum('price');
        $pendingEarnings = $allBookings->where('status', Booking::STATUS_PENDING)->sum('price');

        // Breakdown by status
        $deliveredEarnings = $allBookings->where('status', Booking::STATUS_DELIVERED)->sum('price');
        $deliveredCount = $allBookings->where('status', Booking::STATUS_DELIVERED)->count();
        $inTransitEarnings = $allBookings->where('status', Booking::STATUS_PICKED_UP)->sum('price');
        $inTransitCount = $allBookings->where('status', Booking::STATUS_PICKED_UP)->count();
        $pendingCount = $allBookings->where('status', Booking::STATUS_PENDING)->count();
        $cancelledEarnings = $allBookings->where('status', Booking::STATUS_CANCELLED)->sum('price');
        $cancelledCount = $allBookings->where('status', Booking::STATUS_CANCELLED)->count();

        $totalBookingsCount = $nonCancelled->count();
        $totalWeight = $nonCancelled->sum('weight');

        return view('driver.earnings', compact(
            'trips',
            'totalEarnings',
            'confirmedEarnings',
            'pendingEarnings',
            'deliveredEarnings',
            'deliveredCount',
            'inTransitEarnings',
            'inTransitCount',
            'pendingCount',
            'cancelledEarnings',
            'cancelledCount',
            'totalBookingsCount',
            'totalWeight'
        ));
    }

    /**
     * Driver Profile page.
     */
    public function profile()
    {
        $user = Auth::user();
        $profile = $user->driverProfile;

        $trips = Trip::where('driver_id', (string) $user->_id)->with('bookings')->get();
        $allBookings = $trips->flatMap(fn($t) => $t->bookings);
        $nonCancelled = $allBookings->whereNotIn('status', [Booking::STATUS_CANCELLED]);

        $stats = [
            'total_trips' => $trips->count(),
            'completed_trips' => $trips->where('status', Trip::STATUS_COMPLETED)->count(),
            'total_weight' => $nonCancelled->sum('weight'),
            'total_earnings' => $nonCancelled->sum('price'),
        ];

        return view('driver.profile', compact('user', 'profile', 'stats'));
    }

    /**
     * Update personal information (name, email, phone).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $user->update($request->only('name', 'email', 'phone'));

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update vehicle details.
     */
    public function updateVehicle(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'truck_model' => 'nullable|string|max:255',
            'plate_number' => 'nullable|string|max:20',
            'license_number' => 'nullable|string|max:30',
            'max_payload' => 'nullable|numeric|min:0',
        ]);

        $profile = DriverProfile::firstOrCreate(
            ['user_id' => $user->_id],
            []
        );

        $profile->update([
            'truck_model' => $request->truck_model,
            'plate_number' => $request->plate_number,
            'license_number' => $request->license_number,
            'max_payload' => $request->max_payload ? (float) $request->max_payload : null,
            'refrigeration' => $request->has('refrigeration'),
        ]);

        return back()->with('success', 'Vehicle details updated successfully.');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }

    /**
     * Show the create trip form.
     */
    public function createTrip()
    {
        return view('driver.create-trip');
    }

    /**
     * Store a new trip.
     */
    public function storeTrip(StoreTripRequest $request)
    {
        $data = $request->validated();
        
        // Format GeoJSON
        $origin = [
            'type' => 'Point',
            'coordinates' => [(float) $data['origin_lng'], (float) $data['origin_lat']],
            'name' => $data['origin_name']
        ];
        
        $destination = [
            'type' => 'Point',
            'coordinates' => [(float) $data['destination_lng'], (float) $data['destination_lat']],
            'name' => $data['destination_name']
        ];

        // Create standard waypoints (origin & destination)
        $waypoints = [$origin, $destination];

        $trip = Trip::create([
            'driver_id' => (string) Auth::id(),
            'origin' => $origin,
            'destination' => $destination,
            'waypoints' => $waypoints, // GeoJSON array for $centerSphere search
            'departure_date' => $data['departure_date'],
            'total_capacity' => (float) $data['total_capacity'],
            'available_capacity' => (float) $data['total_capacity'],
            'price_per_ton' => (float) $data['price_per_ton'],
            'status' => Trip::STATUS_SCHEDULED,
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('driver.dashboard')->with('success', 'Trip created successfully.');
    }
}
