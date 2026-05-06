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
                
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-2">Set your location on the map to find nearby trucks.</p>
                    <div id="farmer-map" class="w-full h-64 rounded-xl border border-gray-300 z-10 relative"></div>
                </div>

                <form @submit.prevent="searchTrips" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Your Location</label>
                        <div class="flex gap-2">
                            <div class="flex-1 relative">
                                <input type="text" id="farmer_loc_name" class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm focus:ring-blue-500" placeholder="Type to search or click map" autocomplete="off" @input.debounce.500ms="searchLocation($event.target.value)" @focus="showResults = true">
                                <div x-show="showResults && searchResults.length > 0" @click.away="showResults = false" class="absolute z-20 w-full bg-white mt-1 rounded-xl shadow-lg border border-gray-100 max-h-60 overflow-y-auto" x-cloak style="display: none;">
                                    <template x-for="result in searchResults" :key="result.place_id || Math.random()">
                                        <div @click="selectLocation(result)" class="px-4 py-3 hover:bg-gray-50 cursor-pointer text-sm border-b border-gray-50 last:border-0 text-gray-700 transition-colors" x-text="result.display_name"></div>
                                    </template>
                                </div>
                            </div>
                            <button type="button" id="my_location_btn" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-xl text-sm border border-gray-300 transition-colors flex-shrink-0" title="Use My Location">📍</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Req Capacity (Tons)</label>
                        <input type="number" step="0.1" x-model="searchForm.min_capacity" class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm focus:ring-blue-500" placeholder="e.g. 5">
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-[#4C8CE4] hover:bg-[#406093] text-white py-2 px-4 rounded-xl font-medium transition-colors shadow-sm flex justify-center items-center h-[38px]">
                            <span x-show="!loading">Search Trucks</span>
                            <svg x-show="loading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
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
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div @click.away="modalOpen = false" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
                <form action="{{ route('farmer.book') }}" method="POST">
                    @csrf
                    <input type="hidden" name="trip_id" :value="selectedTrip?._id || selectedTrip?.id">
                    
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
                lat: '',
                lng: '',
                min_capacity: ''
            },
            loading: false,
            searched: false,
            trips: [],
            modalOpen: false,
            selectedTrip: null,
            bookingWeight: 0,
            map: null,
            farmerMarker: null,
            truckMarkers: [],
            searchResults: [],
            showResults: false,
            
            init() {
                // Initialize map after x-data is ready and DOM is loaded
                setTimeout(() => {
                    this.initMap();
                }, 100);
            },
            
            initMap() {
                this.map = L.map('farmer-map').setView([20.5937, 78.9629], 5);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(this.map);

                // Add geocoder control
                const geocoder = L.Control.geocoder({
                    defaultMarkGeocode: false,
                    placeholder: "Search your farm/city location..."
                })
                .on('markgeocode', (e) => {
                    const latlng = e.geocode.center;
                    this.setFarmerLocation(latlng.lat, latlng.lng, e.geocode.name);
                    this.map.setView(latlng, 10);
                })
                .addTo(this.map);

                // Click on map to set location
                this.map.on('click', (e) => {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;
                    
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                        .then(res => res.json())
                        .then(data => {
                            const name = data.display_name || `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                            this.setFarmerLocation(lat, lng, name);
                        })
                        .catch(err => {
                            this.setFarmerLocation(lat, lng, `${lat.toFixed(4)}, ${lng.toFixed(4)}`);
                        });
                });

                document.getElementById('my_location_btn').addEventListener('click', () => {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(position => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            this.setFarmerLocation(lat, lng, "My Location");
                            this.map.setView([lat, lng], 10);
                        });
                    } else {
                        alert("Geolocation is not supported by this browser.");
                    }
                });

                // Try getting user's location initially
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(position => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        this.setFarmerLocation(lat, lng, "My Location");
                        this.map.setView([lat, lng], 10);
                    });
                }
            },
            
            setFarmerLocation(lat, lng, name) {
                this.searchForm.lat = lat;
                this.searchForm.lng = lng;
                
                let shortName = name;
                if (name.includes(',')) {
                    shortName = name.split(',').slice(0, 3).join(', ');
                }
                document.getElementById('farmer_loc_name').value = shortName;

                if (this.farmerMarker) {
                    this.map.removeLayer(this.farmerMarker);
                }
                
                this.farmerMarker = L.marker([lat, lng], {
                    icon: L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:#91D06C;width:18px;height:18px;border-radius:50%;border:3px solid white;box-shadow:0 2px 4px rgba(0,0,0,0.3);'></div>",
                        iconSize: [18, 18],
                        iconAnchor: [9, 9]
                    })
                }).addTo(this.map).bindPopup("<b>Your Location</b><br>" + shortName).openPopup();
            },

            async searchLocation(query) {
                if (query.length < 3) {
                    this.searchResults = [];
                    return;
                }
                try {
                    const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
                    this.searchResults = await res.json();
                    this.showResults = true;
                } catch (e) {
                    console.error("Search failed", e);
                }
            },
            
            selectLocation(result) {
                let shortName = result.display_name;
                if (shortName.includes(',')) {
                    shortName = shortName.split(',').slice(0, 3).join(', ');
                }
                
                document.getElementById('farmer_loc_name').value = shortName;
                this.showResults = false;
                this.searchResults = [];
                
                const lat = result.lat;
                const lng = result.lon; // Note: Nominatim uses lon, not lng
                
                this.map.setView([lat, lng], 10);
                this.setFarmerLocation(lat, lng, shortName);
            },
            
            async searchTrips() {
                if (!this.searchForm.lat || !this.searchForm.lng) {
                    alert("Please select your location on the map first.");
                    return;
                }
                
                this.loading = true;
                try {
                    const query = new URLSearchParams(this.searchForm).toString();
                    const response = await fetch(`/farmer/search?${query}`);
                    const data = await response.json();
                    this.trips = data.trips;
                    this.searched = true;
                    
                    this.plotTrucks();
                } catch (error) {
                    console.error('Search failed', error);
                } finally {
                    this.loading = false;
                }
            },
            
            plotTrucks() {
                // Clear existing truck markers
                this.truckMarkers.forEach(marker => this.map.removeLayer(marker));
                this.truckMarkers = [];
                
                const bounds = L.latLngBounds();
                if (this.farmerMarker) bounds.extend(this.farmerMarker.getLatLng());
                
                this.trips.forEach(trip => {
                    if (trip.origin && trip.origin.coordinates) {
                        const lat = trip.origin.coordinates[1]; // MongoDB [lng, lat]
                        const lng = trip.origin.coordinates[0];
                        
                        const marker = L.marker([lat, lng], {
                            icon: L.divIcon({
                                className: 'custom-div-icon',
                                html: "<div style='background-color:#406093;width:24px;height:24px;border-radius:50%;border:2px solid white;box-shadow:0 2px 4px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;'><span style='font-size:12px;'>🚚</span></div>",
                                iconSize: [24, 24],
                                iconAnchor: [12, 12]
                            })
                        }).addTo(this.map);
                        
                        // We attach a click event inside popup to open the booking modal
                        const popupContent = `
                            <div class="p-1">
                                <b class="text-sm block mb-1">${trip.origin.name} &rarr; ${trip.destination.name}</b>
                                <span class="text-xs text-gray-600 block mb-2">Available: ${trip.available_capacity} tons</span>
                                <button onclick="document.querySelector('[x-data]').__x.$data.openBookModalById('${trip._id || trip.id}')" class="bg-[#91D06C] text-white px-3 py-1 rounded-lg text-xs w-full font-medium hover:bg-[#80bc5e] transition-colors shadow-sm">Book Space</button>
                            </div>
                        `;
                        marker.bindPopup(popupContent);
                        
                        this.truckMarkers.push(marker);
                        bounds.extend([lat, lng]);
                    }
                });
                
                if (this.truckMarkers.length > 0) {
                    this.map.fitBounds(bounds, {padding: [50, 50], maxZoom: 12});
                }
            },
            
            openBookModalById(tripId) {
                const trip = this.trips.find(t => (t._id || t.id) === tripId);
                if (trip) {
                    this.openBookModal(trip);
                    this.map.closePopup();
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

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
@endsection
