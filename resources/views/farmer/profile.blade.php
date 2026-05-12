@extends('farmer.layout')

@section('title', 'FarmLift — Profile')
@section('breadcrumb', 'Profile')

@section('content')
<div class="space-y-4 max-w-4xl">
    <!-- Profile Header Card -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg overflow-hidden">
        <!-- Cover Gradient -->
        <div class="h-32 bg-gradient-to-r from-[#406093] via-[#4C8CE4] to-[#67a4fe] relative">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M0%200h60v60H0z%22%20fill%3D%22none%22%2F%3E%3Cpath%20d%3D%22M30%205l5%2010h-10z%22%20fill%3D%22rgba(255%2C255%2C255%2C0.05)%22%2F%3E%3C%2Fsvg%3E')] opacity-30"></div>
        </div>
        <!-- Profile Info -->
        <div class="px-6 pb-6 -mt-12 relative">
            <div class="flex items-end gap-4">
                <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-[#FDFBD4] to-[#91D06C] border-4 border-white shadow-lg flex items-center justify-center">
                    <span class="text-3xl font-black text-[#406093]">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                </div>
                <div class="pb-1">
                    <h1 class="font-h1 text-on-surface text-xl">{{ $user->name }}</h1>
                    <p class="font-label-sm text-outline flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">eco</span>
                        Farmer · Joined {{ $user->created_at ? $user->created_at->format('M Y') : 'N/A' }}
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
            <form method="POST" action="{{ route('farmer.profile.update') }}" class="space-y-4">
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

        <!-- Farm Details -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-5">
            <h2 class="font-h2 text-on-surface text-lg flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-tertiary">agriculture</span>
                Farm Details
            </h2>
            <form method="POST" action="{{ route('farmer.profile.farm') }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Farm Name</label>
                    <input type="text" name="farm_name" value="{{ old('farm_name', $profile->farm_name ?? '') }}" placeholder="e.g., Green Valley Farm"
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                </div>
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">Farm Address</label>
                    <textarea name="address" rows="2" placeholder="Full address of your farm"
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none resize-none">{{ old('address', $profile->address ?? '') }}</textarea>
                </div>
                <div>
                    <label class="font-label-sm text-on-surface-variant font-semibold block mb-1">GST Number</label>
                    <input type="text" name="gst_number" value="{{ old('gst_number', $profile->gst_number ?? '') }}" placeholder="e.g., 22AAAAA0000A1Z5"
                        class="w-full border border-outline-variant/30 rounded-lg px-3 py-2.5 font-label-sm bg-surface focus:ring-2 focus:ring-[#4C8CE4]/30 focus:border-[#4C8CE4] transition-all outline-none">
                </div>
                <button type="submit" class="bg-tertiary hover:bg-on-tertiary-fixed-variant text-white px-5 py-2.5 rounded-lg font-label-sm transition-all duration-200 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Update Farm Info
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
                <span class="material-symbols-outlined text-3xl text-primary mb-1 block">confirmation_number</span>
                <span class="font-h2 text-on-surface block">{{ $stats['total_bookings'] }}</span>
                <span class="font-caps-xs text-outline">Total Bookings</span>
            </div>
            <div class="bg-surface-container-low rounded-lg p-4 text-center hover:shadow-md transition-all duration-300">
                <span class="material-symbols-outlined text-3xl text-[#91D06C] mb-1 block">check_circle</span>
                <span class="font-h2 text-on-surface block">{{ $stats['delivered'] }}</span>
                <span class="font-caps-xs text-outline">Delivered</span>
            </div>
            <div class="bg-surface-container-low rounded-lg p-4 text-center hover:shadow-md transition-all duration-300">
                <span class="material-symbols-outlined text-3xl text-[#4C8CE4] mb-1 block">scale</span>
                <span class="font-h2 text-on-surface block">{{ number_format($stats['total_weight'], 1) }}</span>
                <span class="font-caps-xs text-outline">Total Tons Shipped</span>
            </div>
            <div class="bg-surface-container-low rounded-lg p-4 text-center hover:shadow-md transition-all duration-300">
                <span class="material-symbols-outlined text-3xl text-[#b49000] mb-1 block">payments</span>
                <span class="font-h2 text-on-surface block">₹{{ number_format($stats['total_spent'], 0) }}</span>
                <span class="font-caps-xs text-outline">Total Spent</span>
            </div>
        </div>
    </div>

    <!-- Change Password Section -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-lg p-5">
        <h2 class="font-h2 text-on-surface text-lg flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined text-error">lock</span>
            Change Password
        </h2>
        <form method="POST" action="{{ route('farmer.profile.password') }}" class="space-y-4 max-w-md">
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
