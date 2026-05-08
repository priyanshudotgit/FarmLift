<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'FarmLift') - Share the Space, Cut the Cost</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-fixed-variant": "#004689",
                        "inverse-primary": "#a9c7ff",
                        "primary-fixed-dim": "#a9c7ff",
                        "on-tertiary": "#ffffff",
                        "on-primary-container": "#c9dbff",
                        "on-secondary-fixed": "#001b3c",
                        "inverse-surface": "#2f3034",
                        "on-error-container": "#93000a",
                        "on-secondary": "#ffffff",
                        "surface": "#faf9fe",
                        "surface-container-high": "#e8e7ec",
                        "on-tertiary-fixed": "#082100",
                        "surface-tint": "#3f5f92",
                        "on-primary-fixed-variant": "#254778",
                        "on-secondary-container": "#003971",
                        "surface-container-lowest": "#ffffff",
                        "surface-dim": "#dad9de",
                        "outline": "#747780",
                        "on-surface": "#1a1c1f",
                        "error": "#ba1a1a",
                        "tertiary-fixed": "#b3f48b",
                        "surface-container-low": "#f4f3f8",
                        "secondary-fixed-dim": "#a8c8ff",
                        "on-tertiary-container": "#abec84",
                        "tertiary-fixed-dim": "#98d772",
                        "surface-variant": "#e3e2e7",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#f1f0f5",
                        "secondary": "#015eb3",
                        "on-surface-variant": "#43474f",
                        "error-container": "#ffdad6",
                        "primary-container": "#406093",
                        "surface-bright": "#faf9fe",
                        "background": "#faf9fe",
                        "surface-container-highest": "#e3e2e7",
                        "tertiary": "#205200",
                        "secondary-container": "#67a4fe",
                        "on-error": "#ffffff",
                        "primary-fixed": "#d6e3ff",
                        "on-background": "#1a1c1f",
                        "surface-container": "#eeedf2",
                        "tertiary-container": "#346c13",
                        "primary": "#26487a",
                        "secondary-fixed": "#d5e3ff",
                        "outline-variant": "#c3c6d0",
                        "on-primary-fixed": "#001b3d",
                        "on-tertiary-fixed-variant": "#1f5100"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "lg": "2.5rem",
                        "margin": "2rem",
                        "md": "1.5rem",
                        "sm": "1rem",
                        "base": "4px",
                        "xs": "0.5rem",
                        "xl": "4rem",
                        "gutter": "1.5rem"
                    },
                    "fontFamily": {
                        "display": ["Inter"],
                        "h1": ["Inter"],
                        "h2": ["Inter"],
                        "caps-xs": ["Inter"],
                        "body-md": ["Inter"],
                        "label-sm": ["Inter"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "display": ["48px", { "lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "h1": ["32px", { "lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "h2": ["24px", { "lineHeight": "1.3", "fontWeight": "600" }],
                        "caps-xs": ["12px", { "lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "700" }],
                        "body-md": ["16px", { "lineHeight": "1.6", "fontWeight": "400" }],
                        "label-sm": ["14px", { "lineHeight": "1.4", "letterSpacing": "0.01em", "fontWeight": "500" }],
                        "body-lg": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .bento-shadow {
            box-shadow: 0 4px 30px rgba(0, 27, 61, 0.05);
        }
    </style>
</head>
<body class="bg-background text-on-background font-display min-h-screen flex flex-col">


<!-- TopAppBar -->
<header class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl sticky top-0 w-full z-50 border-b border-white/20 dark:border-slate-800/20 shadow-[0_4px_30px_rgba(0,0,0,0.05)] font-['Inter'] antialiased tracking-tight text-blue-600 dark:text-blue-400">
    <div class="flex justify-between items-center px-8 py-4 max-w-7xl mx-auto">
        <div class="flex items-center gap-8">
            <a href="/" class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter">FarmLift</a>
            <nav class="hidden md:flex gap-6">
                <a class="text-slate-600 dark:text-slate-400 font-medium hover:text-blue-500 dark:hover:text-blue-300 transition-all duration-300 active:scale-95" href="#marketplace">Marketplace</a>
                <a class="text-slate-600 dark:text-slate-400 font-medium hover:text-blue-500 dark:hover:text-blue-300 transition-all duration-300 active:scale-95" href="#capacity">Capacity</a>
                <a class="text-slate-600 dark:text-slate-400 font-medium hover:text-blue-500 dark:hover:text-blue-300 transition-all duration-300 active:scale-95" href="#routes">Routes</a>
                <a class="text-slate-600 dark:text-slate-400 font-medium hover:text-blue-500 dark:hover:text-blue-300 transition-all duration-300 active:scale-95" href="#sustainability">Sustainability</a>
            </nav>
        </div>
        <div class="flex items-center gap-4">
            @guest
                <a href="{{ route('login') }}" class="text-slate-600 dark:text-slate-400 font-medium hover:text-blue-500 dark:hover:text-blue-300 transition-all duration-300 active:scale-95">Login</a>
                <a href="{{ route('register') }}" class="bg-primary text-on-primary px-6 py-2 rounded-full font-label-sm hover:opacity-90 transition-opacity">Get Started</a>
            @endguest
            @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-slate-600 dark:text-slate-400 font-medium hover:text-blue-500 dark:hover:text-blue-300 transition-all duration-300">
                        {{ Auth::user()->name }}
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition.opacity
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                        @if(Auth::user()->isFarmer())
                            <a href="{{ route('farmer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                        @else
                            <a href="{{ route('driver.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                            <a href="{{ route('driver.trip.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Create Trip</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Log Out</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>

<main class="flex-grow flex flex-col items-center w-full px-0 pt-xl pb-24 gap-xl">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-50 border-l-4 border-[#91D06C] p-4 rounded-md shadow-sm flex justify-between">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-[#91D06C]" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="ml-3"><p class="text-sm text-green-800">{{ session('success') }}</p></div>
                    </div>
                    <button @click="show = false" class="text-green-800 hover:text-green-900">&times;</button>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md shadow-sm flex justify-between">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="ml-3"><p class="text-sm text-red-800">{{ session('error') }}</p></div>
                    </div>
                    <button @click="show = false" class="text-red-800 hover:text-red-900">&times;</button>
                </div>
            </div>
        @endif



        @yield('content')
    </main>

<!-- Footer -->
<footer class="bg-slate-950 dark:bg-black font-['Inter'] text-sm text-slate-400 w-full py-12 mt-20 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-2 lg:flex lg:justify-between items-start">
        <div class="flex flex-col gap-4 mb-8 lg:mb-0">
            <div class="text-xl font-bold text-white">FarmLift</div>
            <p>© 2024 FarmLift Logistics. Efficiency in every load.</p>
        </div>
        <div class="flex flex-wrap gap-8">
            <div class="flex flex-col gap-2">
                <a class="text-slate-500 hover:text-white transition-colors" href="#">Network</a>
                <a class="text-slate-500 hover:text-white transition-colors" href="#">Carrier Portal</a>
            </div>
            <div class="flex flex-col gap-2">
                <a class="text-slate-500 hover:text-white transition-colors" href="#">Terms of Service</a>
                <a class="text-slate-500 hover:text-white transition-colors" href="#">Privacy Policy</a>
                <a class="text-slate-500 hover:text-white transition-colors" href="#">Contact Support</a>
            </div>
        </div>
    </div>
</footer>

    @yield('scripts')
</body>
</html>
