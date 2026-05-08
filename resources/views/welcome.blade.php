@extends('layouts.app')

@section('title', 'FarmLift - Share the Space, Cut the Cost')

@section('content')
<!-- Alerts for session messages -->
@if(session('success'))
    <div x-data="{ show: true }" x-show="show" class="w-full">
        <div class="bg-green-50 border-l-4 border-tertiary-fixed p-4 rounded-md shadow-sm flex justify-between max-w-7xl mx-auto">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-tertiary-fixed" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                </div>
                <div class="ml-3"><p class="text-sm text-green-800">{{ session('success') }}</p></div>
            </div>
            <button @click="show = false" class="text-green-800 hover:text-green-900">&times;</button>
        </div>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" x-show="show" class="w-full">
        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md shadow-sm flex justify-between max-w-7xl mx-auto">
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

<!-- Hero Section - Full Width -->
<section class="w-full">
    <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-2 gap-xl items-center relative py-xl">
        <div class="flex flex-col gap-md z-10">
            <h1 class="font-display text-display text-primary-container">Share the Space, Cut the Cost</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg">The smartest way for farmers to book refrigerated transport and for drivers to fill their trucks.</p>
            
            <!-- Floating Search Component -->
            <div class="glass-panel p-md rounded-xl mt-sm flex flex-col gap-sm w-full max-w-md" x-data="locationSearch()">
                <div class="relative">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-outline flex items-center justify-center w-5 h-5">
                            <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.75.75 0 00.723 0l.028-.015.071-.041a22.004 22.004 0 007.289-5.11.75.75 0 00.929-.93 23.456 23.456 0 00-7.z0006.5-5.006M12 21a9 9 0 100-18 9 9 0 000 18zm3.75-9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"/>
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.75.75 0 00.723 0l.028-.015.071-.041a22.004 22.004 0 007.289-5.11.75.75 0 00.929-.93 23.456 23.456 0 00-7.z0006.5-5.006M12 21a9 9 0 100-18 9 9 0 000 18zm3.75-9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"/>
                        </svg> -->
                    </div>
                    <input class="w-full pl-10 pr-4 py-3 rounded-lg border border-surface-dim bg-white/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md" 
                           placeholder="Pickup Location" 
                           type="text"
                           @input="handlePickupInput($event)"
                           x-model="pickupLocation"
                           @keydown.arrow-down="selectSuggestion($event)"
                           @keydown.arrow-up="selectSuggestion($event)"
                           @keydown.enter="selectSuggestion($event)"/>
                    <div x-show="showPickupSuggestions && pickupSuggestions.length" 
                         class="absolute top-full left-0 right-0 mt-1 bg-white border border-surface-dim rounded-lg shadow-lg z-10">
                        <template x-for="(suggestion, index) in pickupSuggestions" :key="index">
                            <div class="px-4 py-2 hover:bg-surface-container-low cursor-pointer text-on-surface text-sm"
                                 @click="selectPickup(suggestion)">
                                <span x-text="suggestion"></span>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-outline flex items-center justify-center w-5 h-5">
                        <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.75.75 0 00.723 0l.028-.015.071-.041a22.004 22.004 0 007.289-5.11.75.75 0 00.929-.93 23.456 23.456 0 00-7.006-5.006M12 21a9 9 0 100-18 9 9 0 000 18zm3.75-9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"/>
                    </div>
                    <input class="w-full pl-10 pr-4 py-3 rounded-lg border border-surface-dim bg-white/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md" 
                           placeholder="Destination" 
                           type="text"
                           @input="handleDestinationInput($event)"
                           x-model="destinationLocation"
                           @keydown.arrow-down="selectSuggestion($event)"
                           @keydown.arrow-up="selectSuggestion($event)"
                           @keydown.enter="selectSuggestion($event)"/>
                    <div x-show="showDestinationSuggestions && destinationSuggestions.length" 
                         class="absolute top-full left-0 right-0 mt-1 bg-white border border-surface-dim rounded-lg shadow-lg z-10">
                        <template x-for="(suggestion, index) in destinationSuggestions" :key="index">
                            <div class="px-4 py-2 hover:bg-surface-container-low cursor-pointer text-on-surface text-sm"
                                 @click="selectDestination(suggestion)">
                                <span x-text="suggestion"></span>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-outline flex items-center justify-center w-5 h-5">
                        <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM15.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM16.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM9 6.75h6V3H9v3.75zm11.25 11.25H3.75V9h16.5v9z"/>
                    </div>
                    <input class="w-full pl-10 pr-4 py-3 rounded-lg border border-surface-dim bg-white/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md text-on-surface-variant" 
                           type="date"
                           x-model="date"/>
                </div>
                <button class="bg-primary-container text-on-primary px-6 py-3 rounded-lg font-label-sm text-label-sm w-full hover:bg-primary transition-colors mt-2"
                        @click="handleSearch()">Search Trucks</button>
            </div>
        </div>
        
        <!-- 3D Dashboard Snippet (Abstract) -->
        <div class="relative h-[500px] w-full flex justify-center items-center">
            <!-- Abstract Decorative Elements -->
            <div class="absolute inset-0 bg-gradient-to-tr from-surface-container to-surface-bright rounded-3xl -z-10 ">
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
    </div>
</section>

<!-- Feature Bento Grid - Full Width -->
<section class="w-full bg-surface-container-low py-xl">
    <div class="max-w-7xl mx-auto px-8">
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
    </div>
