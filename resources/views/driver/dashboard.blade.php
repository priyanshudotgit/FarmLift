@extends('layouts.app')
@section('title', 'Driver Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Driver Dashboard</h1>
        <a href="{{ route('driver.trip.create') }}" class="bg-[#406093] hover:bg-[#324f7d] text-white px-5 py-2.5 rounded-xl font-medium shadow-sm transition-all flex items-center gap-2">
            <span>+</span> Create Trip
        </a>
    </div>

    <div class="space-y-8">
        @forelse($trips as $trip)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ open: true }">
                
                <!-- Trip Header -->
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gray-50/50">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-2 py-1 text-xs rounded-md font-medium uppercase tracking-wide
                                {{ $trip->status === 'Scheduled' ? 'bg-yellow-100 text-yellow-800' : ($trip->status === 'Active' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                {{ $trip->status }}
                            </span>
                            <span class="text-sm text-gray-500 font-medium">{{ $trip->departure_date->format('M d, Y - h:i A') }}</span>
                        </div>
                        <h2 class="text-xl font-bold text-[#406093] flex items-center gap-2">
                            {{ $trip->origin_name }} 
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg> 
                            {{ $trip->destination_name }}
                        </h2>
                    </div>
                    
                    <div class="flex gap-6 w-full md:w-auto">
                        <div class="flex-1 md:flex-none">
                            <span class="block text-xs text-gray-500 uppercase">Rate</span>
                            <span class="block font-bold text-gray-900">${{ $trip->price_per_ton }}/t</span>
                        </div>
                        <div class="flex-1 md:flex-none">
                            <span class="block text-xs text-gray-500 uppercase">Capacity</span>
                            <span class="block font-bold text-gray-900">{{ $trip->available_capacity }}t <span class="text-gray-400 font-normal">/ {{ $trip->total_capacity }}t</span></span>
                        </div>
                        <div class="flex-1 md:flex-none flex items-center">
                           <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                               <svg class="w-6 h-6 transform transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                           </button>
                        </div>
                    </div>
                </div>

                <!-- Bookings Queue Table -->
                <div x-show="open" x-collapse>
                    <div class="p-6">
                        <h3 class="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wide">Load Manifest ({{ $trip->bookings->count() }})</h3>
                        
                        @if($trip->bookings->isEmpty())
                            <p class="text-sm text-gray-500 italic">No loads booked for this trip yet.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 rounded-lg">
                                        <tr>
                                            <th class="px-4 py-3 rounded-l-lg">Farmer</th>
                                            <th class="px-4 py-3">Produce</th>
                                            <th class="px-4 py-3">Weight</th>
                                            <th class="px-4 py-3">Pickup Location</th>
                                            <th class="px-4 py-3">Status</th>
                                            <th class="px-4 py-3 rounded-r-lg text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($trip->bookings as $booking)
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50">
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $booking->farmer->name }}</td>
                                            <td class="px-4 py-3">{{ $booking->produce_type }}</td>
                                            <td class="px-4 py-3">{{ $booking->weight }}t</td>
                                            <td class="px-4 py-3 text-gray-500 max-w-xs truncate" title="{{ $booking->pickup_address }}">{{ $booking->pickup_address }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 text-xs rounded-md font-medium {{ $booking->statusBadgeClass() }}">
                                                    {{ $booking->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <form action="{{ route('driver.booking.status', $booking) }}" method="POST" class="inline-flex gap-2">
                                                    @csrf
                                                    <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-lg focus:ring-blue-500 py-1 pl-2 pr-6 {{ $booking->status === 'Delivered' || $booking->status === 'Cancelled' ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $booking->status === 'Delivered' || $booking->status === 'Cancelled' ? 'disabled' : '' }}>
                                                        <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="Confirmed" {{ $booking->status == 'Confirmed' ? 'selected' : '' }}>Confirm</option>
                                                        <option value="PickedUp" {{ $booking->status == 'PickedUp' ? 'selected' : '' }}>Picked Up</option>
                                                        <option value="Delivered" {{ $booking->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                                        <option value="Cancelled" {{ $booking->status == 'Cancelled' ? 'selected' : '' }}>Cancel</option>
                                                    </select>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-12 rounded-3xl border border-gray-100 border-dashed text-center">
                <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">🚚</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No active trips</h3>
                <p class="text-gray-500 mb-6">Create a trip to let farmers know you have space available.</p>
                <a href="{{ route('driver.trip.create') }}" class="inline-block bg-[#406093] text-white px-6 py-2 rounded-xl font-medium">Create First Trip</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
