@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div x-data="{ role: 'farmer' }" class="min-h-[calc(100vh-4rem)] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-10 rounded-3xl shadow-sm border border-gray-100">
        <div>
            <h2 class="mt-2 text-center text-3xl font-extrabold text-gray-900">Create Account</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Join the logistics network</p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            
            <!-- Role Toggle -->
            <div class="flex p-1 bg-gray-100 rounded-xl mb-6">
                <button type="button" 
                        @click="role = 'farmer'"
                        :class="role === 'farmer' ? 'bg-white shadow text-[#406093] font-semibold' : 'text-gray-500 hover:text-gray-700'"
                        class="flex-1 py-2 text-sm rounded-lg transition-all">
                    I am a Farmer
                </button>
                <button type="button" 
                        @click="role = 'driver'"
                        :class="role === 'driver' ? 'bg-[#406093] shadow text-white font-semibold' : 'text-gray-500 hover:text-gray-700'"
                        class="flex-1 py-2 text-sm rounded-lg transition-all">
                    I am a Driver
                </button>
            </div>
            
            <input type="hidden" name="role" x-model="role">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input name="name" type="text" required class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm mt-1" value="{{ old('name') }}">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input name="phone" type="text" required class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm mt-1" value="{{ old('phone') }}">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input name="email" type="email" required class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm mt-1" value="{{ old('email') }}">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input name="password" type="password" required class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm mt-1">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input name="password_confirmation" type="password" required class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm mt-1">
                </div>
            </div>

            <div>
                <button type="submit" 
                        :class="role === 'driver' ? 'bg-gradient-to-r from-[#406093] to-[#4C8CE4]' : 'bg-[#91D06C] hover:bg-[#80bc5e]'"
                        class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md transition-all">
                    Register Now
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
