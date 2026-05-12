@extends('farmer.layout')

@section('title', 'FarmLift — Dashboard')
@section('breadcrumb', 'Overview')

@section('content')
<!-- Stats Row - Real Data from DB -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 flex flex-col justify-between group hover:shadow-md hover:border-[#4C8CE4]/30 transition-all duration-300">
        <span class="font-caps-xs text-on-surface-variant uppercase">Loads in Transit</span>
        <div class="flex items-end justify-between mt-2">
            <span class="font-h1 text-primary">{{ $inTransitCount }}</span>
            <span class="material-symbols-outlined text-secondary-container group-hover:scale-110 transition-transform">local_shipping</span>
        </div>
    </div>
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 flex flex-col justify-between group hover:shadow-md hover:border-[#91D06C]/30 transition-all duration-300">
        <span class="font-caps-xs text-on-surface-variant uppercase">Total Spent</span>
        <div class="flex items-end justify-between mt-2">
            <span class="font-h1 text-[#91D06C]">₹{{ number_format($totalSpent, 0) }}</span>
            <span class="material-symbols-outlined text-[#91D06C] group-hover:scale-110 transition-transform">payments</span>
        </div>
    </div>
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 flex flex-col justify-between group hover:shadow-md hover:border-outline/30 transition-all duration-300">
        <span class="font-caps-xs text-on-surface-variant uppercase">Next Pickup</span>
        <div class="flex items-end justify-between mt-2">
            <div class="flex flex-col">
                @if($nextPickup)
                    <span class="font-h2 text-on-surface">{{ $nextPickup->trip->departure_date->format('H:i') }}</span>
                    <span class="font-label-sm text-outline">{{ $nextPickup->trip->departure_date->isToday() ? 'Today' : $nextPickup->trip->departure_date->format('M d') }}</span>
                @else
                    <span class="font-h2 text-on-surface">—</span>
                    <span class="font-label-sm text-outline">No upcoming</span>
                @endif
            </div>
            <span class="material-symbols-outlined text-outline group-hover:scale-110 transition-transform">schedule</span>
        </div>
    </div>
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 flex flex-col justify-between group hover:shadow-md hover:border-primary/30 transition-all duration-300">
        <span class="font-caps-xs text-on-surface-variant uppercase">Total Bookings</span>
        <div class="flex items-end justify-between mt-2">
            <span class="font-h1 text-primary">{{ $totalBookings }}</span>
            <span class="material-symbols-outlined text-secondary-container group-hover:scale-110 transition-transform">confirmation_number</span>
        </div>
    </div>
</div>

<!-- Bento Layout: Active Trucks & Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <!-- Active Trucks Near You Grid -->
    <div class="lg:col-span-2 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <h2 class="font-h2 text-on-surface mb-1">Active Trucks Near You</h2>
            <a href="{{ route('farmer.search') }}" class="font-label-sm text-primary hover:text-secondary transition-colors flex items-center gap-1">
                View All
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @forelse($activeTrips as $trip)
                <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-3 flex flex-col gap-2 relative overflow-hidden hover:shadow-md hover:border-[#4C8CE4]/30 transition-all duration-300 group">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <div class="p-1.5 bg-secondary-fixed rounded-md group-hover:bg-[#4C8CE4]/20 transition-colors">
                                <span class="material-symbols-outlined text-[#4C8CE4] text-lg">local_shipping</span>
                            </div>
                            <div>
                                <p class="font-label-sm font-bold text-[#406093]">{{ $trip->origin_name }} → {{ $trip->destination_name }}</p>
                                <p class="font-caps-xs text-outline">{{ $trip->driver->name ?? 'Unknown Driver' }}</p>
                            </div>
                        </div>
                        <span class="font-h2 text-primary text-sm">₹{{ number_format($trip->price_per_ton, 0) }}<span class="font-caps-xs text-outline">/ton</span></span>
                    </div>
                    <!-- Capacity Bar -->
                    <div class="w-full bg-surface-container-highest rounded-full h-1.5 mt-1">
                        <div class="bg-[#4C8CE4] h-1.5 rounded-full transition-all duration-500" style="width: {{ $trip->capacity_percent }}%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-outline uppercase font-semibold">
                        <span>Capacity</span>
                        <span>{{ $trip->capacity_percent }}% Full</span>
                    </div>
                    <!-- Info -->
                    <div class="flex justify-between items-end mt-1">
                        <div class="flex gap-1 flex-wrap">
                            <span class="px-1.5 py-0.5 bg-tertiary-fixed-dim/20 text-tertiary-container text-[10px] rounded font-semibold border border-tertiary-fixed-dim/30">
                                {{ $trip->available_capacity }} tons avail
                            </span>
                            <span class="px-1.5 py-0.5 bg-surface-variant text-on-surface-variant text-[10px] rounded font-semibold border border-outline-variant/30">
                                {{ $trip->departure_date->format('M d, H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="sm:col-span-2 bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-8 text-center">
                    <span class="material-symbols-outlined text-4xl text-outline/50 mb-2">local_shipping</span>
                    <p class="font-label-sm text-outline">No active trucks found nearby</p>
                    <a href="{{ route('farmer.search') }}" class="font-label-sm text-primary hover:text-secondary mt-2 inline-block">Search for trucks →</a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="lg:col-span-1 flex flex-col gap-3">
        <h2 class="font-h2 text-on-surface mb-1">Recent Activity</h2>
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr class="border-b border-outline-variant/20 hover:bg-surface-container-low transition-colors">
                            <td class="p-2 pl-3">
                                <p class="font-label-sm text-on-surface">
                                    {{ $booking->trip ? $booking->trip->origin_name . ' → ' . $booking->trip->destination_name : 'N/A' }}
                                </p>
                                <p class="font-caps-xs text-outline">{{ $booking->produce_type ?? 'General' }} · {{ $booking->weight }} tons</p>
                            </td>
                            <td class="p-2 text-right pr-3">
                                @php
                                    $statusClass = match($booking->status) {
                                        'Pending' => 'status-pending',
                                        'Confirmed' => 'status-confirmed',
                                        'PickedUp' => 'status-pickedup',
                                        'Delivered' => 'status-delivered',
                                        'Cancelled' => 'status-cancelled',
                                        default => 'status-pending',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded font-caps-xs {{ $statusClass }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-4 text-center text-outline" colspan="2">
                                <span class="material-symbols-outlined text-2xl text-outline/50 block mb-1">receipt_long</span>
                                No recent activity
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-2 text-center border-t border-outline-variant/20">
                <a class="font-label-sm text-primary hover:text-secondary transition-colors" href="{{ route('farmer.bookings') }}">View All Activity</a>
            </div>
        </div>
    </div>
</div>
@endsection
