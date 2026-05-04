@extends('layouts.landing')

@section('content')
<!-- TopAppBar -->
<header class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl sticky top-0 w-full z-50 border-b border-white/20 dark:border-slate-800/20 shadow-[0_4px_30px_rgba(0,0,0,0.05)] font-['Inter'] antialiased tracking-tight text-blue-600 dark:text-blue-400 flex justify-between items-center px-8 py-4 max-w-7xl mx-auto">
    <div class="flex items-center gap-8">
        <div class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter">FarmLift</div>
        <nav class="hidden md:flex gap-6">
            <a class="text-slate-600 dark:text-slate-400 font-medium hover:text-blue-500 dark:hover:text-blue-300 transition-all duration-300 active:scale-95 transition-transform" href="#marketplace">Marketplace</a>
            <a class="text-slate-600 dark:text-slate-400 font-medium hover:text-blue-500 dark:hover:text-blue-300 transition-all duration-300 active:scale-95 transition-transform" href="#capacity">Capacity</a>
            <a class="text-slate-600 dark:text-slate-400 font-medium hover:text-blue-500 dark:hover:text-blue-300 transition-all duration-300 active:scale-95 transition-transform" href="#routes">Routes</a>
            <a class="text-slate-600 dark:text-slate-400 font-medium hover:text-blue-500 dark:hover:text-blue-300 transition-all duration-300 active:scale-95 transition-transform" href="#sustainability">Sustainability</a>
        </nav>
    </div>
    <div class="flex items-center gap-4">
        <a href="{{ route('login') }}" class="text-slate-600 dark:text-slate-400 font-medium hover:text-blue-500 dark:hover:text-blue-300 transition-all duration-300 active:scale-95 transition-transform">Login</a>
        <a href="{{ route('register') }}" class="bg-primary text-on-primary px-6 py-2 rounded-full font-label-sm hover:opacity-90 transition-opacity">Get Started</a>
    </div>
</header>

