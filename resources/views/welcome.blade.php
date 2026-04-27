@extends('layouts.app')

@section('content')
<div class="text-center py-20">
    <h1 class="text-5xl font-extrabold text-green-800 mb-6">Connect Farmers to Empty Truck Space</h1>
    <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
        Stop paying for half-empty trucks. Agri-Pool lets farmers book exactly the space they need, while helping transporters maximize their profits.
    </p>

    <div class="flex justify-center gap-4">
        <a href="{{ route('farmer.search') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition">
            I am a Farmer
        </a>
        <a href="{{ route('transporter.trip.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition">
            I am a Transporter
        </a>
    </div>
</div>
@endsection