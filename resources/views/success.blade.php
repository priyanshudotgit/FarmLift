@extends('layouts.auth')

@section('content')
<main class="flex min-h-screen w-full items-center justify-center relative overflow-hidden bg-pattern">
    {{-- Background blobs --}}
    <div class="absolute top-[-20%] left-[-10%] w-[80vw] lg:w-[50vw] h-[80vw] lg:h-[50vw] rounded-full bg-gradient-to-br from-[#FFF799]/40 to-transparent blur-[120px] mix-blend-multiply opacity-70 z-0"></div>
    <div class="absolute bottom-[-10%] right-[-20%] w-[90vw] lg:w-[50vw] h-[90vw] lg:h-[50vw] rounded-full bg-gradient-to-tl from-[#406093]/20 to-transparent blur-[140px] mix-blend-multiply opacity-80 z-0"></div>

    <div class="relative z-10 w-full max-w-lg mx-4">
        {{-- Success Card --}}
        <div class="bg-surface/80 backdrop-blur-xl rounded-3xl shadow-[0_20px_60px_-15px_rgba(38,72,122,0.15)] border border-white/60 p-10 text-center">
            {{-- Animated checkmark --}}
            <div class="mx-auto w-20 h-20 rounded-full flex items-center justify-center mb-6
                {{ Auth::user()->role === 'farmer' ? 'bg-gradient-to-br from-farmer-state to-tertiary-container' : 'bg-gradient-to-br from-driver-state to-primary' }}
                shadow-lg">
                <span class="material-symbols-outlined text-white text-[40px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            </div>

            <h1 class="font-h1 text-[28px] text-on-surface tracking-tight font-bold mb-2">
                Welcome, {{ Auth::user()->name }}!
            </h1>

            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full mb-4
                {{ Auth::user()->role === 'farmer' ? 'bg-farmer-state/15 text-farmer-state' : 'bg-driver-state/15 text-driver-state' }}
                font-label-sm text-[13px] font-bold uppercase tracking-wide">
                <span class="material-symbols-outlined text-[16px]">
                    {{ Auth::user()->role === 'farmer' ? 'agriculture' : 'local_shipping' }}
                </span>
                {{ ucfirst(Auth::user()->role) }}
            </div>

            <p class="font-body-md text-body-md text-on-surface-variant mt-2 mb-8">
                You have successfully logged in to FarmLift. Your account is ready to use.
            </p>

            {{-- Quick Actions --}}
            <div class="flex flex-col gap-3">
                <a href="{{ route('home') }}"
                   class="w-full py-3.5 px-4 font-label-sm text-body-md font-bold rounded-xl hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2 text-on-primary
                   {{ Auth::user()->role === 'farmer' ? 'bg-gradient-to-r from-farmer-state to-tertiary-container hover:shadow-[0_8px_20px_rgba(145,208,108,0.3)]' : 'bg-gradient-to-r from-driver-state to-primary hover:shadow-[0_8px_20px_rgba(76,140,228,0.3)]' }}">
                    Go to Dashboard
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3.5 px-4 border-2 border-outline-variant text-on-surface-variant bg-surface/30 backdrop-blur-sm font-label-sm text-body-md font-bold rounded-xl hover:bg-surface/80 hover:border-outline transition-all">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>

        {{-- Footer --}}
        <p class="text-center font-label-sm text-[12px] text-outline mt-6">
            &copy; {{ date('Y') }} FarmLift Logistics. All rights reserved.
        </p>
    </div>
</main>
@endsection
