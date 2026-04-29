@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Post a New Trip</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('transporter.trip.store') }}" method="POST">
        @csrf <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Origin (City/Village)</label>
                <input type="text" name="origin" value="{{ old('origin') }}" class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-green-300">
                @error('origin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Destination Market</label>
                <input type="text" name="destination" value="{{ old('destination') }}" class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-green-300">
                @error('destination') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Departure Date</label>
            <input type="date" name="departure_date" value="{{ old('departure_date') }}" class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-green-300">
            @error('departure_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Total Capacity (kg)</label>
                <input type="number" name="total_capacity" value="{{ old('total_capacity') }}" class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-green-300">
                @error('total_capacity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Price per kg (₹)</label>
                <input type="number" step="0.5" name="price_per_kg" value="{{ old('price_per_kg') }}" class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-green-300">
                @error('price_per_kg') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded hover:bg-green-700 transition duration-300">
            Publish Trip
        </button>
    </form>
</div>
@endsection