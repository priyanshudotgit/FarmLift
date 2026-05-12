@extends('driver.layout')

@section('title', 'FarmLift — Driver Profile')
@section('breadcrumb', 'Profile')

@section('content')
<div class="space-y-4 max-w-4xl">
    <!-- Profile Header Card -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg overflow-hidden">
        <div class="h-32 bg-gradient-to-r from-[#406093] via-[#4C8CE4] to-[#67a4fe] relative">
            <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cpath d=&quot;M30 5l5 10h-10z&quot; fill=&quot;rgba(255,255,255,0.1)&quot;/%3E%3C/svg%3E');"></div>
        </div>
        <div class="px-6 pb-6 -mt-12 relative">
            <div class="flex items-end gap-4">
                <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-[#FDE68A] to-[#4C8CE4] border-4 border-white shadow-lg flex items-center justify-center">
                    <span class="text-3xl font-black text-[#406093]">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                </div>
                <div class="pb-1">
                    <h1 class="font-h1 text-on-surface text-xl">{{ $user->name }}</h1>
                    <p class="font-label-sm text-outline flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">local_shipping</span>
                        Truck Driver · Joined {{ $user->created_at ? $user->created_at->format('M Y') : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Personal Information -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-5">
            <h2 class="font-h2 text-on-surface text-lg flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">person</span>
                Personal Information
            </h2>
            <form method="POST" action="{{ route('driver.profile.update') }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                    @error('name') <p class="font-caps-xs text-error mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                    @error('email') <p class="font-caps-xs text-error mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                    @error('phone') <p class="font-caps-xs text-error mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="bg-primary hover:bg-on-primary-fixed-variant text-white px-5 py-2.5 rounded-lg font-label-sm transition-all duration-200 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Save Changes
                </button>
            </form>
        </div>

        <!-- Vehicle Details -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-5">
            <h2 class="font-h2 text-on-surface text-lg flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-[#4C8CE4]">local_shipping</span>
                Vehicle Details
            </h2>
            <form method="POST" action="{{ route('driver.profile.vehicle') }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Truck Model</label>
                    <input type="text" name="truck_model" value="{{ old('truck_model', $profile->truck_model ?? '') }}" placeholder="e.g., Tata Ace, Ashok Leyland"
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                </div>
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Plate Number</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number', $profile->plate_number ?? '') }}" placeholder="e.g., MH 12 AB 1234"
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                </div>
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">License Number</label>
                    <input type="text" name="license_number" value="{{ old('license_number', $profile->license_number ?? '') }}" placeholder="e.g., DL-1234567890"
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                </div>
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Max Payload (tons)</label>
                    <input type="number" step="0.1" name="max_payload" value="{{ old('max_payload', $profile->max_payload ?? '') }}" placeholder="e.g., 10.5"
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                </div>
                <div class="flex items-center gap-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="refrigeration" value="1" {{ old('refrigeration', $profile->refrigeration ?? false) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#4C8CE4]"></div>
                    </label>
                    <span class="font-label-sm text-on-surface-variant">Refrigerated Truck</span>
                </div>
                <button type="submit" class="bg-[#4C8CE4] hover:bg-[#3a7ad4] text-white px-5 py-2.5 rounded-lg font-label-sm transition-all duration-200 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Update Vehicle Info
                </button>
            </form>
        </div>
    </div>

    <!-- Account Statistics -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-5">
        <h2 class="font-h2 text-on-surface text-lg flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined text-secondary">bar_chart</span>
            Account Statistics
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-surface-container-low rounded-lg p-4 text-center hover:shadow-md transition-all duration-300">
                <span class="material-symbols-outlined text-3xl text-primary mb-1 block">route</span>
                <span class="font-h2 text-on-surface block">{{ $stats['total_trips'] }}</span>
                <span class="font-caps-xs text-outline">Total Trips</span>
            </div>
            <div class="bg-surface-container-low rounded-lg p-4 text-center hover:shadow-md transition-all duration-300">
                <span class="material-symbols-outlined text-3xl text-[#91D06C] mb-1 block">check_circle</span>
                <span class="font-h2 text-on-surface block">{{ $stats['completed_trips'] }}</span>
                <span class="font-caps-xs text-outline">Completed</span>
            </div>
            <div class="bg-surface-container-low rounded-lg p-4 text-center hover:shadow-md transition-all duration-300">
                <span class="material-symbols-outlined text-3xl text-[#4C8CE4] mb-1 block">scale</span>
                <span class="font-h2 text-on-surface block">{{ number_format($stats['total_weight'], 1) }}</span>
                <span class="font-caps-xs text-outline">Total Tons Moved</span>
            </div>
            <div class="bg-surface-container-low rounded-lg p-4 text-center hover:shadow-md transition-all duration-300">
                <span class="material-symbols-outlined text-3xl text-[#b49000] mb-1 block">payments</span>
                <span class="font-h2 text-on-surface block">₹{{ number_format($stats['total_earnings'], 0) }}</span>
                <span class="font-caps-xs text-outline">Total Earnings</span>
            </div>
        </div>
    </div>

    <!-- Change Password -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-5">
        <h2 class="font-h2 text-on-surface text-lg flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined text-error">lock</span>
            Change Password
        </h2>
        <form method="POST" action="{{ route('driver.profile.password') }}" class="space-y-4 max-w-md">
            @csrf
            @method('PUT')
            <div>
                <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Current Password</label>
                <input type="password" name="current_password" required
                    class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                @error('current_password') <p class="font-caps-xs text-error mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">New Password</label>
                <input type="password" name="password" required
                    class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                @error('password') <p class="font-caps-xs text-error mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
            </div>
            <button type="submit" class="bg-error/90 hover:bg-error text-white px-5 py-2.5 rounded-lg font-label-sm transition-all duration-200 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                Update Password
            </button>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="bg-surface-container-lowest border border-red-200 rounded-lg p-5">
        <h2 class="font-h2 text-error text-lg flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined">warning</span>
            Danger Zone
        </h2>
        <p class="font-label-sm text-outline mb-4">Once you sign out, you will need to log in again with your credentials.</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="border border-red-300 text-red-600 hover:bg-red-50 px-5 py-2.5 rounded-lg font-label-sm transition-all duration-200 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">logout</span>
                Sign Out
            </button>
        </form>
    </div>
</div>
@endsection
