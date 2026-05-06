@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="relative overflow-hidden bg-white">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-y-0 w-full h-full bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] opacity-30"></div>
        <div class="absolute inset-x-0 top-0 h-64 bg-gradient-to-b from-blue-50/50 to-transparent"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-medium mb-8">
            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
            Smart Logistics for Agriculture
        </div>
        
        <h1 class="text-5xl md:text-7xl font-extrabold text-[#406093] tracking-tight mb-8">
            Share the Truck. <br />
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4C8CE4] to-[#91D06C]">Split the Cost.</span>
        </h1>
        
        <p class="max-w-2xl mx-auto text-xl text-gray-600 mb-10 leading-relaxed">
            FarmLift connects farmers with shared truck space, cutting logistics costs and getting produce to market faster.
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-[#406093] to-[#4C8CE4] text-white rounded-full font-semibold text-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                Get Started Now
            </a>
            <a href="#how-it-works" class="px-8 py-4 bg-white text-[#406093] border border-gray-200 rounded-full font-semibold text-lg shadow-sm hover:bg-gray-50 transition-all">
                See How It Works
            </a>
        </div>
    </div>
</div>

<!-- Bento Grid Features -->
<div id="how-it-works" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900">Why FarmLift?</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 text-2xl">🌍</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Geo-Spatial Discovery</h3>
                <p class="text-gray-600 text-lg">Find active trucks passing within a 30km radius of your farm. Powered by MongoDB advanced geospatial queries to ensure perfect routing.</p>
            </div>
            
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6 text-2xl">⚡</div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Atomic Booking</h3>
                <p class="text-gray-600">Zero race conditions. Our capacity system safely allocates payload space instantly.</p>
            </div>
            
            <div class="bg-gradient-to-br from-[#406093] to-[#4C8CE4] rounded-3xl p-8 shadow-md text-white">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6 text-2xl">🚚</div>
                <h3 class="text-xl font-bold mb-4">For Drivers</h3>
                <p class="text-blue-50 opacity-90">Maximize payload. Never drive empty. Accept loads on your route easily.</p>
            </div>
            
            <div class="md:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center mb-6 text-2xl">🔔</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Real-Time Status</h3>
                <p class="text-gray-600 text-lg">Track your produce from Pending to Delivered. Instant notifications keep both parties synced.</p>
            </div>
        </div>
    </div>
</div>
@endsection
