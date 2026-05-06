<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $bookings = Booking::where('farmer_id', $user->_id)
            ->with('trip.driver')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('farmer.dashboard', compact('bookings'));
    }

    public function search(Request $request, SearchService $searchService)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'nullable|numeric|min:1|max:100',
            'min_capacity' => 'nullable|numeric|min:0.1'
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
}
