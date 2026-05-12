@extends('farmer.layout')

@section('title', 'FarmLift — Search Trucks')
@section('breadcrumb', 'Search Trucks')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #search-map { height: 300px; border-radius: 0.5rem; z-index: 1; }
    .trip-card { transition: all 0.3s ease; }
    .trip-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(64, 96, 147, 0.12); }
    .loading-spinner {
        border: 3px solid #e3e2e7;
        border-top: 3px solid #406093;
        border-radius: 50%;
        width: 24px; height: 24px;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
<div class="space-y-4">
    <!-- Search Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-h1 text-on-surface">Search Trucks</h1>
            <p class="font-label-sm text-outline mt-1">Find available trucks near your location</p>
        </div>
    </div>

    <!-- Search Controls -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Map Section -->
            <div>
                <label class="font-label-sm text-on-surface-variant font-semibold block mb-2">
                    <span class="material-symbols-outlined text-[16px] align-middle mr-1">pin_drop</span>
                    Pick your location on the map
                </label>
                <div id="search-map" class="border border-outline-variant/30"></div>
                <p class="font-caps-xs text-outline mt-2">Click on the map to set your location</p>
            </div>

            <!-- Filter Controls -->
            <div class="flex flex-col gap-4">
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-2">Search Radius (km)</label>
                    <div class="flex items-center gap-3">
                        <input type="range" id="radius-slider" min="5" max="100" value="30" class="flex-1 accent-[#406093]">
                        <span id="radius-value" class="font-h2 text-primary w-16 text-right">30 km</span>
                    </div>
                </div>
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-2">Minimum Capacity (tons)</label>
                    <input type="number" id="min-capacity" min="0" step="0.5" value="0" placeholder="0"
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-label-sm text-on-surface-variant font-semibold block mb-2">Latitude</label>
                        <input type="text" id="lat-input" readonly placeholder="Click map..."
                            class="w-full border border-outline-variant/30 rounded-lg px-3 py-2 font-label-sm bg-surface-container-low text-outline">
                    </div>
                    <div>
                        <label class="font-label-sm text-on-surface-variant font-semibold block mb-2">Longitude</label>
                        <input type="text" id="lng-input" readonly placeholder="Click map..."
                            class="w-full border border-outline-variant/30 rounded-lg px-3 py-2 font-label-sm bg-surface-container-low text-outline">
                    </div>
                </div>
                <button id="search-btn" onclick="searchTrucks()" disabled
                    class="bg-primary hover:bg-on-primary-fixed-variant text-white px-6 py-3 rounded-lg font-label-sm transition-all duration-200 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed mt-auto">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    Search Available Trucks
                </button>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <div id="results-section" class="hidden">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-h2 text-on-surface">
                Available Trucks
                <span id="results-count" class="font-label-sm text-outline font-normal ml-2"></span>
            </h2>
            <div id="loading-indicator" class="hidden flex items-center gap-2 text-outline">
                <div class="loading-spinner"></div>
                <span class="font-label-sm">Searching...</span>
            </div>
        </div>
        <div id="results-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            <!-- Results populated via JS -->
        </div>
        <div id="no-results" class="hidden bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-8 text-center">
            <span class="material-symbols-outlined text-4xl text-outline/50 mb-2">search_off</span>
            <p class="font-label-sm text-outline">No trucks found in this area</p>
            <p class="font-caps-xs text-outline mt-1">Try increasing the search radius or changing your location</p>
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div id="booking-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeBookingModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md">
        <div class="bg-white rounded-xl shadow-2xl border border-outline-variant/30 overflow-hidden">
            <div class="bg-gradient-to-r from-[#406093] to-[#4C8CE4] p-4">
                <h3 class="font-h2 text-white text-lg">Book This Truck</h3>
                <p id="modal-route" class="font-label-sm text-white/80 mt-1"></p>
            </div>
            <form id="booking-form" method="POST" action="{{ route('farmer.book') }}" class="p-4 space-y-3">
                @csrf
                <input type="hidden" name="trip_id" id="modal-trip-id">
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Produce Type</label>
                    <input type="text" name="produce_type" required placeholder="e.g., Wheat, Rice, Tomatoes"
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                </div>
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Weight (tons)</label>
                    <input type="number" name="weight" required step="0.1" min="0.1" id="modal-weight"
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                    <p class="font-caps-xs text-outline mt-1">Available: <span id="modal-available" class="text-primary font-bold"></span> tons</p>
                </div>
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Pickup Address</label>
                    <input type="text" name="pickup_address" required placeholder="Your farm/pickup location"
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                </div>
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Notes (optional)</label>
                    <textarea name="notes" rows="2" placeholder="Special handling instructions..."
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none resize-none"></textarea>
                </div>
                <div class="bg-surface-container-low rounded-lg p-3">
                    <div class="flex justify-between font-label-sm">
                        <span class="text-outline">Price per ton</span>
                        <span id="modal-price-per-ton" class="text-on-surface font-semibold"></span>
                    </div>
                    <div class="flex justify-between font-label-sm mt-1">
                        <span class="text-outline">Estimated total</span>
                        <span id="modal-total" class="text-primary font-bold"></span>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 bg-primary hover:bg-on-primary-fixed-variant text-white px-4 py-2.5 rounded-lg font-label-sm transition-all duration-200 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        Confirm Booking
                    </button>
                    <button type="button" onclick="closeBookingModal()" class="px-4 py-2.5 rounded-lg font-label-sm border border-outline-variant/30 text-outline hover:bg-surface-container-low transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map, marker, searchCircle;
    let selectedLat = null, selectedLng = null;

    // Initialize Map
    document.addEventListener('DOMContentLoaded', function() {
        map = L.map('search-map').setView([20.5937, 78.9629], 5); // Center of India
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(map);

        map.on('click', function(e) {
            selectedLat = e.latlng.lat.toFixed(6);
            selectedLng = e.latlng.lng.toFixed(6);

            document.getElementById('lat-input').value = selectedLat;
            document.getElementById('lng-input').value = selectedLng;
            document.getElementById('search-btn').disabled = false;

            if (marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map).bindPopup('Your Location').openPopup();

            updateSearchCircle();
        });

        // Try geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                selectedLat = pos.coords.latitude.toFixed(6);
                selectedLng = pos.coords.longitude.toFixed(6);
                map.setView([selectedLat, selectedLng], 10);
                marker = L.marker([selectedLat, selectedLng]).addTo(map).bindPopup('Your Location').openPopup();
                document.getElementById('lat-input').value = selectedLat;
                document.getElementById('lng-input').value = selectedLng;
                document.getElementById('search-btn').disabled = false;
                updateSearchCircle();
            });
        }
    });

    // Radius slider
    document.getElementById('radius-slider').addEventListener('input', function() {
        document.getElementById('radius-value').textContent = this.value + ' km';
        updateSearchCircle();
    });

    function updateSearchCircle() {
        if (!selectedLat || !selectedLng) return;
        const radius = document.getElementById('radius-slider').value * 1000; // km to meters
        if (searchCircle) map.removeLayer(searchCircle);
        searchCircle = L.circle([selectedLat, selectedLng], {
            radius: radius, color: '#4C8CE4', fillColor: '#4C8CE4',
            fillOpacity: 0.08, weight: 2, dashArray: '5,5'
        }).addTo(map);
    }

    // Search trucks
    function searchTrucks() {
        if (!selectedLat || !selectedLng) return;

        const radius = document.getElementById('radius-slider').value;
        const minCapacity = document.getElementById('min-capacity').value || 0;

        document.getElementById('results-section').classList.remove('hidden');
        document.getElementById('loading-indicator').classList.remove('hidden');
        document.getElementById('results-grid').innerHTML = '';
        document.getElementById('no-results').classList.add('hidden');

        fetch(`{{ route('farmer.search') }}?lat=${selectedLat}&lng=${selectedLng}&radius=${radius}&min_capacity=${minCapacity}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('loading-indicator').classList.add('hidden');
            const trips = data.trips || [];
            document.getElementById('results-count').textContent = `(${trips.length} found)`;

            if (trips.length === 0) {
                document.getElementById('no-results').classList.remove('hidden');
                return;
            }

            const grid = document.getElementById('results-grid');
            trips.forEach((trip, idx) => {
                const originName = trip.origin?.name || 'Unknown';
                const destName = trip.destination?.name || 'Unknown';
                const driverName = trip.driver?.name || 'Unknown Driver';
                const capacityPercent = trip.total_capacity > 0 ? Math.round(((trip.total_capacity - trip.available_capacity) / trip.total_capacity) * 100) : 0;
                const departureDate = trip.departure_date ? new Date(trip.departure_date).toLocaleDateString('en-IN', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }) : 'TBD';

                const card = document.createElement('div');
                card.className = 'trip-card bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 flex flex-col gap-2 cursor-pointer';
                card.style.animationDelay = `${idx * 0.05}s`;
                card.innerHTML = `
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <div class="p-1.5 bg-secondary-fixed rounded-md">
                                <span class="material-symbols-outlined text-[#4C8CE4] text-lg">local_shipping</span>
                            </div>
                            <div>
                                <p class="font-label-sm font-bold text-[#406093]">${originName} → ${destName}</p>
                                <p class="font-caps-xs text-outline">${driverName}</p>
                            </div>
                        </div>
                        <span class="font-h2 text-primary text-sm">₹${Math.round(trip.price_per_ton)}<span class="font-caps-xs text-outline">/ton</span></span>
                    </div>
                    <div class="w-full bg-surface-container-highest rounded-full h-1.5 mt-1">
                        <div class="bg-[#4C8CE4] h-1.5 rounded-full" style="width: ${capacityPercent}%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-outline uppercase font-semibold">
                        <span>Capacity</span>
                        <span>${capacityPercent}% Full</span>
                    </div>
                    <div class="flex justify-between items-end mt-1">
                        <div class="flex gap-1 flex-wrap">
                            <span class="px-1.5 py-0.5 bg-tertiary-fixed-dim/20 text-tertiary-container text-[10px] rounded font-semibold border border-tertiary-fixed-dim/30">
                                ${trip.available_capacity} tons avail
                            </span>
                            <span class="px-1.5 py-0.5 bg-surface-variant text-on-surface-variant text-[10px] rounded font-semibold border border-outline-variant/30">
                                ${departureDate}
                            </span>
                        </div>
                    </div>
                    <button onclick="openBookingModal('${trip._id}', '${originName} → ${destName}', ${trip.price_per_ton}, ${trip.available_capacity})"
                        class="mt-1 w-full bg-primary/10 hover:bg-primary text-primary hover:text-white px-3 py-2 rounded-lg font-label-sm transition-all duration-200 flex items-center justify-center gap-1 text-xs">
                        <span class="material-symbols-outlined text-[16px]">book_online</span>
                        Book Now
                    </button>
                `;
                grid.appendChild(card);
            });
        })
        .catch(err => {
            document.getElementById('loading-indicator').classList.add('hidden');
            document.getElementById('no-results').classList.remove('hidden');
            console.error('Search failed:', err);
        });
    }

    // Booking Modal
    let currentPricePerTon = 0;
    function openBookingModal(tripId, route, pricePerTon, available) {
        document.getElementById('booking-modal').classList.remove('hidden');
        document.getElementById('modal-trip-id').value = tripId;
        document.getElementById('modal-route').textContent = route;
        document.getElementById('modal-price-per-ton').textContent = '₹' + Math.round(pricePerTon);
        document.getElementById('modal-available').textContent = available;
        document.getElementById('modal-weight').max = available;
        currentPricePerTon = pricePerTon;
        updateTotal();
    }

    function closeBookingModal() {
        document.getElementById('booking-modal').classList.add('hidden');
    }

    document.getElementById('modal-weight')?.addEventListener('input', updateTotal);
    function updateTotal() {
        const weight = parseFloat(document.getElementById('modal-weight').value) || 0;
        document.getElementById('modal-total').textContent = '₹' + Math.round(weight * currentPricePerTon);
    }
</script>
@endpush
