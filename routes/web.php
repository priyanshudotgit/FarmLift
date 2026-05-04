<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\TransporterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

// The Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/success', [AuthController::class, 'success'])->name('success');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Transporter Routes
Route::prefix('transporter')->name('transporter.')->group(function () {
    Route::get('/dashboard', [TransporterController::class, 'index'])->name('dashboard');
    Route::get('/trip/create', [TransporterController::class, 'create'])->name('trip.create');
    Route::post('/trip/store', [TransporterController::class, 'store'])->name('trip.store');
});

// Farmer Routes
Route::prefix('farmer')->name('farmer.')->group(function () {
    Route::get('/dashboard', [FarmerController::class, 'index'])->name('dashboard');
    Route::get('/search', [FarmerController::class, 'search'])->name('search');
});