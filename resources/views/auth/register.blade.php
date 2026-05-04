@extends('layouts.auth')

@section('content')
<header class="fixed top-0 left-0 w-full z-50 bg-surface/70 backdrop-blur-xl border-b border-white/60 shadow-[0_4px_24px_-8px_rgba(38,72,122,0.1)] px-8 py-4 flex items-center justify-between transition-all">
    <div class="font-h1 text-[24px] text-primary tracking-tight font-bold">FarmLift</div>
    <nav class="hidden md:flex gap-8 font-label-sm text-on-surface-variant font-medium">
        <a class="hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
        <a class="hover:text-primary transition-colors" href="#">Solutions</a>
        <a class="hover:text-primary transition-colors" href="#">Support</a>
    </nav>
</header>

<main class="flex min-h-screen w-full pt-20">
    <div class="hidden lg:flex lg:w-1/2 relative bg-surface-container overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCmFlJ5ePn_KJO0dih99hpOMh0HM5fHwwtt1bR5d0G5yzpr18Zd9BvuTD_cmRTarX9h1WJkCAX07IpYqlS3-Lld3z4LT2p46c53_LdQ7vCV92Y4hAvCPNWL_gPOY80rV_rS-i8w0H3Bdh3iNenCuGaXLunyhywwgI-tcE6VBTLKSYcGnP22yC3EBhpNbLGWuy3O-eYdsH8cJGZ5UKM6SW8EgtyA5HjhOAeU7zy9T4rH3oJwtoBvmhG2aDVXdxtT2o1PKf-tyD_D6-fe');"></div>
        <div class="absolute inset-0 bg-gradient-to-tr from-primary-container/80 to-transparent mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-primary/60 via-transparent to-transparent"></div>
        <svg class="absolute top-[15%] left-[5%] w-[400px] h-[400px] floating-shape opacity-40 text-brand-yellow" fill="none" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 100 Q 80 20 150 80 T 180 180" stroke="currentColor" stroke-dasharray="4 4" stroke-linecap="round" stroke-width="2"></path>
            <circle cx="20" cy="100" fill="currentColor" r="4"></circle>
            <circle cx="150" cy="80" fill="currentColor" r="6"></circle>
            <circle cx="180" cy="180" fill="currentColor" r="4"></circle>
        </svg>
        <svg class="absolute bottom-[10%] right-[10%] w-[500px] h-[500px] floating-shape-delayed opacity-30 text-white" fill="none" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 190 Q 50 100 130 140 T 190 20" stroke="currentColor" stroke-width="3"></path>
            <circle cx="10" cy="190" fill="currentColor" r="5"></circle>
            <circle cx="130" cy="140" fill="white" r="4" stroke="currentColor" stroke-width="2"></circle>
            <circle cx="190" cy="20" fill="currentColor" r="7"></circle>
        </svg>
        <div class="absolute bottom-16 left-12 max-w-lg text-white">
            <h2 class="font-display text-[40px] leading-tight mb-4">Start your transport journey with FarmLift.</h2>
            <p class="font-body-lg text-white/80">Register now to connect farms, routes, and refrigerated capacity.</p>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center relative p-6 pt-24 pb-12 overflow-hidden bg-pattern">
        <div class="absolute top-[-20%] left-[-10%] w-[80vw] lg:w-[40vw] h-[80vw] lg:h-[40vw] rounded-full bg-gradient-to-br from-[#FFF799]/40 to-transparent blur-[120px] mix-blend-multiply opacity-70 z-0"></div>
        <div class="absolute bottom-[-10%] right-[-20%] w-[90vw] lg:w-[50vw] h-[90vw] lg:h-[50vw] rounded-full bg-gradient-to-tl from-[#406093]/20 to-transparent blur-[140px] mix-blend-multiply opacity-80 z-0"></div>
        <div class="w-full max-w-[440px] z-10">
            <div class="text-center mb-10 relative z-10">
                <h1 class="font-h1 text-[36px] text-primary tracking-tight font-bold">Create an Account</h1>
                <p class="font-body-md text-body-lg text-on-surface-variant mt-2 font-medium">Choose the role that best fits your workflow.</p>
            </div>

            @if($errors->any())
            <div class="mb-6 bg-error-container/60 backdrop-blur-sm border border-error/20 rounded-xl px-4 py-3 flex items-start gap-3">
                <span class="material-symbols-outlined text-error text-[20px] mt-0.5">error</span>
                <div>
                    @foreach($errors->all() as $error)
                        <p class="font-label-sm text-[13px] text-on-error-container">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="bg-surface-variant/50 backdrop-blur-md rounded-xl p-1.5 flex mb-8 relative shadow-inner border border-outline-variant/20">
                <button id="reg-farmer-btn" class="flex-1 py-2.5 font-label-sm text-[15px] rounded-lg transition-all z-10 flex items-center justify-center gap-2" type="button" onclick="setRegRole('farmer')">
                    <span class="material-symbols-outlined text-[20px]">agriculture</span>
                    Farmer
                </button>
                <button id="reg-driver-btn" class="flex-1 py-2.5 font-label-sm text-[15px] rounded-lg transition-all z-10 flex items-center justify-center gap-2" type="button" onclick="setRegRole('driver')">
                    <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                    Truck Driver
                </button>
            </div>

            <form class="space-y-6 relative z-10" action="{{ route('register') }}" method="POST">
                @csrf
                <input type="hidden" name="role" id="reg-role" value="{{ old('role', 'driver') }}" />
                <div>
                    <div class="relative bg-surface/50 rounded-t-lg px-4 pt-5 pb-2 border-b-2 border-outline-variant hover:border-outline focus-within:border-driver-state focus-within:bg-surface/80 transition-all">
                        <input class="peer w-full bg-transparent font-body-md text-body-md text-on-surface focus:outline-none placeholder-transparent" id="name" name="name" placeholder="Full Name" required type="text" value="{{ old('name') }}" />
                        <label class="absolute left-4 top-2 font-label-sm text-[12px] text-outline transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-body-md peer-focus:top-2 peer-focus:text-[12px] peer-focus:text-driver-state cursor-text" for="name">Full Name</label>
                    </div>
                    @error('name')<p class="text-error text-[12px] font-label-sm mt-1 ml-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <div class="relative bg-surface/50 rounded-t-lg px-4 pt-5 pb-2 border-b-2 border-outline-variant hover:border-outline focus-within:border-driver-state focus-within:bg-surface/80 transition-all">
                        <input class="peer w-full bg-transparent font-body-md text-body-md text-on-surface focus:outline-none placeholder-transparent" id="email" name="email" placeholder="Email Address" required type="email" value="{{ old('email') }}" />
                        <label class="absolute left-4 top-2 font-label-sm text-[12px] text-outline transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-body-md peer-focus:top-2 peer-focus:text-[12px] peer-focus:text-driver-state cursor-text" for="email">Email Address</label>
                    </div>
                    @error('email')<p class="text-error text-[12px] font-label-sm mt-1 ml-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <div class="relative bg-surface/50 rounded-t-lg px-4 pt-5 pb-2 border-b-2 border-outline-variant hover:border-outline focus-within:border-driver-state focus-within:bg-surface/80 transition-all">
                        <input class="peer w-full bg-transparent font-body-md text-body-md text-on-surface focus:outline-none placeholder-transparent" id="password" name="password" placeholder="Password" required type="password" />
                        <label class="absolute left-4 top-2 font-label-sm text-[12px] text-outline transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-body-md peer-focus:top-2 peer-focus:text-[12px] peer-focus:text-driver-state cursor-text" for="password">Password</label>
                    </div>
                    @error('password')<p class="text-error text-[12px] font-label-sm mt-1 ml-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <div class="relative bg-surface/50 rounded-t-lg px-4 pt-5 pb-2 border-b-2 border-outline-variant hover:border-outline focus-within:border-driver-state focus-within:bg-surface/80 transition-all">
                        <input class="peer w-full bg-transparent font-body-md text-body-md text-on-surface focus:outline-none placeholder-transparent" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required type="password" />
                        <label class="absolute left-4 top-2 font-label-sm text-[12px] text-outline transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-body-md peer-focus:top-2 peer-focus:text-[12px] peer-focus:text-driver-state cursor-text" for="password_confirmation">Confirm Password</label>
                    </div>
                </div>
                <div class="pt-8 space-y-4">
                    <button class="w-full py-3.5 px-4 bg-gradient-to-r from-driver-state to-primary text-on-primary font-label-sm text-body-md font-bold rounded-xl hover:shadow-[0_8px_20px_rgba(76,140,228,0.3)] hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2" id="reg-submit" type="submit">
                        Create Account
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </div>
            </form>
            <div class="mt-10 text-center relative z-10 pt-6 border-t border-outline-variant/30">
                <p class="font-body-md text-body-md text-on-surface-variant">Already have an account?
                    <a class="text-driver-state hover:text-primary hover:underline font-bold ml-1 transition-colors" id="reg-login-link" href="{{ route('login') }}">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</main>

