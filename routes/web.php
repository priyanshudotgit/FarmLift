<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->isFarmer() 
            ? redirect()->route('farmer.dashboard') 
            : redirect()->route('driver.dashboard');
    }
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Farmer Routes
    Route::middleware([\App\Http\Middleware\IsFarmer::class])->prefix('farmer')->name('farmer.')->group(function () {
        Route::get('/dashboard', [FarmerController::class, 'dashboard'])->name('dashboard');
        Route::get('/search', [FarmerController::class, 'search'])->name('search');
        Route::post('/book', [BookingController::class, 'store'])->name('book');
        Route::get('/bookings', [FarmerController::class, 'bookings'])->name('bookings');
        Route::get('/profile', [FarmerController::class, 'profile'])->name('profile');
        Route::put('/profile', [FarmerController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/farm', [FarmerController::class, 'updateFarm'])->name('profile.farm');
        Route::put('/profile/password', [FarmerController::class, 'updatePassword'])->name('profile.password');
    });

    // Driver Routes
    Route::middleware([\App\Http\Middleware\IsDriver::class])->prefix('driver')->name('driver.')->group(function () {
        Route::get('/dashboard', [DriverController::class, 'dashboard'])->name('dashboard');
        Route::get('/loadboard', [DriverController::class, 'loadboard'])->name('loadboard');
        Route::get('/earnings', [DriverController::class, 'earnings'])->name('earnings');
        Route::get('/profile', [DriverController::class, 'profile'])->name('profile');
        Route::put('/profile', [DriverController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/vehicle', [DriverController::class, 'updateVehicle'])->name('profile.vehicle');
        Route::put('/profile/password', [DriverController::class, 'updatePassword'])->name('profile.password');
        Route::get('/trip/create', [DriverController::class, 'createTrip'])->name('trip.create');
        Route::post('/trip', [DriverController::class, 'storeTrip'])->name('trip.store');
        Route::post('/booking/{booking}/status', [BookingController::class, 'updateStatus'])->name('booking.status');
    });
});















