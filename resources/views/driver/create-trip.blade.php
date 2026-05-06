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
                
                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-2">Search for locations on the map or click to set origin and destination.</p>
                    <div id="map" class="w-full h-80 rounded-xl border border-gray-300 z-10 relative"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <label class="block font-medium text-gray-700">Origin City/Farm</label>
                        <div class="relative">
                            <input type="text" id="origin_name" name="origin_name" required class="block w-full border-gray-300 rounded-xl shadow-sm focus:ring-[#4C8CE4] focus:border-[#4C8CE4] px-4 py-2 border" placeholder="e.g. Nashik, Maharashtra" value="{{ old('origin_name') }}" autocomplete="off">
                            <div id="origin_results" class="absolute z-20 w-full bg-white mt-1 rounded-xl shadow-lg border border-gray-100 hidden max-h-60 overflow-y-auto"></div>
                        </div>
                        
                        <input type="hidden" id="origin_lat" name="origin_lat" value="{{ old('origin_lat') }}">
                        <input type="hidden" id="origin_lng" name="origin_lng" value="{{ old('origin_lng') }}">
                    </div>

                    <div class="space-y-4">
                        <label class="block font-medium text-gray-700">Destination</label>
                        <div class="relative">
                            <input type="text" id="destination_name" name="destination_name" required class="block w-full border-gray-300 rounded-xl shadow-sm focus:ring-[#4C8CE4] focus:border-[#4C8CE4] px-4 py-2 border" placeholder="e.g. Mumbai APMC" value="{{ old('destination_name') }}" autocomplete="off">
                            <div id="destination_results" class="absolute z-20 w-full bg-white mt-1 rounded-xl shadow-lg border border-gray-100 hidden max-h-60 overflow-y-auto"></div>
                        </div>
                        
                        <input type="hidden" id="destination_lat" name="destination_lat" value="{{ old('destination_lat') }}">
                        <input type="hidden" id="destination_lng" name="destination_lng" value="{{ old('destination_lng') }}">
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

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Init map (centered around central India initially)
        const map = L.map('map').setView([20.5937, 78.9629], 5);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Try getting user's location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                map.setView([position.coords.latitude, position.coords.longitude], 8);
            });
        }

        let originMarker = null;
        let destMarker = null;
        let routeLine = null;
        let settingOrigin = true; // true = setting origin, false = setting destination

        // Add geocoder control (search bar)
        const geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: "Search for a city or place..."
        })
        .on('markgeocode', function(e) {
            const bbox = e.geocode.bbox;
            map.fitBounds([
                [bbox.getSouthEast().lat, bbox.getSouthEast().lng],
                [bbox.getNorthWest().lat, bbox.getNorthWest().lng]
            ]);
            
            setLocation(e.geocode.center, e.geocode.name);
        })
        .addTo(map);

        // Click on map to set location
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    const name = data.display_name || `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                    setLocation(e.latlng, name);
                })
                .catch(err => {
                    console.error("Reverse geocoding failed", err);
                    setLocation(e.latlng, `${lat.toFixed(4)}, ${lng.toFixed(4)}`);
                });
        });

        // Toggle control for Origin vs Destination
        const toggleControl = L.control({position: 'topright'});
        toggleControl.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom bg-white p-3 shadow-md rounded-xl border border-gray-200');
            div.innerHTML = `
                <div class="flex flex-col gap-3">
                    <p class="text-xs text-gray-500 font-medium mb-1 uppercase tracking-wide">Select mode</p>
                    <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                        <input type="radio" name="loc_type" id="radio_origin" value="origin" checked class="form-radio text-blue-500 w-4 h-4"> 
                        <span class="text-sm font-bold text-gray-700">Set Origin</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                        <input type="radio" name="loc_type" id="radio_dest" value="dest" class="form-radio text-red-500 w-4 h-4"> 
                        <span class="text-sm font-bold text-gray-700">Set Destination</span>
                    </label>
                    <button type="button" id="clear_route" class="mt-1 w-full text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium px-3 py-1.5 rounded-lg transition-colors">Clear Both</button>
                </div>
            `;
            L.DomEvent.disableClickPropagation(div);
            return div;
        };
        toggleControl.addTo(map);

        document.querySelectorAll('input[name="loc_type"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                settingOrigin = e.target.value === 'origin';
            });
        });

        document.getElementById('clear_route').addEventListener('click', () => {
            if (originMarker) map.removeLayer(originMarker);
            if (destMarker) map.removeLayer(destMarker);
            if (routeLine) map.removeLayer(routeLine);
            originMarker = null;
            destMarker = null;
            routeLine = null;
            
            document.getElementById('origin_name').value = '';
            document.getElementById('origin_lat').value = '';
            document.getElementById('origin_lng').value = '';
            document.getElementById('destination_name').value = '';
            document.getElementById('destination_lat').value = '';
            document.getElementById('destination_lng').value = '';
            
            document.getElementById('radio_origin').checked = true;
            settingOrigin = true;
        });

        function setLocation(latlng, name) {
            // Simplify address name for display
            let shortName = name;
            if (name.includes(',')) {
                shortName = name.split(',').slice(0, 3).join(', ');
            }

            if (settingOrigin) {
                if (originMarker) map.removeLayer(originMarker);
                originMarker = L.marker(latlng, {
                    icon: L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:#4C8CE4;width:18px;height:18px;border-radius:50%;border:3px solid white;box-shadow:0 2px 4px rgba(0,0,0,0.3);'></div>",
                        iconSize: [18, 18],
                        iconAnchor: [9, 9]
                    })
                }).addTo(map).bindPopup("<b>Origin:</b><br>" + shortName).openPopup();
                
                document.getElementById('origin_name').value = shortName;
                document.getElementById('origin_lat').value = latlng.lat;
                document.getElementById('origin_lng').value = latlng.lng;
                
                // Switch to destination mode automatically
                document.getElementById('radio_dest').checked = true;
                settingOrigin = false;
            } else {
                if (destMarker) map.removeLayer(destMarker);
                destMarker = L.marker(latlng, {
                    icon: L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:#E44C4C;width:18px;height:18px;border-radius:50%;border:3px solid white;box-shadow:0 2px 4px rgba(0,0,0,0.3);'></div>",
                        iconSize: [18, 18],
                        iconAnchor: [9, 9]
                    })
                }).addTo(map).bindPopup("<b>Destination:</b><br>" + shortName).openPopup();
                
                document.getElementById('destination_name').value = shortName;
                document.getElementById('destination_lat').value = latlng.lat;
                document.getElementById('destination_lng').value = latlng.lng;
            }

            // Draw line if both exist
            if (originMarker && destMarker) {
                if (routeLine) map.removeLayer(routeLine);
                const latlngs = [originMarker.getLatLng(), destMarker.getLatLng()];
                routeLine = L.polyline(latlngs, {color: '#406093', weight: 4, dashArray: '5, 10'}).addTo(map);
                map.fitBounds(routeLine.getBounds(), {padding: [50, 50]});
            }
        }
        
        // Restore markers if editing / validation fails
        const oLat = document.getElementById('origin_lat').value;
        const oLng = document.getElementById('origin_lng').value;
        const oName = document.getElementById('origin_name').value;
        
        const dLat = document.getElementById('destination_lat').value;
        const dLng = document.getElementById('destination_lng').value;
        const dName = document.getElementById('destination_name').value;
        
        if (oLat && oLng) {
            settingOrigin = true;
            setLocation(L.latLng(oLat, oLng), oName || "Origin");
        }
        if (dLat && dLng) {
            settingOrigin = false;
            setLocation(L.latLng(dLat, dLng), dName || "Destination");
        }

        // Setup Autocomplete Search
        function setupAutocomplete(inputId, resultsId, isOrigin) {
            const input = document.getElementById(inputId);
            const results = document.getElementById(resultsId);
            let timeout = null;

            input.addEventListener('input', function() {
                clearTimeout(timeout);
                const query = this.value;
                if (query.length < 3) {
                    results.innerHTML = '';
                    results.classList.add('hidden');
                    return;
                }

                timeout = setTimeout(() => {
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            results.innerHTML = '';
                            if (data.length > 0) {
                                results.classList.remove('hidden');
                                data.forEach(item => {
                                    const div = document.createElement('div');
                                    div.className = 'px-4 py-3 hover:bg-gray-50 cursor-pointer text-sm border-b border-gray-50 last:border-0 text-gray-700 transition-colors';
                                    div.textContent = item.display_name;
                                    div.onclick = function() {
                                        let shortName = item.display_name;
                                        if (shortName.includes(',')) {
                                            shortName = shortName.split(',').slice(0, 3).join(', ');
                                        }
                                        input.value = shortName;
                                        results.innerHTML = '';
                                        results.classList.add('hidden');
                                        
                                        settingOrigin = isOrigin;
                                        const latlng = L.latLng(item.lat, item.lon);
                                        map.setView(latlng, 10);
                                        setLocation(latlng, shortName);
                                    };
                                    results.appendChild(div);
                                });
                            } else {
                                results.classList.add('hidden');
                            }
                        });
                }, 500);
            });

            document.addEventListener('click', function(e) {
                if (e.target !== input && e.target !== results && !results.contains(e.target)) {
                    results.classList.add('hidden');
                }
            });
        }

        setupAutocomplete('origin_name', 'origin_results', true);
        setupAutocomplete('destination_name', 'destination_results', false);
    });
</script>
@endsection
