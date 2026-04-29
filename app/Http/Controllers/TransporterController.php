<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;

class TransporterController extends Controller
{
    public function create()
    {
        return view('transporter.create-trip');
    }

    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date|after:today',
            'total_capacity' => 'required|numeric|min:100',
            'price_per_kg' => 'required|numeric|min:1',
        ]);

        Trip::create([
            'transporter_id' => 'dummy_transporter_123', 
            'origin' => $request->origin,
            'destination' => $request->destination,
            'departure_date' => $request->departure_date,
            'capacity' => [
                'total_kg' => (int) $request->total_capacity,
                'available_kg' => (int) $request->total_capacity,
            ],
            'price_per_kg' => (float) $request->price_per_kg,
            'status' => 'active'
        ]);

        return redirect()->route('transporter.trip.create')
                         ->with('success', 'Trip successfully posted to the network!');
    }
}