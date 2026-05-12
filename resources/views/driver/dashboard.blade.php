@extends('driver.layout')

@section('title', 'FarmLift — Driver Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="space-y-4">
    <!-- Welcome Bar -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-h1 text-on-surface">Welcome, {{ Auth::user()->name }}</h1>
            <p class="font-label-sm text-outline mt-1">Here's your command center overview</p>
        </div>
        <a href="{{ route('driver.trip.create') }}" class="bg-primary hover:bg-on-primary-fixed-variant text-white px-5 py-2.5 rounded-lg font-label-sm transition-all duration-200 flex items-center gap-2 shadow-md">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            Post New Trip
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <!-- Active Trips -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-4 flex flex-col justify-between group hover:shadow-md hover:border-[#4C8CE4]/30 transition-all duration-300">
            <span class="font-caps-xs text-on-surface-variant uppercase">Active Trips</span>
            <div class="flex items-end justify-between mt-3">
                <span class="font-h1 text-primary">{{ $activeTripsCount }}</span>
                <span class="material-symbols-outlined text-secondary-container group-hover:scale-110 transition-transform">route</span>
            </div>
        </div>
        <!-- Total Earnings -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-4 flex flex-col justify-between group hover:shadow-md hover:border-[#91D06C]/30 transition-all duration-300">
            <span class="font-caps-xs text-on-surface-variant uppercase">Total Earnings</span>
            <div class="flex items-end justify-between mt-3">
                <span class="font-h1 text-[#91D06C]">₹{{ number_format($totalEarnings, 0) }}</span>
                <span class="material-symbols-outlined text-[#91D06C] group-hover:scale-110 transition-transform">trending_up</span>
            </div>
        </div>
        <!-- Pending Requests -->
        <div class="bg-[#FFF799]/30 border border-[#d6cf73]/40 rounded-lg p-4 flex flex-col justify-between group hover:shadow-md transition-all duration-300">
            <span class="font-caps-xs text-[#6b6732] uppercase">Pending Requests</span>
            <div class="flex items-end justify-between mt-3">
                <span class="font-h1 text-[#4a471c]">{{ $pendingRequests }}</span>
                <span class="material-symbols-outlined text-[#6b6732] group-hover:scale-110 transition-transform">assignment</span>
            </div>
        </div>
        <!-- Completed Trips -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-4 flex flex-col justify-between group hover:shadow-md hover:border-primary/30 transition-all duration-300">
            <span class="font-caps-xs text-on-surface-variant uppercase">Completed Trips</span>
            <div class="flex items-end justify-between mt-3">
                <span class="font-h1 text-primary">{{ $completedTrips }}</span>
                <span class="material-symbols-outlined text-secondary-container group-hover:scale-110 transition-transform">check_circle</span>
            </div>
        </div>
    </div>

    <!-- Live Trip Status + Recent Bookings -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Current Active Trips -->
        <div class="lg:col-span-2 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <h2 class="font-h2 text-on-surface">Your Active Trips</h2>
                <a href="{{ route('driver.loadboard') }}" class="font-label-sm text-primary hover:text-secondary transition-colors flex items-center gap-1">
                    View All <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>

            @forelse($activeTrips as $trip)
                <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg overflow-hidden hover:shadow-md hover:border-[#4C8CE4]/30 transition-all duration-300">
                    <!-- Trip Header -->
                    <div class="p-4 border-b border-outline-variant/20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-[#4C8CE4]/10 rounded-lg">
                                    <span class="material-symbols-outlined text-[#4C8CE4]">route</span>
                                </div>
                                <div>
                                    <h3 class="font-label-sm font-bold text-on-surface">{{ $trip->origin_name }} → {{ $trip->destination_name }}</h3>
                                    <p class="font-caps-xs text-outline mt-0.5">
                                        {{ $trip->departure_date->format('M d, H:i') }} · ₹{{ number_format($trip->price_per_ton, 0) }}/ton
                                    </p>
                                </div>
                            </div>
                            @php
                                $tripStatusClass = match($trip->status) {
                                    'Scheduled' => 'status-scheduled',
                                    'Active' => 'status-active',
                                    'Completed' => 'status-completed',
                                    default => 'status-scheduled',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full font-caps-xs {{ $tripStatusClass }}">{{ $trip->status }}</span>
                        </div>
                        <!-- Capacity -->
                        <div class="mt-3">
                            <div class="flex justify-between text-[10px] text-outline uppercase font-semibold mb-1">
                                <span>Capacity Meter</span>
                                <span>{{ $trip->capacity_percent }}% Filled · {{ $trip->available_capacity }} tons free</span>
                            </div>
                            <div class="w-full h-3 bg-surface-container-highest rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-[#4C8CE4] to-[#91D06C] rounded-full transition-all duration-700" style="width: {{ $trip->capacity_percent }}%"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Bookings for this trip -->
                    @if($trip->bookings->count() > 0)
                        <div class="p-3 bg-surface-container-low/50">
                            <span class="font-caps-xs text-outline uppercase mb-2 block">Bookings ({{ $trip->bookings->count() }})</span>
                            <div class="space-y-2">
                                @foreach($trip->bookings->take(3) as $booking)
                                    <div class="flex items-center justify-between bg-white rounded-lg p-2.5 border border-outline-variant/20">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full {{ $booking->status === 'Pending' ? 'bg-[#b49000]' : ($booking->status === 'Confirmed' ? 'bg-[#4C8CE4]' : 'bg-[#91D06C]') }}"></div>
                                            <div>
                                                <span class="font-label-sm text-on-surface">{{ $booking->produce_type ?? 'General' }}</span>
                                                <span class="font-caps-xs text-outline ml-2">{{ $booking->weight }} tons · {{ $booking->farmer->name ?? 'Unknown' }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
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
                                            <span class="px-2 py-0.5 rounded font-caps-xs {{ $bStatusClass }}">{{ $booking->status }}</span>
                                            @if($booking->status === 'Pending')
                                                <form method="POST" action="{{ route('driver.booking.status', $booking) }}" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Confirmed">
                                                    <button type="submit" class="bg-[#91D06C] text-tertiary font-medium px-2.5 py-1 rounded text-[11px] font-semibold hover:opacity-90 transition-opacity border border-[#346c13]/20">Confirm</button>
                                                </form>
                                            @elseif($booking->status === 'Confirmed')
                                                <form method="POST" action="{{ route('driver.booking.status', $booking) }}" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="PickedUp">
                                                    <button type="submit" class="bg-[#4C8CE4] text-white font-medium px-2.5 py-1 rounded text-[11px] font-semibold hover:opacity-90 transition-opacity">Pickup</button>
                                                </form>
                                            @elseif($booking->status === 'PickedUp')
                                                <form method="POST" action="{{ route('driver.booking.status', $booking) }}" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Delivered">
                                                    <button type="submit" class="bg-primary text-white font-medium px-2.5 py-1 rounded text-[11px] font-semibold hover:opacity-90 transition-opacity">Deliver</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="p-4 text-center bg-surface-container-low/50">
                            <span class="font-label-sm text-outline">No bookings yet for this trip</span>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-8 text-center">
                    <span class="material-symbols-outlined text-4xl text-outline/50 mb-2">route</span>
                    <p class="font-label-sm text-outline">No active trips</p>
                    <a href="{{ route('driver.trip.create') }}" class="font-label-sm text-primary hover:text-secondary mt-2 inline-block">Post a new trip →</a>
                </div>
            @endforelse
        </div>

        <!-- Right Column: Quick Stats + Recent Earnings -->
        <div class="lg:col-span-1 flex flex-col gap-3">
            <!-- Quick Stats -->
            <h2 class="font-h2 text-on-surface">Quick Stats</h2>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 text-center hover:shadow-md transition-all">
                    <span class="font-caps-xs text-outline block">Total Trips</span>
                    <span class="font-h2 text-primary block mt-1">{{ $totalTrips }}</span>
                </div>
                <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 text-center hover:shadow-md transition-all">
                    <span class="font-caps-xs text-outline block">Total Bookings</span>
                    <span class="font-h2 text-[#4C8CE4] block mt-1">{{ $totalBookings }}</span>
                </div>
                <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 text-center hover:shadow-md transition-all">
                    <span class="font-caps-xs text-outline block">Tons Moved</span>
                    <span class="font-h2 text-on-surface block mt-1">{{ number_format($totalWeight, 1) }}</span>
                </div>
                <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 text-center hover:shadow-md transition-all">
                    <span class="font-caps-xs text-outline block">Delivered</span>
                    <span class="font-h2 text-[#91D06C] block mt-1">{{ $deliveredBookings }}</span>
                </div>
            </div>

            <!-- Recent Booking Requests -->
            <h2 class="font-h2 text-on-surface mt-2">Recent Requests</h2>
            <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <tbody>
                        @forelse($recentBookings as $booking)
                            <tr class="border-b border-outline-variant/20 hover:bg-surface-container-low transition-colors">
                                <td class="p-2 pl-3">
                                    <p class="font-label-sm text-on-surface">{{ $booking->produce_type ?? 'General' }}</p>
                                    <p class="font-caps-xs text-outline">{{ $booking->weight }} tons · {{ $booking->farmer->name ?? 'Unknown' }}</p>
                                </td>
                                <td class="p-2 text-right pr-3">
                                    @php
                                        $rStatusClass = match($booking->status) {
                                            'Pending' => 'status-pending',
                                            'Confirmed' => 'status-confirmed',
                                            'PickedUp' => 'status-pickedup',
                                            'Delivered' => 'status-delivered',
                                            'Cancelled' => 'status-cancelled',
                                            default => 'status-pending',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded font-caps-xs {{ $rStatusClass }}">{{ $booking->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-4 text-center text-outline" colspan="2">
                                    <span class="material-symbols-outlined text-2xl text-outline/50 block mb-1">inbox</span>
                                    No recent requests
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-2 text-center border-t border-outline-variant/20">
                    <a class="font-label-sm text-primary hover:text-secondary transition-colors" href="{{ route('driver.loadboard') }}">View Load Board</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
