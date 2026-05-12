@extends('farmer.layout')

@section('title', 'FarmLift — My Bookings')
@section('breadcrumb', 'My Bookings')

@section('content')
<div class="space-y-4">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-h1 text-on-surface">My Bookings</h1>
            <p class="font-label-sm text-outline mt-1">Track and manage all your shipment bookings</p>
        </div>
        <a href="{{ route('farmer.search') }}" class="bg-primary hover:bg-on-primary-fixed-variant text-white px-4 py-2.5 rounded-lg font-label-sm transition-all duration-200 flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">add</span>
            New Booking
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 text-center hover:shadow-md transition-all duration-300">
            <span class="font-caps-xs text-on-surface-variant uppercase block">Total</span>
            <span class="font-h2 text-primary block mt-1">{{ $bookings->count() }}</span>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 text-center hover:shadow-md transition-all duration-300">
            <span class="font-caps-xs text-on-surface-variant uppercase block">Pending</span>
            <span class="font-h2 text-[#b49000] block mt-1">{{ $bookings->where('status', 'Pending')->count() }}</span>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 text-center hover:shadow-md transition-all duration-300">
            <span class="font-caps-xs text-on-surface-variant uppercase block">Confirmed</span>
            <span class="font-h2 text-[#4C8CE4] block mt-1">{{ $bookings->where('status', 'Confirmed')->count() }}</span>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 text-center hover:shadow-md transition-all duration-300">
            <span class="font-caps-xs text-on-surface-variant uppercase block">In Transit</span>
            <span class="font-h2 text-[#7c3aed] block mt-1">{{ $bookings->where('status', 'PickedUp')->count() }}</span>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 text-center hover:shadow-md transition-all duration-300">
            <span class="font-caps-xs text-on-surface-variant uppercase block">Delivered</span>
            <span class="font-h2 text-tertiary block mt-1">{{ $bookings->where('status', 'Delivered')->count() }}</span>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1">
        <button onclick="filterBookings('all')" class="filter-btn active px-4 py-2 rounded-full font-label-sm transition-all duration-200 border" data-filter="all">
            All
        </button>
        <button onclick="filterBookings('Pending')" class="filter-btn px-4 py-2 rounded-full font-label-sm transition-all duration-200 border" data-filter="Pending">
            ⏳ Pending
        </button>
        <button onclick="filterBookings('Confirmed')" class="filter-btn px-4 py-2 rounded-full font-label-sm transition-all duration-200 border" data-filter="Confirmed">
            ✅ Confirmed
        </button>
        <button onclick="filterBookings('PickedUp')" class="filter-btn px-4 py-2 rounded-full font-label-sm transition-all duration-200 border" data-filter="PickedUp">
            🚚 In Transit
        </button>
        <button onclick="filterBookings('Delivered')" class="filter-btn px-4 py-2 rounded-full font-label-sm transition-all duration-200 border" data-filter="Delivered">
            📦 Delivered
        </button>
        <button onclick="filterBookings('Cancelled')" class="filter-btn px-4 py-2 rounded-full font-label-sm transition-all duration-200 border" data-filter="Cancelled">
            ❌ Cancelled
        </button>
    </div>

    <!-- Bookings List -->
    <div class="space-y-3" id="bookings-list">
        @forelse($bookings as $booking)
            <div class="booking-card bg-surface-container-lowest border border-outline-variant/30 rounded-lg overflow-hidden hover:shadow-md hover:border-[#4C8CE4]/30 transition-all duration-300"
                 data-status="{{ $booking->status }}">
                <div class="flex flex-col md:flex-row">
                    <!-- Left Section - Route Info -->
                    <div class="flex-1 p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-secondary-fixed rounded-lg">
                                    <span class="material-symbols-outlined text-[#4C8CE4]">local_shipping</span>
                                </div>
                                <div>
                                    <h3 class="font-label-sm font-bold text-on-surface">
                                        @if($booking->trip)
                                            {{ $booking->trip->origin_name }} → {{ $booking->trip->destination_name }}
                                        @else
                                            Route N/A
                                        @endif
                                    </h3>
                                    <p class="font-caps-xs text-outline mt-0.5">
                                        {{ $booking->produce_type ?? 'General' }} · {{ $booking->weight }} tons
                                    </p>
                                    @if($booking->trip && $booking->trip->driver)
                                        <p class="font-caps-xs text-outline mt-0.5">
                                            Driver: {{ $booking->trip->driver->name }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            @php
                                $statusClass = match($booking->status) {
                                    'Pending' => 'status-pending',
                                    'Confirmed' => 'status-confirmed',
                                    'PickedUp' => 'status-pickedup',
                                    'Delivered' => 'status-delivered',
                                    'Cancelled' => 'status-cancelled',
                                    default => 'status-pending',
                                };
                                $statusIcon = match($booking->status) {
                                    'Pending' => '⏳',
                                    'Confirmed' => '✅',
                                    'PickedUp' => '🚚',
                                    'Delivered' => '📦',
                                    'Cancelled' => '❌',
                                    default => '•',
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full font-caps-xs {{ $statusClass }}">
                                {{ $statusIcon }} {{ $booking->status === 'PickedUp' ? 'In Transit' : $booking->status }}
                            </span>
                        </div>

                        <!-- Booking Details Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-4">
                            <div>
                                <span class="font-caps-xs text-outline block">Weight</span>
                                <span class="font-label-sm text-on-surface font-semibold">{{ $booking->weight }} tons</span>
                            </div>
                            <div>
                                <span class="font-caps-xs text-outline block">Price</span>
                                <span class="font-label-sm text-primary font-semibold">₹{{ number_format($booking->price, 0) }}</span>
                            </div>
                            <div>
                                <span class="font-caps-xs text-outline block">Departure</span>
                                <span class="font-label-sm text-on-surface font-semibold">
                                    {{ $booking->trip ? $booking->trip->departure_date->format('M d, H:i') : '—' }}
                                </span>
                            </div>
                            <div>
                                <span class="font-caps-xs text-outline block">Booked on</span>
                                <span class="font-label-sm text-on-surface font-semibold">{{ $booking->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>

                        @if($booking->pickup_address)
                            <div class="mt-3 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px] text-outline">pin_drop</span>
                                <span class="font-caps-xs text-outline">Pickup: {{ $booking->pickup_address }}</span>
                            </div>
                        @endif
                        @if($booking->notes)
                            <div class="mt-1 flex items-start gap-1">
                                <span class="material-symbols-outlined text-[14px] text-outline mt-0.5">notes</span>
                                <span class="font-caps-xs text-outline">{{ $booking->notes }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Right Section - Timeline Indicator -->
                    <div class="hidden md:flex flex-col items-center justify-center px-6 border-l border-outline-variant/20 min-w-[100px] bg-surface-container-low/50">
                        @php
                            $steps = ['Pending', 'Confirmed', 'PickedUp', 'Delivered'];
                            $currentStep = array_search($booking->status, $steps);
                            if ($booking->status === 'Cancelled') $currentStep = -1;
                        @endphp
                        @foreach($steps as $idx => $step)
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full border-2 {{ $idx <= $currentStep ? 'bg-[#4C8CE4] border-[#4C8CE4]' : 'bg-white border-outline-variant' }} transition-colors"></div>
                                <span class="font-caps-xs {{ $idx <= $currentStep ? 'text-primary' : 'text-outline' }} w-16">{{ $step === 'PickedUp' ? 'Transit' : $step }}</span>
                            </div>
                            @if(!$loop->last)
                                <div class="w-0.5 h-4 {{ $idx < $currentStep ? 'bg-[#4C8CE4]' : 'bg-outline-variant' }} ml-[5px] transition-colors"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-12 text-center">
                <span class="material-symbols-outlined text-5xl text-outline/40 mb-3 block">receipt_long</span>
                <h3 class="font-h2 text-on-surface mb-1">No bookings yet</h3>
                <p class="font-label-sm text-outline mb-4">Start by searching for available trucks near you</p>
                <a href="{{ route('farmer.search') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-on-primary-fixed-variant text-white px-6 py-2.5 rounded-lg font-label-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    Search Trucks
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterBookings(status) {
        // Update active filter button
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-primary', 'text-white', 'border-primary');
            btn.classList.add('bg-surface-container-low', 'text-outline', 'border-outline-variant/30');
        });
        const activeBtn = document.querySelector(`[data-filter="${status}"]`);
        activeBtn.classList.add('active', 'bg-primary', 'text-white', 'border-primary');
        activeBtn.classList.remove('bg-surface-container-low', 'text-outline', 'border-outline-variant/30');

        // Filter cards
        document.querySelectorAll('.booking-card').forEach(card => {
            if (status === 'all' || card.dataset.status === status) {
                card.style.display = '';
                card.style.animation = 'fadeSlideIn 0.3s ease-out';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Initialize first filter button as active
    document.addEventListener('DOMContentLoaded', function() {
        filterBookings('all');
    });
</script>
@endpush
