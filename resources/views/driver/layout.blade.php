<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FarmLift — Driver')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed": "#b3f48b",
                        "surface-dim": "#dad9de",
                        "on-surface-variant": "#43474f",
                        "on-secondary": "#ffffff",
                        "surface-variant": "#e3e2e7",
                        "tertiary-container": "#346c13",
                        "surface-tint": "#3f5f92",
                        "surface": "#faf9fe",
                        "background": "#faf9fe",
                        "primary": "#26487a",
                        "on-secondary-container": "#003971",
                        "on-primary-fixed-variant": "#254778",
                        "error": "#ba1a1a",
                        "on-primary": "#ffffff",
                        "primary-container": "#406093",
                        "secondary-container": "#67a4fe",
                        "secondary": "#015eb3",
                        "on-tertiary-fixed": "#082100",
                        "on-tertiary-container": "#abec84",
                        "on-primary-container": "#c9dbff",
                        "surface-container-lowest": "#ffffff",
                        "inverse-surface": "#2f3034",
                        "surface-bright": "#faf9fe",
                        "tertiary": "#205200",
                        "on-tertiary-fixed-variant": "#1f5100",
                        "on-background": "#1a1c1f",
                        "primary-fixed-dim": "#a9c7ff",
                        "outline": "#747780",
                        "primary-fixed": "#d6e3ff",
                        "surface-container": "#eeedf2",
                        "on-error": "#ffffff",
                        "on-primary-fixed": "#001b3d",
                        "secondary-fixed-dim": "#a8c8ff",
                        "on-secondary-fixed": "#001b3c",
                        "secondary-fixed": "#d5e3ff",
                        "on-surface": "#1a1c1f",
                        "on-error-container": "#93000a",
                        "surface-container-low": "#f4f3f8",
                        "outline-variant": "#c3c6d0",
                        "inverse-on-surface": "#f1f0f5",
                        "surface-container-highest": "#e3e2e7",
                        "error-container": "#ffdad6",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed-variant": "#004689",
                        "inverse-primary": "#a9c7ff",
                        "tertiary-fixed-dim": "#98d772",
                        "surface-container-high": "#e8e7ec"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "sm": "1rem",
                        "md": "1.5rem",
                        "gutter": "1.5rem",
                        "xl": "4rem",
                        "xs": "0.5rem",
                        "lg": "2.5rem",
                        "base": "4px",
                        "margin": "2rem"
                    },
                    "fontFamily": {
                        "body-lg": ["Inter"],
                        "caps-xs": ["Inter"],
                        "body-md": ["Inter"],
                        "h2": ["Inter"],
                        "label-sm": ["Inter"],
                        "h1": ["Inter"],
                        "display": ["Inter"]
                    },
                    "fontSize": {
                        "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "caps-xs": ["12px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "700"}],
                        "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "h2": ["24px", {"lineHeight": "1.3", "fontWeight": "600"}],
                        "label-sm": ["14px", {"lineHeight": "1.4", "letterSpacing": "0.01em", "fontWeight": "500"}],
                        "h1": ["32px", {"lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "display": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}]
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeSlideIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .page-enter { animation: fadeSlideIn 0.35s ease-out; }
        .nav-tooltip {
            position: absolute; left: 100%; top: 50%; transform: translateY(-50%);
            background: #1a1c1f; color: #fff; padding: 4px 10px; border-radius: 6px;
            font-size: 12px; font-weight: 600; white-space: nowrap;
            opacity: 0; pointer-events: none; transition: opacity 0.2s;
            margin-left: 8px; z-index: 100;
        }
        .nav-item:hover .nav-tooltip { opacity: 1; }
        @keyframes pulse-soft { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
        .pulse-soft { animation: pulse-soft 2s ease-in-out infinite; }

        .status-pending { background: rgba(255, 247, 153, 0.4); color: #b49000; border: 1px solid rgba(255, 247, 153, 0.6); }
        .status-confirmed { background: rgba(145, 208, 108, 0.2); color: #205200; border: 1px solid rgba(145, 208, 108, 0.4); }
        .status-pickedup { background: rgba(76, 140, 228, 0.15); color: #26487a; border: 1px solid rgba(76, 140, 228, 0.3); }
        .status-delivered { background: rgba(145, 208, 108, 0.3); color: #1a5200; border: 1px solid rgba(145, 208, 108, 0.5); }
        .status-cancelled { background: rgba(186, 26, 26, 0.1); color: #ba1a1a; border: 1px solid rgba(186, 26, 26, 0.2); }
        .status-scheduled { background: rgba(76, 140, 228, 0.1); color: #26487a; border: 1px solid rgba(76, 140, 228, 0.2); }
        .status-active { background: rgba(145, 208, 108, 0.15); color: #205200; border: 1px solid rgba(145, 208, 108, 0.3); }
        .status-completed { background: rgba(116, 119, 128, 0.12); color: #43474f; border: 1px solid rgba(116, 119, 128, 0.25); }
    </style>
    @stack('styles')
</head>
<body class="bg-surface text-on-surface font-body-md min-h-screen flex">

    <!-- Static Side Navigation Bar -->
    <nav class="fixed left-0 top-0 bottom-0 z-50 flex flex-col items-center py-6 h-screen w-[4.5rem] md:w-56 border-r border-white/10 shadow-2xl shadow-blue-900/20 bg-[#406093] dark:bg-slate-950/80 backdrop-blur-xl">
        <!-- Logo -->
        <div class="px-4 mb-8 flex items-center gap-2">
            <span class="text-xl font-black text-white tracking-tighter">FL</span>
            <span class="hidden md:block text-white/70 font-caps-xs uppercase tracking-wider">Driver</span>
        </div>

        <!-- Navigation Links -->
        <div class="flex flex-col gap-1 w-full px-2 flex-1">
            <!-- Dashboard -->
            <a class="nav-item relative {{ request()->routeIs('driver.dashboard') ? 'bg-[#FDE68A] text-[#406093] font-bold' : 'text-white/70 hover:text-white hover:bg-white/10' }} rounded-xl mx-2 px-3 py-3 flex items-center gap-3 transition-all duration-300 font-sans text-sm font-medium tracking-tight"
               href="{{ route('driver.dashboard') }}" title="Dashboard">
                <span class="material-symbols-outlined" @if(request()->routeIs('driver.dashboard')) style="font-variation-settings: 'FILL' 1;" @endif>dashboard</span>
                <span class="hidden md:block">Dashboard</span>
                <span class="nav-tooltip md:hidden">Dashboard</span>
            </a>
            <!-- Load Board -->
            <a class="nav-item relative {{ request()->routeIs('driver.loadboard') ? 'bg-[#FDE68A] text-[#406093] font-bold' : 'text-white/70 hover:text-white hover:bg-white/10' }} rounded-xl mx-2 px-3 py-3 flex items-center gap-3 transition-all duration-300 font-sans text-sm font-medium tracking-tight"
               href="{{ route('driver.loadboard') }}" title="Load Board">
                <span class="material-symbols-outlined" @if(request()->routeIs('driver.loadboard')) style="font-variation-settings: 'FILL' 1;" @endif>local_shipping</span>
                <span class="hidden md:block">Load Board</span>
                <span class="nav-tooltip md:hidden">Load Board</span>
            </a>
            <!-- Earnings -->
            <a class="nav-item relative {{ request()->routeIs('driver.earnings') ? 'bg-[#FDE68A] text-[#406093] font-bold' : 'text-white/70 hover:text-white hover:bg-white/10' }} rounded-xl mx-2 px-3 py-3 flex items-center gap-3 transition-all duration-300 font-sans text-sm font-medium tracking-tight"
               href="{{ route('driver.earnings') }}" title="Earnings">
                <span class="material-symbols-outlined" @if(request()->routeIs('driver.earnings')) style="font-variation-settings: 'FILL' 1;" @endif>payments</span>
                <span class="hidden md:block">Earnings</span>
                <span class="nav-tooltip md:hidden">Earnings</span>
            </a>
            <!-- Profile -->
            <a class="nav-item relative {{ request()->routeIs('driver.profile') ? 'bg-[#FDE68A] text-[#406093] font-bold' : 'text-white/70 hover:text-white hover:bg-white/10' }} rounded-xl mx-2 px-3 py-3 flex items-center gap-3 transition-all duration-300 font-sans text-sm font-medium tracking-tight"
               href="{{ route('driver.profile') }}" title="Profile">
                <span class="material-symbols-outlined" @if(request()->routeIs('driver.profile')) style="font-variation-settings: 'FILL' 1;" @endif>account_circle</span>
                <span class="hidden md:block">Profile</span>
                <span class="nav-tooltip md:hidden">Profile</span>
            </a>
        </div>

        <!-- Bottom Section: Post Load + Logout -->
        <div class="w-full px-3 mt-auto space-y-2">
            <a href="{{ route('driver.trip.create') }}" class="block w-full bg-[#FDE68A] text-[#406093] font-label-sm py-3 rounded-lg font-bold hover:bg-white transition-colors text-center">
                <span class="material-symbols-outlined text-[18px] align-middle mr-1">add_circle</span>
                <span class="hidden md:inline">Post Load</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <!-- <button type="submit" class="nav-item relative w-full text-white/70 hover:text-red-300 hover:bg-red-500/15 rounded-xl p-2.5 flex items-center justify-center md:justify-start gap-3 transition-all duration-300 font-sans text-sm font-medium tracking-tight" title="Logout">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="hidden md:block">Logout</span>
                    <span class="nav-tooltip md:hidden">Sign Out</span>
                </button> -->
            </form>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col ml-[4.5rem] md:ml-56 w-[calc(100%-4.5rem)] md:w-[calc(100%-14rem)]">
        <!-- Top App Bar -->
        <header class="flex justify-between items-center w-full px-6 py-3 sticky top-0 z-40 bg-white/70 dark:bg-slate-900/70 backdrop-blur-md border-b border-slate-200/50 dark:border-slate-800/50 shadow-sm transition-colors">
            <div class="flex items-center gap-4 flex-1">
                <div class="flex items-center text-slate-500 font-sans font-semibold text-sm">
                    <span>Command Center</span>
                    <span class="material-symbols-outlined text-[16px] mx-1">chevron_right</span>
                    <span class="text-[#406093] font-bold border-b-2 border-[#406093] pb-0.5">@yield('breadcrumb', 'Overview')</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 rounded-full hover:bg-slate-50 transition-colors text-slate-500 hover:text-slate-900">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-[#406093] to-[#4C8CE4] flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500/10 hover:bg-red-500/20 text-red-600 px-4 py-2 rounded-lg font-label-sm transition-all duration-200 flex items-center gap-2 border border-red-500/20">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Dynamic Main Content -->
        <main class="p-4 flex-1 max-w-7xl mx-auto w-full page-enter">
            @if(session('success'))
                <div class="mb-4 p-3 bg-[#91D06C]/20 border border-[#91D06C]/40 rounded-lg text-tertiary font-label-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 border border-red-200 rounded-lg text-red-700 font-label-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">error</span>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