<script>
function setRegRole(role) {
    document.getElementById('reg-role').value = role;
    var fb = document.getElementById('reg-farmer-btn');
    var db = document.getElementById('reg-driver-btn');
    var sub = document.getElementById('reg-submit');
    var loginLink = document.getElementById('reg-login-link');
    var ac = 'bg-surface shadow-[0_2px_8px_rgba(0,0,0,0.08)] font-bold border border-white/60';
    var ic = 'text-on-surface-variant hover:text-on-surface hover:bg-surface/40';
    var base = 'flex-1 py-2.5 font-label-sm text-[15px] rounded-lg transition-all z-10 flex items-center justify-center gap-2 ';
    if (role === 'farmer') {
        fb.className = base + ac + ' text-farmer-state';
        db.className = base + ic;
        sub.className = 'w-full py-3.5 px-4 bg-gradient-to-r from-farmer-state to-tertiary-container text-on-primary font-label-sm text-body-md font-bold rounded-xl hover:shadow-[0_8px_20px_rgba(145,208,108,0.3)] hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2';
        loginLink.className = 'text-farmer-state hover:text-primary hover:underline font-bold ml-1 transition-colors';
    } else {
        db.className = base + ac + ' text-driver-state';
        fb.className = base + ic;
        sub.className = 'w-full py-3.5 px-4 bg-gradient-to-r from-driver-state to-primary text-on-primary font-label-sm text-body-md font-bold rounded-xl hover:shadow-[0_8px_20px_rgba(76,140,228,0.3)] hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2';
        loginLink.className = 'text-driver-state hover:text-primary hover:underline font-bold ml-1 transition-colors';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    setRegRole(document.getElementById('reg-role').value || 'driver');
});
</script>
@endsection
