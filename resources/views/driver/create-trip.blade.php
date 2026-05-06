@extends('layouts.app')
@section('title', 'Create Trip')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Post a Trip</h1>
        <a href="{{ route('driver.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Cancel</a>
    </div>

    <form action="{{ route('driver.trip.store') }}" method="POST" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        @csrf
        <div class="p-8 space-y-8">
            
            <!-- Routing Section -->
            <div>
                <h3 class="text-lg font-bold text-[#406093] mb-4 border-b border-gray-100 pb-2">1. Route Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <label class="block font-medium text-gray-700">Origin City/Farm</label>
                        <input type="text" name="origin_name" required class="block w-full border-gray-300 rounded-xl shadow-sm focus:ring-[#4C8CE4] focus:border-[#4C8CE4] px-4 py-2 border" placeholder="e.g. Nashik, Maharashtra" value="{{ old('origin_name') }}">
                        <div class="flex gap-2">
                            <input type="number" step="0.000001" name="origin_lat" required class="block w-full border-gray-300 rounded-xl shadow-sm px-4 py-2 border text-sm text-gray-500" placeholder="Lat (e.g. 19.9975)" value="{{ old('origin_lat') }}">
                            <input type="number" step="0.000001" name="origin_lng" required class="block w-full border-gray-300 rounded-xl shadow-sm px-4 py-2 border text-sm text-gray-500" placeholder="Lng (e.g. 73.7898)" value="{{ old('origin_lng') }}">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="block font-medium text-gray-700">Destination</label>
                        <input type="text" name="destination_name" required class="block w-full border-gray-300 rounded-xl shadow-sm focus:ring-[#4C8CE4] focus:border-[#4C8CE4] px-4 py-2 border" placeholder="e.g. Mumbai APMC" value="{{ old('destination_name') }}">
                        <div class="flex gap-2">
                            <input type="number" step="0.000001" name="destination_lat" required class="block w-full border-gray-300 rounded-xl shadow-sm px-4 py-2 border text-sm text-gray-500" placeholder="Lat (e.g. 19.0760)" value="{{ old('destination_lat') }}">
                            <input type="number" step="0.000001" name="destination_lng" required class="block w-full border-gray-300 rounded-xl shadow-sm px-4 py-2 border text-sm text-gray-500" placeholder="Lng (e.g. 72.8777)" value="{{ old('destination_lng') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logistics Section -->
            <div>
                <h3 class="text-lg font-bold text-[#406093] mb-4 border-b border-gray-100 pb-2">2. Logistics & Pricing</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Departure Date & Time</label>
                        <input type="datetime-local" name="departure_date" required class="block w-full border-gray-300 rounded-xl shadow-sm px-4 py-2 border focus:ring-[#4C8CE4]" value="{{ old('departure_date') }}">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Total Capacity (Tons)</label>
                        <input type="number" step="0.1" name="total_capacity" required class="block w-full border-gray-300 rounded-xl shadow-sm px-4 py-2 border focus:ring-[#4C8CE4]" placeholder="e.g. 10.5" value="{{ old('total_capacity') }}">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Price per Ton ($)</label>
                        <input type="number" step="1" name="price_per_ton" required class="block w-full border-gray-300 rounded-xl shadow-sm px-4 py-2 border focus:ring-[#4C8CE4]" placeholder="e.g. 50" value="{{ old('price_per_ton') }}">
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div>
                <h3 class="text-lg font-bold text-[#406093] mb-4 border-b border-gray-100 pb-2">3. Notes (Optional)</h3>
                <textarea name="notes" rows="3" class="block w-full border-gray-300 rounded-xl shadow-sm px-4 py-2 border focus:ring-[#4C8CE4]" placeholder="Any specific requirements? (e.g. Refrigerated truck, no garlic allowed)">{{ old('notes') }}</textarea>
            </div>
            
            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-xl text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
        
        <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex justify-end">
            <button type="submit" class="bg-[#406093] hover:bg-[#324f7d] text-white px-8 py-3 rounded-xl font-bold shadow-md transition-all">
                Publish Trip
            </button>
        </div>
    </form>
</div>
@endsection
