<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Http\Requests\StoreTripRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $trips = Trip::where('driver_id', $user->_id)
            ->with(['bookings.farmer'])
            ->orderBy('departure_date', 'desc')
            ->get();

        return view('driver.dashboard', compact('trips'));
    }

    public function createTrip()
    {
        return view('driver.create-trip');
    }

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
            'driver_id' => Auth::id(),
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
