<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - FarmLift</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        /* Abstract Pattern Overlay */
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23406093' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .floating-shape {
            animation: float 15s ease-in-out infinite;
        }

        .floating-shape-delayed {
            animation: float 20s ease-in-out infinite alternate-reverse;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg) scale(1); }
            33% { transform: translateY(-30px) rotate(10deg) scale(1.05); }
            66% { transform: translateY(20px) rotate(-5deg) scale(0.95); }
            100% { transform: translateY(0px) rotate(0deg) scale(1); }
        }
    </style>
    
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
<body class="bg-[#fcfdfd] max-h-screen relative overflow-x-hidden font-body-md text-body-md text-on-surface">
<header class="fixed top-0 left-0 w-full z-50 bg-surface/70 backdrop-blur-xl border-b border-white/60 shadow-[0_4px_24px_-8px_rgba(38,72,122,0.1)] px-8 py-4 flex items-center justify-between transition-all">
<div class="font-h1 text-[24px] text-primary tracking-tight font-bold">FarmLift</div>
<nav class="hidden md:flex gap-8 font-label-sm text-on-surface-variant font-medium">
<a class="hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
<a class="hover:text-primary transition-colors" href="#">Solutions</a>
<a class="hover:text-primary transition-colors" href="#">Support</a>
</nav>
</header>
<main class="flex min-h-screen w-full overflow-auto">
<!-- Right Side: Authentication -->
<div class="w-full flex items-center justify-center relative p-6 pb-12 overflow-hidden bg-pattern">
<!-- Background Gradients -->
<div class="absolute top-[-20%] left-[-10%] w-[80vw] lg:w-[40vw] h-[80vw] lg:h-[40vw] rounded-full bg-gradient-to-br from-[#FFF799]/40 to-transparent blur-[120px] mix-blend-multiply opacity-70 z-0"></div>
<div class="absolute bottom-[-10%] right-[-20%] w-[90vw] lg:w-[50vw] h-[90vw] lg:h-[50vw] rounded-full bg-gradient-to-tl from-[#406093]/20 to-transparent blur-[140px] mix-blend-multiply opacity-80 z-0"></div>
<!-- Auth Card -->
<div class="w-full max-w-[440px] z-10">
<!-- Header -->
<div class="text-center mb-6 relative z-10">
<h1 class="font-h1 text-[36px] text-primary tracking-tight">FarmLift</h1>
<p class="font-body-md text-body-lg text-on-surface-variant mt-2 font-medium">Welcome back. Please select your role.</p>
</div>
<!-- Segmented Control (Tactile Role Toggle) -->
<div x-data="{ role: 'driver' }" class="bg-surface-variant/50 backdrop-blur-md rounded-xl p-1.5 flex mb-6 relative shadow-inner border border-outline-variant/20">
<button type="button" @click="role = 'farmer'" :class="role === 'farmer' ? 'bg-surface shadow-[0_2px_8px_rgba(0,0,0,0.08)] rounded-lg font-label-sm text-[15px] text-farmer-state font-bold transition-all flex items-center justify-center gap-2 z-10 border border-white/60 flex-1 py-2.5' : 'flex-1 py-2.5 font-label-sm text-[15px] text-on-surface-variant rounded-lg hover:text-on-surface hover:bg-surface/40 transition-all z-10'">
                        Farmer
                    </button>
<button type="button" @click="role = 'driver'" :class="role === 'driver' ? 'bg-surface shadow-[0_2px_8px_rgba(0,0,0,0.08)] rounded-lg font-label-sm text-[15px] text-driver-state font-bold transition-all flex items-center justify-center gap-2 z-10 border border-white/60 flex-1 py-2.5' : 'flex-1 py-2.5 font-label-sm text-[15px] text-on-surface-variant rounded-lg hover:text-on-surface hover:bg-surface/40 transition-all z-10'">
<span class="material-symbols-outlined text-[20px]"></span>
                        Truck Driver
                    </button>
</div>
<!-- Login Form -->
<form class="space-y-4 relative z-10" action="{{ route('login') }}" method="POST">
@csrf
<!-- Floating Label Input: Email -->
<div class="relative bg-surface/50 rounded-t-lg px-4 pt-5 pb-2 border-b-2 border-outline-variant hover:border-outline focus-within:border-driver-state focus-within:bg-surface/80 transition-all">
<input class="peer w-full bg-transparent font-body-md text-body-md text-on-surface focus:outline-none placeholder-transparent transition-colors" id="email" name="email" type="email" placeholder="Email Address" required value="{{ old('email') }}">
<label class="absolute left-4 top-2 font-label-sm text-[12px] text-outline transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-body-md peer-focus:top-2 peer-focus:text-[12px] peer-focus:text-driver-state cursor-text" for="email">Email Address</label>
</div>
@error('email')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
<!-- Floating Label Input: Password -->
<div class="relative bg-surface/50 rounded-t-lg px-4 pt-5 pb-2 border-b-2 border-outline-variant hover:border-outline focus-within:border-driver-state focus-within:bg-surface/80 transition-all mt-4">
<input class="peer w-full bg-transparent font-body-md text-body-md text-on-surface focus:outline-none placeholder-transparent transition-colors" id="password" name="password" type="password" placeholder="Password" required>
<label class="absolute left-4 top-2 font-label-sm text-[12px] text-outline transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-body-md peer-focus:top-2 peer-focus:text-[12px] peer-focus:text-driver-state cursor-text" for="password">Password</label>
</div>
@error('password')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
<!-- Auxiliary Form Links -->
<div class="flex items-center justify-between mt-4 px-1">
<label class="flex items-center gap-3 cursor-pointer group">
<input type="checkbox" name="remember" class="w-5 h-5 rounded border-2 border-outline flex items-center justify-center group-hover:border-driver-state bg-surface transition-all shadow-sm">
<span class="font-label-sm text-label-sm text-on-surface-variant group-hover:text-on-surface transition-colors font-medium">Remember me</span>
</label>
<a class="font-label-sm text-label-sm text-driver-state hover:text-primary hover:underline font-medium transition-colors" href="#">Forgot password?</a>
</div>
<!-- Action Buttons -->
<div class="pt-6 space-y-4">
<button class="w-full py-3.5 px-4 bg-gradient-to-r from-driver-state to-primary text-on-primary font-label-sm text-body-md font-bold rounded-xl hover:shadow-[0_8px_20px_rgba(76,140,228,0.3)] hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2" type="submit">
                            Sign In
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
</button>
</div>
</form>
<!-- Bottom State Toggle -->
<div class="mt-6 text-center relative z-10 pt-6 border-t border-outline-variant/30">
<p class="font-body-md text-body-md text-on-surface-variant">
                        Don't have an account? <a class="text-driver-state hover:text-primary hover:underline font-bold ml-1 transition-colors" href="{{ route('register') }}">Create Account</a>
</p>
</div>
</div>
</div>
</main>
</body>
</html>
