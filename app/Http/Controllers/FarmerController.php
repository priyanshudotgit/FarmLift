<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\FarmerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class FarmerController extends Controller
{
    /**
     * Farmer Dashboard – bento grid with real data from the database.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $bookings = Booking::where('farmer_id', $user->_id)
            ->with('trip.driver')
            ->orderBy('created_at', 'desc')
            ->get();

        // Loads currently in transit (PickedUp status)
        $inTransitCount = $bookings->where('status', Booking::STATUS_PICKED_UP)->count();

        // Total money spent across all bookings (excluding cancelled)
        $totalSpent = $bookings->whereNotIn('status', [Booking::STATUS_CANCELLED])->sum('price');

        // Next upcoming pickup (confirmed booking with earliest departure)
        $nextPickup = Booking::where('farmer_id', $user->_id)
            ->where('status', Booking::STATUS_CONFIRMED)
            ->with('trip')
            ->get()
            ->filter(fn($b) => $b->trip && $b->trip->departure_date && $b->trip->departure_date->isFuture())
            ->sortBy(fn($b) => $b->trip->departure_date)
            ->first();

        // Total bookings count
        $totalBookings = $bookings->count();

        // Recent bookings (last 5 for the sidebar)
        $recentBookings = $bookings->take(5);

        // Active/scheduled trips (for the "Active Trucks Near You" section)
        $activeTrips = Trip::where('status', Trip::STATUS_SCHEDULED)
            ->where('available_capacity', '>', 0)
            ->with('driver')
            ->orderBy('departure_date', 'asc')
            ->take(4)
            ->get();

        return view('farmer.dashboard', compact(
            'bookings',
            'inTransitCount',
            'totalSpent',
            'nextPickup',
            'totalBookings',
            'recentBookings',
            'activeTrips'
        ));
    }

    /**
     * Search trucks page – renders the search view (GET without params)
     * or returns JSON results (GET with lat/lng params).
     */
    public function search(Request $request, SearchService $searchService)
    {
        // If it's an AJAX/JSON request with coordinates, return search results
        if ($request->has('lat') && $request->has('lng')) {
            $request->validate([
                'lat' => 'required|numeric',
                'lng' => 'required|numeric',
                'radius' => 'nullable|numeric|min:1|max:100',
                'min_capacity' => 'nullable|numeric|min:0'
            ]);

            $radius = $request->input('radius', 30);
            $minCapacity = $request->input('min_capacity', 0);

            $trips = $searchService->findTripsNearby(
                (float) $request->lng, 
                (float) $request->lat, 
                (float) $radius, 
                (float) $minCapacity
            );

            return response()->json([
                'trips' => $trips
            ]);
        }

        // Otherwise, render the search page
        return view('farmer.search');
    }

    /**
     * My Bookings page – shows all bookings for the authenticated farmer.
     */
    public function bookings()
    {
        $user = Auth::user();

        $bookings = Booking::where('farmer_id', $user->_id)
            ->with('trip.driver')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('farmer.bookings', compact('bookings'));
    }

    /**
     * Profile page – shows and allows editing of farmer profile.
     */
    public function profile()
    {
        $user = Auth::user();
        $profile = $user->farmerProfile;

        $allBookings = Booking::where('farmer_id', $user->_id)->get();

        $stats = [
            'total_bookings' => $allBookings->count(),
            'delivered' => $allBookings->where('status', Booking::STATUS_DELIVERED)->count(),
            'total_weight' => $allBookings->whereNotIn('status', [Booking::STATUS_CANCELLED])->sum('weight'),
            'total_spent' => $allBookings->whereNotIn('status', [Booking::STATUS_CANCELLED])->sum('price'),
        ];

        return view('farmer.profile', compact('user', 'profile', 'stats'));
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
     * Update farm details.
     */
    public function updateFarm(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'farm_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'gst_number' => 'nullable|string|max:20',
        ]);

        $profile = FarmerProfile::firstOrCreate(
            ['user_id' => $user->_id],
            []
        );

        $profile->update($request->only('farm_name', 'address', 'gst_number'));

        return back()->with('success', 'Farm details updated successfully.');
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
}