</section>

<!-- Contact Section - Full Width -->
<section class="w-full py-xl">
    <div class="max-w-7xl mx-auto px-8 bg-[#FFF799] rounded-3xl p-xl flex flex-col md:flex-row gap-lg items-center bento-shadow">
        <div class="flex-1 flex flex-col gap-md">
            <h2 class="font-h1 text-h1 text-on-surface">Get in Touch</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant">Need assistance or have questions about logistics? Our team is ready to help you optimize your agricultural transport.</p>
            <a class="font-label-sm text-label-sm text-primary underline mt-2" href="#">Visit Help Center</a>
        </div>
        <div class="flex-1 w-full bg-white/60 backdrop-blur-md rounded-xl p-md border border-white/40">
            <form class="flex flex-col gap-sm" action="#" method="post">
                <input class="w-full px-4 py-3 rounded-lg border border-surface-dim bg-white/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md" placeholder="Name" type="text"/>
                <input class="w-full px-4 py-3 rounded-lg border border-surface-dim bg-white/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md" placeholder="Email" type="email"/>
                <textarea class="w-full px-4 py-3 rounded-lg border border-surface-dim bg-white/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md resize-none" placeholder="Message" rows="4"></textarea>
                <button class="bg-primary text-on-primary px-6 py-3 rounded-lg font-label-sm text-label-sm hover:opacity-90 transition-opacity mt-2 self-end" type="button">Send Message</button>
            </form>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    function locationSearch() {
        return {
            pickupLocation: '',
            destinationLocation: '',
            date: '',
            pickupSuggestions: [],
            destinationSuggestions: [],
            showPickupSuggestions: false,
            showDestinationSuggestions: false,
            selectedSuggestionIndex: -1,
            currentField: null,
            
            // Sample locations data
            locations: [
                'New Delhi', 'Mumbai', 'Bangalore', 'Chennai', 'Kolkata',
                'Hyderabad', 'Pune', 'Ahmedabad', 'Jaipur', 'Lucknow',
                'Chandigarh', 'Indore', 'Nagpur', 'Bhopal', 'Visakhapatnam',
                'Kochi', 'Vadodara', 'Ghaziabad', 'Ludhiana', 'Agra'
            ],
            
            handlePickupInput(event) {
                const value = event.target.value.toLowerCase();
                this.currentField = 'pickup';
                this.selectedSuggestionIndex = -1;
                
                if (value.length > 0) {
                    this.pickupSuggestions = this.locations.filter(loc => 
                        loc.toLowerCase().includes(value)
                    );
                    this.showPickupSuggestions = true;
                } else {
                    this.showPickupSuggestions = false;
                }
            },
            
            handleDestinationInput(event) {
                const value = event.target.value.toLowerCase();
                this.currentField = 'destination';
                this.selectedSuggestionIndex = -1;
                
                if (value.length > 0) {
                    this.destinationSuggestions = this.locations.filter(loc => 
                        loc.toLowerCase().includes(value)
                    );
                    this.showDestinationSuggestions = true;
                } else {
                    this.showDestinationSuggestions = false;
                }
            },
            
            selectPickup(location) {
                this.pickupLocation = location;
                this.showPickupSuggestions = false;
            },
            
            selectDestination(location) {
                this.destinationLocation = location;
                this.showDestinationSuggestions = false;
            },
            
            selectSuggestion(event) {
                if (this.currentField === 'pickup' && this.pickupSuggestions.length > 0) {
                    if (event.key === 'ArrowDown') {
                        event.preventDefault();
                        this.selectedSuggestionIndex = Math.min(
                            this.selectedSuggestionIndex + 1,
                            this.pickupSuggestions.length - 1
                        );
                    } else if (event.key === 'ArrowUp') {
                        event.preventDefault();
                        this.selectedSuggestionIndex = Math.max(this.selectedSuggestionIndex - 1, 0);
                    } else if (event.key === 'Enter' && this.selectedSuggestionIndex >= 0) {
                        event.preventDefault();
                        this.selectPickup(this.pickupSuggestions[this.selectedSuggestionIndex]);
                    }
                } else if (this.currentField === 'destination' && this.destinationSuggestions.length > 0) {
                    if (event.key === 'ArrowDown') {
                        event.preventDefault();
                        this.selectedSuggestionIndex = Math.min(
                            this.selectedSuggestionIndex + 1,
                            this.destinationSuggestions.length - 1
                        );
                    } else if (event.key === 'ArrowUp') {
                        event.preventDefault();
                        this.selectedSuggestionIndex = Math.max(this.selectedSuggestionIndex - 1, 0);
                    } else if (event.key === 'Enter' && this.selectedSuggestionIndex >= 0) {
                        event.preventDefault();
                        this.selectDestination(this.destinationSuggestions[this.selectedSuggestionIndex]);
                    }
                }
            },
            
            handleSearch() {
                // Redirect to login/signup page
                if (this.pickupLocation && this.destinationLocation && this.date) {
                    // Store the search parameters in session storage for later use
                    sessionStorage.setItem('searchParams', JSON.stringify({
                        pickup: this.pickupLocation,
                        destination: this.destinationLocation,
                        date: this.date
                    }));
                    window.location.href = '{{ route("login") }}';
                } else {
                    alert('Please fill in all fields');
                }
            }
        }
    }
</script>
@endsection