<main class="flex-grow flex flex-col items-center w-full max-w-[1280px] mx-auto px-margin pt-xl pb-24 gap-xl">
    <!-- Hero Section -->
    <section class="w-full grid grid-cols-1 lg:grid-cols-2 gap-xl items-center relative">
        <div class="flex flex-col gap-md z-10">
            <h1 class="font-display text-display text-primary-container">Share the Space, Cut the Cost</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg">The smartest way for farmers to book refrigerated transport and for drivers to fill their trucks.</p>
            
            <!-- Floating Search Component -->
            <div class="glass-panel p-md rounded-xl mt-sm flex flex-col gap-sm w-full max-w-md">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">location_on</span>
                    <input class="w-full pl-10 pr-4 py-3 rounded-lg border border-surface-dim bg-white/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md" placeholder="Pickup Location" type="text"/>
                </div>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">pin_drop</span>
                    <input class="w-full pl-10 pr-4 py-3 rounded-lg border border-surface-dim bg-white/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md" placeholder="Destination" type="text"/>
                </div>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">calendar_month</span>
                    <input class="w-full pl-10 pr-4 py-3 rounded-lg border border-surface-dim bg-white/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md text-on-surface-variant" type="date"/>
                </div>
                <button class="bg-primary-container text-on-primary px-6 py-3 rounded-lg font-label-sm text-label-sm w-full hover:bg-primary transition-colors mt-2">Search Trucks</button>
            </div>
        </div>
        
        <!-- 3D Dashboard Snippet (Abstract) -->
        <div class="relative h-[500px] w-full flex justify-center items-center">
            <!-- Abstract Decorative Elements -->
            <div class="absolute inset-0 bg-gradient-to-tr from-surface-container to-surface-bright rounded-3xl -z-10 overflow-hidden">
                <div class="absolute top-10 left-10 w-32 h-32 bg-primary-fixed rounded-full blur-3xl opacity-50"></div>
                <div class="absolute bottom-10 right-10 w-40 h-40 bg-tertiary-fixed rounded-full blur-3xl opacity-50"></div>
            </div>
            
            <!-- Bento Style Dashboard Cards -->
            <div class="relative z-10 w-full max-w-sm flex flex-col gap-md">
                <!-- Capacity Card -->
                <div class="bg-surface-container-lowest rounded-xl p-[24px] bento-shadow flex flex-col gap-[16px]">
                    <div class="flex justify-between items-center">
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Live Capacity</span>
                        <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    </div>
                    <div class="h-2 bg-surface-variant rounded-full overflow-hidden w-full">
                        <div class="h-full bg-tertiary-fixed-dim rounded-full w-[75%] relative overflow-hidden">
                            <div class="absolute inset-0 bg-white/20" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.1) 10px, rgba(255,255,255,0.1) 20px);"></div>
                        </div>
                    </div>
                    <div class="flex justify-between text-caps-xs font-caps-xs text-outline">
                        <span>Available: 25%</span>
                        <span>Filled: 75%</span>
                    </div>
                </div>
                
                <!-- Route Connectivity Card -->
                <div class="bg-surface-container-lowest rounded-xl p-[24px] bento-shadow flex flex-col gap-[16px] relative overflow-hidden">
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Active Route</span>
                    <div class="flex items-center justify-between w-full pt-4">
                        <div class="w-3 h-3 rounded-full bg-primary relative z-10"></div>
                        <div class="flex-grow h-[2px] bg-primary relative z-0 mx-2"></div>
                        <div class="w-3 h-3 rounded-full bg-surface-variant border-2 border-primary relative z-10"></div>
                    </div>
                    <div class="flex justify-between text-caps-xs font-caps-xs text-outline mt-1">
                        <span>Origin Farm</span>
                        <span>City Hub</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Bento Grid -->
    <section class="w-full pt-xl" id="marketplace">
        <h2 class="font-h2 text-h2 text-on-surface mb-lg text-center">Engineered for Efficiency</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
            <!-- Bento Box 1 -->
            <div class="bg-surface-container-lowest rounded-xl p-[24px] bento-shadow flex flex-col gap-[16px] h-64">
                <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[24px]">bar_chart</span>
                </div>
                <h3 class="font-h2 text-h2 text-on-surface text-[20px]">Real-time Capacity</h3>
                <p class="font-body-md text-body-md text-on-surface-variant flex-grow">Instantly see available truck space to maximize loads and minimize deadhead miles.</p>
            </div>
            
            <!-- Bento Box 2 -->
            <div class="bg-surface-container-lowest rounded-xl p-[24px] bento-shadow flex flex-col gap-[16px] h-64">
                <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center text-primary-container">
                    <span class="material-symbols-outlined text-[24px]">ac_unit</span>
                </div>
                <h3 class="font-h2 text-h2 text-on-surface text-[20px]">Cold Chain Verified</h3>
                <p class="font-body-md text-body-md text-on-surface-variant flex-grow">Ensure your temperature-sensitive agricultural goods are transported under strict conditions.</p>
            </div>
            
            <!-- Bento Box 3 -->
            <div class="bg-surface-container-lowest rounded-xl p-[24px] bento-shadow flex flex-col gap-[16px] h-64">
                <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[24px]">route</span>
                </div>
                <h3 class="font-h2 text-h2 text-on-surface text-[20px]">Route Optimization</h3>
                <p class="font-body-md text-body-md text-on-surface-variant flex-grow">Smart algorithms connect partial loads along efficient paths, saving time and fuel.</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="w-full bg-[#FFF799] rounded-3xl p-xl mt-xl flex flex-col md:flex-row gap-lg items-center bento-shadow">
        <div class="flex-1 flex flex-col gap-md">
            <h2 class="font-h1 text-h1 text-on-surface">Get in Touch</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant">Need assistance or have questions about logistics? Our team is ready to help you optimize your agricultural transport.</p>
            <a class="font-label-sm text-label-sm text-primary underline mt-2" href="#">Visit Help Center</a>
        </div>
        <div class="flex-1 w-full bg-white/60 backdrop-blur-md rounded-xl p-md border border-white/40">
            <form class="flex flex-col gap-sm" action="#" method="POST">
                @csrf
                <input class="w-full px-4 py-3 rounded-lg border border-surface-dim bg-white/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md" placeholder="Name" type="text" required/>
                <input class="w-full px-4 py-3 rounded-lg border border-surface-dim bg-white/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md" placeholder="Email" type="email" required/>
                <textarea class="w-full px-4 py-3 rounded-lg border border-surface-dim bg-white/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md resize-none" placeholder="Message" rows="4" required></textarea>
                <button class="bg-primary text-on-primary px-6 py-3 rounded-lg font-label-sm text-label-sm hover:opacity-90 transition-opacity mt-2 self-end" type="submit">Send Message</button>
            </form>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="bg-slate-950 dark:bg-black font-['Inter'] text-sm text-slate-400 w-full py-12 mt-20 border-t border-slate-800 flat no shadows max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-2 lg:flex lg:justify-between items-start">
    <div class="flex flex-col gap-4 mb-8 lg:mb-0">
        <div class="text-xl font-bold text-white">FarmLift</div>
        <p>&copy; {{ date('Y') }} FarmLift Logistics. Efficiency in every load.</p>
    </div>
    <div class="flex flex-wrap gap-8">
        <div class="flex flex-col gap-2">
            <a class="text-slate-500 hover:text-white transition-colors opacity-100 hover:opacity-80" href="#marketplace">Network</a>
            <a class="text-slate-500 hover:text-white transition-colors opacity-100 hover:opacity-80" href="{{ route('transporter.dashboard') }}">Carrier Portal</a>
        </div>
        <div class="flex flex-col gap-2">
            <a class="text-slate-500 hover:text-white transition-colors opacity-100 hover:opacity-80" href="#">Terms of Service</a>
            <a class="text-slate-500 hover:text-white transition-colors opacity-100 hover:opacity-80" href="#">Privacy Policy</a>
            <a class="text-slate-500 hover:text-white transition-colors opacity-100 hover:opacity-80" href="#">Contact Support</a>
        </div>
    </div>
</footer>
@endsection
