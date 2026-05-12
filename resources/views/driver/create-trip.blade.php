@extends('driver.layout')

@section('title', 'FarmLift — Post a Trip')
@section('breadcrumb', 'Post Trip')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<style>
    #map { height: 320px; border-radius: 0.5rem; z-index: 1; }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-h1 text-on-surface">Post a New Trip</h1>
            <p class="font-label-sm text-outline mt-1">Create a route for farmers to book</p>
        </div>
        <a href="{{ route('driver.dashboard') }}" class="font-label-sm text-outline hover:text-on-surface transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Back to Dashboard
        </a>
    </div>

    <form action="{{ route('driver.trip.store') }}" method="POST" class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg overflow-hidden">
        @csrf
        <div class="p-6 space-y-6">
            <!-- 1. Route Details -->
            <div>
                <h3 class="font-h2 text-primary text-lg mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">route</span>
                    1. Route Details
                </h3>
                <p class="font-label-sm text-outline mb-3">Search for locations or click on the map to set origin and destination.</p>
                <div id="map" class="border border-outline-variant/30 mb-4"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Origin City/Farm</label>
                        <div class="relative">
                            <input type="text" id="origin_name" name="origin_name" required
                                class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none"
                                placeholder="e.g., Nashik, Maharashtra" value="{{ old('origin_name') }}" autocomplete="off">
                            <div id="origin_results" class="absolute z-20 w-full bg-white mt-1 rounded-lg shadow-lg border border-outline-variant/30 hidden max-h-60 overflow-y-auto"></div>
                        </div>
                        <input type="hidden" id="origin_lat" name="origin_lat" value="{{ old('origin_lat') }}">
                        <input type="hidden" id="origin_lng" name="origin_lng" value="{{ old('origin_lng') }}">
                    </div>
                    <div>
                        <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Destination</label>
                        <div class="relative">
                            <input type="text" id="destination_name" name="destination_name" required
                                class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none"
                                placeholder="e.g., Mumbai APMC" value="{{ old('destination_name') }}" autocomplete="off">
                            <div id="destination_results" class="absolute z-20 w-full bg-white mt-1 rounded-lg shadow-lg border border-outline-variant/30 hidden max-h-60 overflow-y-auto"></div>
                        </div>
                        <input type="hidden" id="destination_lat" name="destination_lat" value="{{ old('destination_lat') }}">
                        <input type="hidden" id="destination_lng" name="destination_lng" value="{{ old('destination_lng') }}">
                    </div>
                </div>
            </div>

            <!-- 2. Logistics & Pricing -->
            <div>
                <h3 class="font-h2 text-primary text-lg mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">inventory_2</span>
                    2. Logistics & Pricing
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Departure Date & Time</label>
                        <input type="datetime-local" name="departure_date" required
                            class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none"
                            value="{{ old('departure_date') }}">
                    </div>
                    <div>
                        <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Total Capacity (Tons)</label>
                        <input type="number" step="0.1" name="total_capacity" required
                            class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none"
                            placeholder="e.g., 10.5" value="{{ old('total_capacity') }}">
                    </div>
                    <div>
                        <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Price per Ton (₹)</label>
                        <input type="number" step="1" name="price_per_ton" required
                            class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none"
                            placeholder="e.g., 500" value="{{ old('price_per_ton') }}">
                    </div>
                </div>
            </div>

            <!-- 3. Notes -->
            <div>
                <h3 class="font-h2 text-primary text-lg mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">notes</span>
                    3. Notes (Optional)
                </h3>
                <textarea name="notes" rows="3"
                    class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none resize-none"
                    placeholder="Any specific requirements? (e.g., Refrigerated truck, special handling)">{{ old('notes') }}</textarea>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg font-label-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="px-6 py-4 bg-surface-container-low/50 border-t border-outline-variant/20 flex justify-end gap-3">
            <a href="{{ route('driver.dashboard') }}" class="px-5 py-2.5 rounded-lg font-label-sm border border-outline-variant/30 text-outline hover:bg-surface-container-low transition-colors">Cancel</a>
            <button type="submit" class="bg-primary hover:bg-on-primary-fixed-variant text-white px-6 py-2.5 rounded-lg font-label-sm font-bold transition-all duration-200 flex items-center gap-2 shadow-md">
                <span class="material-symbols-outlined text-[18px]">publish</span>
                Publish Trip
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('map').setView([20.5937, 78.9629], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(pos => {
                map.setView([pos.coords.latitude, pos.coords.longitude], 8);
            });
        }

        let originMarker = null, destMarker = null, routeLine = null, settingOrigin = true;

        // Geocoder search
        L.Control.geocoder({ defaultMarkGeocode: false, placeholder: "Search for a city or place..." })
            .on('markgeocode', function(e) {
                const bbox = e.geocode.bbox;
                map.fitBounds([[bbox.getSouthEast().lat, bbox.getSouthEast().lng], [bbox.getNorthWest().lat, bbox.getNorthWest().lng]]);
                setLocation(e.geocode.center, e.geocode.name);
            }).addTo(map);

        // Click on map
        map.on('click', function(e) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${e.latlng.lat}&lon=${e.latlng.lng}`)
                .then(res => res.json())
                .then(data => setLocation(e.latlng, data.display_name || `${e.latlng.lat.toFixed(4)}, ${e.latlng.lng.toFixed(4)}`))
                .catch(() => setLocation(e.latlng, `${e.latlng.lat.toFixed(4)}, ${e.latlng.lng.toFixed(4)}`));
        });

        // Toggle control
        const toggleControl = L.control({position: 'topright'});
        toggleControl.onAdd = function() {
            const div = L.DomUtil.create('div', 'leaflet-bar leaflet-control bg-white p-3 shadow-md rounded-lg border border-gray-200');
            div.innerHTML = `
                <div class="flex flex-col gap-2">
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Select mode</p>
                    <label class="flex items-center gap-2 cursor-pointer text-sm font-bold text-gray-700">
                        <input type="radio" name="loc_type" id="radio_origin" value="origin" checked class="accent-blue-500"> Set Origin
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer text-sm font-bold text-gray-700">
                        <input type="radio" name="loc_type" id="radio_dest" value="dest" class="accent-red-500"> Set Destination
                    </label>
                    <button type="button" id="clear_route" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium px-3 py-1.5 rounded-lg">Clear Both</button>
                </div>`;
            L.DomEvent.disableClickPropagation(div);
            return div;
        };
        toggleControl.addTo(map);

        document.querySelectorAll('input[name="loc_type"]').forEach(r => r.addEventListener('change', e => settingOrigin = e.target.value === 'origin'));
        document.getElementById('clear_route').addEventListener('click', () => {
            [originMarker, destMarker, routeLine].forEach(l => l && map.removeLayer(l));
            originMarker = destMarker = routeLine = null;
            ['origin_name','origin_lat','origin_lng','destination_name','destination_lat','destination_lng'].forEach(id => document.getElementById(id).value = '');
            document.getElementById('radio_origin').checked = true;
            settingOrigin = true;
        });

        function setLocation(latlng, name) {
            let shortName = name.includes(',') ? name.split(',').slice(0, 3).join(', ') : name;
            if (settingOrigin) {
                if (originMarker) map.removeLayer(originMarker);
                originMarker = L.marker(latlng, {
                    icon: L.divIcon({ className: '', html: "<div style='background:#4C8CE4;width:18px;height:18px;border-radius:50%;border:3px solid white;box-shadow:0 2px 4px rgba(0,0,0,0.3);'></div>", iconSize: [18,18], iconAnchor: [9,9] })
                }).addTo(map).bindPopup("<b>Origin:</b><br>" + shortName).openPopup();
                document.getElementById('origin_name').value = shortName;
                document.getElementById('origin_lat').value = latlng.lat;
                document.getElementById('origin_lng').value = latlng.lng;
                document.getElementById('radio_dest').checked = true;
                settingOrigin = false;
            } else {
                if (destMarker) map.removeLayer(destMarker);
                destMarker = L.marker(latlng, {
                    icon: L.divIcon({ className: '', html: "<div style='background:#E44C4C;width:18px;height:18px;border-radius:50%;border:3px solid white;box-shadow:0 2px 4px rgba(0,0,0,0.3);'></div>", iconSize: [18,18], iconAnchor: [9,9] })
                }).addTo(map).bindPopup("<b>Destination:</b><br>" + shortName).openPopup();
                document.getElementById('destination_name').value = shortName;
                document.getElementById('destination_lat').value = latlng.lat;
                document.getElementById('destination_lng').value = latlng.lng;
            }
            if (originMarker && destMarker) {
                if (routeLine) map.removeLayer(routeLine);
                routeLine = L.polyline([originMarker.getLatLng(), destMarker.getLatLng()], {color: '#406093', weight: 4, dashArray: '5,10'}).addTo(map);
                map.fitBounds(routeLine.getBounds(), {padding: [50, 50]});
            }
        }

        // Restore old values
        const oLat = document.getElementById('origin_lat').value, oLng = document.getElementById('origin_lng').value;
        const dLat = document.getElementById('destination_lat').value, dLng = document.getElementById('destination_lng').value;
        if (oLat && oLng) { settingOrigin = true; setLocation(L.latLng(oLat, oLng), document.getElementById('origin_name').value || "Origin"); }
        if (dLat && dLng) { settingOrigin = false; setLocation(L.latLng(dLat, dLng), document.getElementById('destination_name').value || "Destination"); }

        // Autocomplete
        function setupAutocomplete(inputId, resultsId, isOrigin) {
            const input = document.getElementById(inputId), results = document.getElementById(resultsId);
            let timeout = null;
            input.addEventListener('input', function() {
                clearTimeout(timeout);
                if (this.value.length < 3) { results.innerHTML = ''; results.classList.add('hidden'); return; }
                timeout = setTimeout(() => {
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.value)}`)
                        .then(r => r.json()).then(data => {
                            results.innerHTML = '';
                            if (data.length > 0) {
                                results.classList.remove('hidden');
                                data.forEach(item => {
                                    const div = document.createElement('div');
                                    div.className = 'px-4 py-3 hover:bg-surface-container-low cursor-pointer font-label-sm border-b border-outline-variant/10 last:border-0 text-on-surface-variant transition-colors';
                                    div.textContent = item.display_name;
                                    div.onclick = function() {
                                        let sn = item.display_name.includes(',') ? item.display_name.split(',').slice(0,3).join(', ') : item.display_name;
                                        input.value = sn; results.innerHTML = ''; results.classList.add('hidden');
                                        settingOrigin = isOrigin;
                                        const ll = L.latLng(item.lat, item.lon);
                                        map.setView(ll, 10);
                                        setLocation(ll, sn);
                                    };
                                    results.appendChild(div);
                                });
                            } else results.classList.add('hidden');
                        });
                }, 500);
            });
            document.addEventListener('click', e => { if (e.target !== input && !results.contains(e.target)) results.classList.add('hidden'); });
        }
        setupAutocomplete('origin_name', 'origin_results', true);
        setupAutocomplete('destination_name', 'destination_results', false);
    });
</script>
@endpush
