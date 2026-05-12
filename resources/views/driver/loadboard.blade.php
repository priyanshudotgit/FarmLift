@extends('driver.layout')

@section('title', 'FarmLift — Load Board')
@section('breadcrumb', 'Load Board')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-h1 text-on-surface">Load Board</h1>
            <p class="font-label-sm text-outline mt-1">Manage your trips and associated bookings</p>
        </div>
        <a href="{{ route('driver.trip.create') }}" class="bg-primary hover:bg-on-primary-fixed-variant text-white px-5 py-2.5 rounded-lg font-label-sm transition-all duration-200 flex items-center gap-2 shadow-md">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            Create New Trip
        </a>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1">
        <button onclick="filterTrips('all')" class="filter-btn active px-4 py-2 rounded-full font-label-sm transition-all duration-200 border" data-filter="all">All ({{ $trips->count() }})</button>
        <button onclick="filterTrips('Scheduled')" class="filter-btn px-4 py-2 rounded-full font-label-sm transition-all duration-200 border" data-filter="Scheduled">📅 Scheduled ({{ $trips->where('status', 'Scheduled')->count() }})</button>
        <button onclick="filterTrips('Active')" class="filter-btn px-4 py-2 rounded-full font-label-sm transition-all duration-200 border" data-filter="Active">🚚 Active ({{ $trips->where('status', 'Active')->count() }})</button>
        <button onclick="filterTrips('Completed')" class="filter-btn px-4 py-2 rounded-full font-label-sm transition-all duration-200 border" data-filter="Completed">✅ Completed ({{ $trips->where('status', 'Completed')->count() }})</button>
    </div>

    <!-- Trips List -->
    <div class="space-y-4" id="trips-list">
        @forelse($trips as $trip)
            <div class="trip-card bg-surface-container-lowest border border-outline-variant/30 rounded-lg overflow-hidden hover:shadow-md hover:border-[#4C8CE4]/30 transition-all duration-300"
                 data-status="{{ $trip->status }}">
                <!-- Trip Header -->
                <div class="p-4 flex flex-col md:flex-row md:items-center justify-between gap-3 border-b border-outline-variant/20">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-gradient-to-br from-[#4C8CE4]/10 to-[#406093]/10 rounded-xl">
                            <span class="material-symbols-outlined text-[#406093]">route</span>
                        </div>
                        <div>
                            <h3 class="font-label-sm font-bold text-on-surface text-lg">{{ $trip->origin_name }} → {{ $trip->destination_name }}</h3>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="font-caps-xs text-outline flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">calendar_today</span>
                                    {{ $trip->departure_date->format('M d, Y · H:i') }}
                                </span>
                                <span class="font-caps-xs text-primary flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">payments</span>
                                    ₹{{ number_format($trip->price_per_ton, 0) }}/ton
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        @php
                            $tripStatusClass = match($trip->status) {
                                'Scheduled' => 'status-scheduled',
                                'Active' => 'status-active',
                                'Completed' => 'status-completed',
                                default => 'status-scheduled',
                            };
                        @endphp
                        <span class="px-3 py-1.5 rounded-full font-caps-xs {{ $tripStatusClass }}">{{ $trip->status }}</span>
                    </div>
                </div>

                <!-- Trip Details Grid -->
                <div class="p-4 grid grid-cols-2 sm:grid-cols-4 gap-4 bg-surface-container-low/30">
                    <div>
                        <span class="font-caps-xs text-outline block">Total Capacity</span>
                        <span class="font-label-sm text-on-surface font-semibold">{{ $trip->total_capacity }} tons</span>
                    </div>
                    <div>
                        <span class="font-caps-xs text-outline block">Available</span>
                        <span class="font-label-sm text-primary font-semibold">{{ $trip->available_capacity }} tons</span>
                    </div>
                    <div>
                        <span class="font-caps-xs text-outline block">Bookings</span>
                        <span class="font-label-sm text-on-surface font-semibold">{{ $trip->bookings->count() }}</span>
                    </div>
                    <div>
                        <span class="font-caps-xs text-outline block">Revenue</span>
                        <span class="font-label-sm text-[#91D06C] font-semibold">₹{{ number_format($trip->bookings->whereNotIn('status', ['Cancelled'])->sum('price'), 0) }}</span>
                    </div>
                </div>

                <!-- Capacity Bar -->
                <div class="px-4 py-2 border-t border-outline-variant/10">
                    <div class="flex justify-between text-[10px] text-outline uppercase font-semibold mb-1">
                        <span>Load Utilization</span>
                        <span>{{ $trip->capacity_percent }}% Filled</span>
                    </div>
                    <div class="w-full h-2.5 bg-surface-container-highest rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-[#4C8CE4] to-[#91D06C] rounded-full transition-all duration-700" style="width: {{ $trip->capacity_percent }}%"></div>
                    </div>
                </div>

                <!-- Bookings Table -->
                @if($trip->bookings->count() > 0)
                    <div class="border-t border-outline-variant/20">
                        <div class="px-4 py-2 bg-surface-container-low/50 flex items-center justify-between">
                            <span class="font-caps-xs text-outline uppercase">Booking Details</span>
                            <span class="font-caps-xs text-outline">{{ $trip->bookings->count() }} total</span>
                        </div>
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="font-caps-xs text-on-surface-variant border-b border-outline-variant/20 bg-surface-container-low/30">
                                    <th class="p-2.5 pl-4 font-semibold">Farmer</th>
                                    <th class="p-2.5 font-semibold">Produce</th>
                                    <th class="p-2.5 font-semibold">Weight</th>
                                    <th class="p-2.5 font-semibold">Price</th>
                                    <th class="p-2.5 font-semibold">Status</th>
                                    <th class="p-2.5 pr-4 font-semibold text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="font-label-sm divide-y divide-outline-variant/10">
                                @foreach($trip->bookings as $booking)
                                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                                        <td class="p-2.5 pl-4 text-on-surface">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-[#FDFBD4] to-[#91D06C] flex items-center justify-center text-[10px] font-bold text-[#406093]">
                                                    {{ strtoupper(substr($booking->farmer->name ?? '?', 0, 2)) }}
                                                </div>
                                                {{ $booking->farmer->name ?? 'Unknown' }}
                                            </div>
                                        </td>
                                        <td class="p-2.5 text-on-surface-variant">{{ $booking->produce_type ?? '—' }}</td>
                                        <td class="p-2.5 text-on-surface-variant">{{ $booking->weight }} t</td>
                                        <td class="p-2.5 text-primary font-semibold">₹{{ number_format($booking->price, 0) }}</td>
                                        <td class="p-2.5">
                                            @php
                                                $bStatusClass = match($booking->status) {
                                                    'Pending' => 'status-pending',
                                                    'Confirmed' => 'status-confirmed',
                                                    'PickedUp' => 'status-pickedup',
                                                    'Delivered' => 'status-delivered',
                                                    'Cancelled' => 'status-cancelled',
                                                    default => 'status-pending',
                                                };
                                            @endphp
                                            <span class="px-2 py-0.5 rounded font-caps-xs {{ $bStatusClass }}">{{ $booking->status === 'PickedUp' ? 'In Transit' : $booking->status }}</span>
                                        </td>
                                        <td class="p-2.5 pr-4 text-right">
                                            @if($booking->status === 'Pending')
                                                <div class="flex gap-1 justify-end">
                                                    <form method="POST" action="{{ route('driver.booking.status', $booking) }}" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Confirmed">
                                                        <button type="submit" class="bg-[#91D06C] text-white px-3 py-1 rounded text-[11px] font-semibold hover:opacity-90 transition-opacity">Confirm</button>
                                                    </form>
                                                    <form method="POST" action="{{ route('driver.booking.status', $booking) }}" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Cancelled">
                                                        <button type="submit" class="bg-red-100 text-red-600 px-3 py-1 rounded text-[11px] font-semibold hover:bg-red-200 transition-colors">Reject</button>
                                                    </form>
                                                </div>
                                            @elseif($booking->status === 'Confirmed')
                                                <form method="POST" action="{{ route('driver.booking.status', $booking) }}" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="PickedUp">
                                                    <button type="submit" class="bg-[#4C8CE4] text-white px-3 py-1 rounded text-[11px] font-semibold hover:opacity-90 transition-opacity">Mark Picked Up</button>
                                                </form>
                                            @elseif($booking->status === 'PickedUp')
                                                <form method="POST" action="{{ route('driver.booking.status', $booking) }}" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Delivered">
                                                    <button type="submit" class="bg-primary text-white px-3 py-1 rounded text-[11px] font-semibold hover:opacity-90 transition-opacity">Mark Delivered</button>
                                                </form>
                                            @elseif($booking->status === 'Delivered')
                                                <span class="font-caps-xs text-[#91D06C]">✓ Complete</span>
                                            @else
                                                <span class="font-caps-xs text-outline">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- Trip Notes -->
                @if($trip->notes)
                    <div class="px-4 py-2 border-t border-outline-variant/10 bg-surface-container-low/20">
                        <span class="font-caps-xs text-outline">Notes:</span>
                        <span class="font-label-sm text-on-surface-variant ml-1">{{ $trip->notes }}</span>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-12 text-center">
                <span class="material-symbols-outlined text-5xl text-outline/40 mb-3 block">local_shipping</span>
                <h3 class="font-h2 text-on-surface mb-1">No trips posted yet</h3>
                <p class="font-label-sm text-outline mb-4">Start by creating your first trip route</p>
                <a href="{{ route('driver.trip.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-on-primary-fixed-variant text-white px-6 py-2.5 rounded-lg font-label-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                    Post a Trip
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterTrips(status) {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-primary', 'text-white', 'border-primary');
            btn.classList.add('bg-surface-container-low', 'text-outline', 'border-outline-variant/30');
        });
        const activeBtn = document.querySelector(`[data-filter="${status}"]`);
        activeBtn.classList.add('active', 'bg-primary', 'text-white', 'border-primary');
        activeBtn.classList.remove('bg-surface-container-low', 'text-outline', 'border-outline-variant/30');

        document.querySelectorAll('.trip-card').forEach(card => {
            if (status === 'all' || card.dataset.status === status) {
                card.style.display = '';
                card.style.animation = 'fadeSlideIn 0.3s ease-out';
            } else {
                card.style.display = 'none';
            }
        });
    }
    document.addEventListener('DOMContentLoaded', () => filterTrips('all'));
</script>
@endpush
