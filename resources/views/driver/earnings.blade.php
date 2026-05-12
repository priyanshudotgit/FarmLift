@extends('driver.layout')

@section('title', 'FarmLift — Earnings')
@section('breadcrumb', 'Earnings')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div>
        <h1 class="font-h1 text-on-surface">Earnings</h1>
        <p class="font-label-sm text-outline mt-1">Track your revenue from all trips and bookings</p>
    </div>

    <!-- Earnings Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="bg-gradient-to-br from-[#406093] to-[#4C8CE4] rounded-lg p-4 text-white group hover:shadow-lg transition-all duration-300">
            <span class="font-caps-xs uppercase opacity-80">Total Earnings</span>
            <div class="flex items-end justify-between mt-3">
                <span class="font-h1 font-bold">₹{{ number_format($totalEarnings, 0) }}</span>
                <span class="material-symbols-outlined opacity-70 group-hover:scale-110 transition-transform">account_balance</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-4 group hover:shadow-md hover:border-[#91D06C]/30 transition-all duration-300">
            <span class="font-caps-xs text-on-surface-variant uppercase">Confirmed Revenue</span>
            <div class="flex items-end justify-between mt-3">
                <span class="font-h1 text-[#91D06C]">₹{{ number_format($confirmedEarnings, 0) }}</span>
                <span class="material-symbols-outlined text-[#91D06C] group-hover:scale-110 transition-transform">verified</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-4 group hover:shadow-md hover:border-[#b49000]/30 transition-all duration-300">
            <span class="font-caps-xs text-on-surface-variant uppercase">Pending Revenue</span>
            <div class="flex items-end justify-between mt-3">
                <span class="font-h1 text-[#b49000]">₹{{ number_format($pendingEarnings, 0) }}</span>
                <span class="material-symbols-outlined text-[#b49000] group-hover:scale-110 transition-transform">hourglass_top</span>
            </div>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-4 group hover:shadow-md hover:border-primary/30 transition-all duration-300">
            <span class="font-caps-xs text-on-surface-variant uppercase">Total Bookings</span>
            <div class="flex items-end justify-between mt-3">
                <span class="font-h1 text-primary">{{ $totalBookingsCount }}</span>
                <span class="material-symbols-outlined text-secondary-container group-hover:scale-110 transition-transform">confirmation_number</span>
            </div>
        </div>
    </div>

    <!-- Earnings by Trip -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Trip Revenue Breakdown -->
        <div class="lg:col-span-2">
            <h2 class="font-h2 text-on-surface mb-3">Revenue by Trip</h2>
            <div class="space-y-3">
                @forelse($trips as $trip)
                    @php
                        $tripRevenue = $trip->bookings->whereNotIn('status', ['Cancelled'])->sum('price');
                        $tripDeliveredRevenue = $trip->bookings->where('status', 'Delivered')->sum('price');
                        $maxPossible = $trip->total_capacity * $trip->price_per_ton;
                        $revenuePct = $maxPossible > 0 ? round(($tripRevenue / $maxPossible) * 100, 1) : 0;
                    @endphp
                    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg overflow-hidden hover:shadow-md transition-all duration-300">
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-lg {{ $trip->status === 'Completed' ? 'bg-[#91D06C]/15' : ($trip->status === 'Active' ? 'bg-[#4C8CE4]/10' : 'bg-surface-container') }}">
                                        <span class="material-symbols-outlined {{ $trip->status === 'Completed' ? 'text-[#91D06C]' : 'text-[#4C8CE4]' }}">
                                            {{ $trip->status === 'Completed' ? 'check_circle' : 'route' }}
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="font-label-sm font-bold text-on-surface">{{ $trip->origin_name }} → {{ $trip->destination_name }}</h3>
                                        <p class="font-caps-xs text-outline mt-0.5">{{ $trip->departure_date->format('M d, Y') }} · {{ $trip->bookings->count() }} bookings</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-h2 text-[#91D06C] text-lg">₹{{ number_format($tripRevenue, 0) }}</span>
                                    <p class="font-caps-xs text-outline">of ₹{{ number_format($maxPossible, 0) }} max</p>
                                </div>
                            </div>

                            <!-- Revenue progress bar -->
                            <div class="mt-3">
                                <div class="flex justify-between text-[10px] text-outline uppercase font-semibold mb-1">
                                    <span>Revenue Fill</span>
                                    <span>{{ $revenuePct }}%</span>
                                </div>
                                <div class="w-full h-2 bg-surface-container-highest rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-[#91D06C] to-[#4C8CE4] rounded-full transition-all duration-700" style="width: {{ $revenuePct }}%"></div>
                                </div>
                            </div>

                            <!-- Per-booking breakdown -->
                            @if($trip->bookings->count() > 0)
                                <div class="mt-3 space-y-1.5">
                                    @foreach($trip->bookings as $booking)
                                        <div class="flex items-center justify-between bg-surface-container-low/50 rounded-lg px-3 py-2">
                                            <div class="flex items-center gap-2">
                                                @php
                                                    $dotColor = match($booking->status) {
                                                        'Delivered' => 'bg-[#91D06C]',
                                                        'PickedUp' => 'bg-[#4C8CE4]',
                                                        'Confirmed' => 'bg-[#4C8CE4]',
                                                        'Pending' => 'bg-[#b49000]',
                                                        default => 'bg-outline',
                                                    };
                                                @endphp
                                                <div class="w-2 h-2 rounded-full {{ $dotColor }}"></div>
                                                <span class="font-label-sm text-on-surface">{{ $booking->farmer->name ?? 'Unknown' }}</span>
                                                <span class="font-caps-xs text-outline">· {{ $booking->produce_type ?? 'General' }} · {{ $booking->weight }}t</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-sm {{ $booking->status === 'Cancelled' ? 'text-outline line-through' : 'text-primary' }} font-semibold">
                                                    ₹{{ number_format($booking->price, 0) }}
                                                </span>
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
                                                <span class="px-1.5 py-0.5 rounded font-caps-xs {{ $bStatusClass }} text-[10px]">{{ $booking->status }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-8 text-center">
                        <span class="material-symbols-outlined text-4xl text-outline/50 mb-2">payments</span>
                        <p class="font-label-sm text-outline">No trips with earnings yet</p>
                        <a href="{{ route('driver.trip.create') }}" class="font-label-sm text-primary hover:text-secondary mt-2 inline-block">Post a trip to start earning →</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Column: Summary -->
        <div class="lg:col-span-1 flex flex-col gap-3">
            <h2 class="font-h2 text-on-surface">Earnings Breakdown</h2>

            <!-- Breakdown Stats -->
            <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-4 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#91D06C]"></div>
                        <span class="font-label-sm text-on-surface">Delivered</span>
                    </div>
                    <div class="text-right">
                        <span class="font-label-sm text-on-surface font-semibold">₹{{ number_format($deliveredEarnings, 0) }}</span>
                        <span class="font-caps-xs text-outline block">{{ $deliveredCount }} bookings</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#4C8CE4]"></div>
                        <span class="font-label-sm text-on-surface">In Transit</span>
                    </div>
                    <div class="text-right">
                        <span class="font-label-sm text-on-surface font-semibold">₹{{ number_format($inTransitEarnings, 0) }}</span>
                        <span class="font-caps-xs text-outline block">{{ $inTransitCount }} bookings</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#b49000]"></div>
                        <span class="font-label-sm text-on-surface">Pending</span>
                    </div>
                    <div class="text-right">
                        <span class="font-label-sm text-on-surface font-semibold">₹{{ number_format($pendingEarnings, 0) }}</span>
                        <span class="font-caps-xs text-outline block">{{ $pendingCount }} bookings</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <span class="font-label-sm text-on-surface">Cancelled</span>
                    </div>
                    <div class="text-right">
                        <span class="font-label-sm text-outline font-semibold line-through">₹{{ number_format($cancelledEarnings, 0) }}</span>
                        <span class="font-caps-xs text-outline block">{{ $cancelledCount }} bookings</span>
                    </div>
                </div>

                <div class="border-t border-outline-variant/20 pt-3">
                    <div class="flex items-center justify-between">
                        <span class="font-label-sm text-on-surface font-bold">Net Earnings</span>
                        <span class="font-h2 text-[#91D06C]">₹{{ number_format($totalEarnings, 0) }}</span>
                    </div>
                </div>
            </div>

            <!-- Performance Stats -->
            <h2 class="font-h2 text-on-surface mt-2">Performance</h2>
            <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-outline">Avg. per Trip</span>
                    <span class="font-label-sm text-on-surface font-semibold">₹{{ $trips->count() > 0 ? number_format($totalEarnings / max($trips->count(), 1), 0) : 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-outline">Avg. per Booking</span>
                    <span class="font-label-sm text-on-surface font-semibold">₹{{ $totalBookingsCount > 0 ? number_format($totalEarnings / max($totalBookingsCount, 1), 0) : 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-outline">Total Weight Moved</span>
                    <span class="font-label-sm text-on-surface font-semibold">{{ number_format($totalWeight, 1) }} tons</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-outline">Avg. Price/Ton</span>
                    <span class="font-label-sm text-on-surface font-semibold">₹{{ $totalWeight > 0 ? number_format($totalEarnings / max($totalWeight, 0.1), 0) : 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
