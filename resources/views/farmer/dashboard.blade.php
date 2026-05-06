@extends('layouts.app')
@section('title', 'Farmer Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="farmerDashboard()">
    
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Farmer Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Search Trips Panel -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="text-blue-500">🌍</span> Find Trucks Nearby
                </h2>
                
                <form @submit.prevent="searchTrips" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Your Latitude</label>
                        <input type="text" x-model="searchForm.lat" class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm focus:ring-blue-500" placeholder="e.g. 28.7041">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Your Longitude</label>
                        <input type="text" x-model="searchForm.lng" class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm focus:ring-blue-500" placeholder="e.g. 77.1025">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Req Capacity (Tons)</label>
                        <input type="number" step="0.1" x-model="searchForm.min_capacity" class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm focus:ring-blue-500" placeholder="0">
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-[#4C8CE4] hover:bg-[#406093] text-white py-2 px-4 rounded-xl font-medium transition-colors shadow-sm flex justify-center items-center h-[38px]">
                            <span x-show="!loading">Search</span>
                            <svg x-show="loading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Search Results -->
            <div x-show="searched" x-cloak>
                <h3 class="text-lg font-bold text-gray-800 mb-3" x-text="`Available Trucks (${trips.length})`"></h3>
                
                <div class="space-y-4">
                    <template x-for="trip in trips" :key="trip._id">
                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 hover:shadow-md transition-shadow">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-medium" x-text="`Driver: ` + (trip.driver ? trip.driver.name : 'Unknown')"></span>
                                    <span class="text-gray-500 text-xs" x-text="new Date(trip.departure_date).toLocaleDateString()"></span>
                                </div>
                                <h4 class="font-bold text-gray-900" x-text="`${trip.origin.name} → ${trip.destination.name}`"></h4>
                                
                                <div class="mt-3 flex items-center gap-4">
                                    <div class="flex-1 max-w-[200px]">
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-gray-500">Capacity</span>
                                            <span class="font-medium text-gray-700" x-text="`${trip.available_capacity}t left`"></span>
                                        </div>
                                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                                            <div class="bg-blue-500 h-1.5 rounded-full" :style="`width: ${(1 - trip.available_capacity/trip.total_capacity) * 100}%`"></div>
                                        </div>
                                    </div>
                                    <div class="text-sm font-medium text-gray-800 bg-gray-50 px-2 py-1 rounded" x-text="`$${trip.price_per_ton}/ton`"></div>
                                </div>
                            </div>
                            <div>
                                <button @click="openBookModal(trip)" class="bg-[#91D06C] hover:bg-[#80bc5e] text-white px-5 py-2 rounded-xl font-medium text-sm shadow-sm transition-colors">
                                    Book Space
                                </button>
                            </div>
                        </div>
                    </template>
                    
                    <div x-show="trips.length === 0" class="text-center py-10 bg-white rounded-2xl border border-gray-100 border-dashed">
                        <p class="text-gray-500">No trucks found matching your criteria.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Panel -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-gray-800">My Shipments</h2>
            
            @forelse($bookings as $booking)
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="absolute right-0 top-0 mt-4 mr-4 flex flex-col items-end">
                        <span class="px-2.5 py-1 text-xs rounded-full font-medium {{ $booking->statusBadgeClass() }}">
                            {{ $booking->statusIcon() }} {{ $booking->status }}
                        </span>
                    </div>
                    
                    <div class="text-xs text-gray-500 mb-1">{{ $booking->created_at->format('M d, Y') }}</div>
                    <h3 class="font-bold text-gray-900 pr-24">{{ $booking->trip->destination_name }}</h3>
                    
                    <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                        <div class="bg-gray-50 p-2 rounded-lg">
                            <div class="text-gray-500 text-xs">Weight</div>
                            <div class="font-medium text-gray-900">{{ $booking->weight }} Tons</div>
                        </div>
                        <div class="bg-gray-50 p-2 rounded-lg">
                            <div class="text-gray-500 text-xs">Cost</div>
                            <div class="font-medium text-gray-900">${{ $booking->price }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded-2xl border border-gray-100 text-center shadow-sm">
                    <p class="text-gray-500 text-sm">You haven't booked any shipments yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Booking Modal -->
    <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="modalOpen = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('farmer.book') }}" method="POST">
                    @csrf
                    <input type="hidden" name="trip_id" :value="selectedTrip?._id">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-xl leading-6 font-bold text-gray-900 mb-4" id="modal-title">Book Space</h3>
                                
                                <div class="bg-blue-50 p-3 rounded-xl mb-4 flex justify-between">
                                    <div>
                                        <span class="block text-xs text-blue-500 font-semibold uppercase">Trip Route</span>
                                        <span class="text-sm text-blue-900 font-bold" x-text="`${selectedTrip?.origin?.name} → ${selectedTrip?.destination?.name}`"></span>
                                    </div>
                                    <div class="text-right">
                                        <span class="block text-xs text-blue-500 font-semibold uppercase">Rate</span>
                                        <span class="text-sm text-blue-900 font-bold" x-text="`$${selectedTrip?.price_per_ton}/ton`"></span>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Payload Weight (Tons)</label>
                                        <input type="number" step="0.1" name="weight" x-model="bookingWeight" :max="selectedTrip?.available_capacity" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                                        <p class="text-xs text-gray-500 mt-1" x-text="`Max available: ${selectedTrip?.available_capacity} tons`"></p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Produce Type</label>
                                        <input type="text" name="produce_type" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border" placeholder="e.g. Tomatoes, Wheat">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Pickup Address</label>
                                        <textarea name="pickup_address" rows="2" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-[#91D06C] text-base font-medium text-white hover:bg-[#80bc5e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#91D06C] sm:ml-3 sm:w-auto sm:text-sm">
                            Confirm Booking
                        </button>
                        <button type="button" @click="modalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function farmerDashboard() {
        return {
            searchForm: {
                lat: '28.6139',
                lng: '77.2090',
                min_capacity: 1
            },
            loading: false,
            searched: false,
            trips: [],
            modalOpen: false,
            selectedTrip: null,
            bookingWeight: 0,
            
            async searchTrips() {
                this.loading = true;
                try {
                    const query = new URLSearchParams(this.searchForm).toString();
                    const response = await fetch(`/farmer/search?${query}`);
                    const data = await response.json();
                    this.trips = data.trips;
                    this.searched = true;
                } catch (error) {
                    console.error('Search failed', error);
                } finally {
                    this.loading = false;
                }
            },
            
            openBookModal(trip) {
                this.selectedTrip = trip;
                this.bookingWeight = trip.available_capacity > 1 ? 1 : trip.available_capacity;
                this.modalOpen = true;
            }
        }
    }
</script>
@endsection
