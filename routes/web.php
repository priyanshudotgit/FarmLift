<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\TransporterController;
use App\Http\Controllers\HomeController;

// The Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Transporter Routes
Route::prefix('transporter')->name('transporter.')->group(function () {
    Route::get('/dashboard', [TransporterController::class, 'index'])->name('dashboard');
    Route::get('/trip/create', [TransporterController::class, 'create'])->name('trip.create');
});

// Farmer Routes
Route::prefix('farmer')->name('farmer.')->group(function () {
    Route::get('/dashboard', [FarmerController::class, 'index'])->name('dashboard');
    Route::get('/search', [FarmerController::class, 'search'])->name('search');
});