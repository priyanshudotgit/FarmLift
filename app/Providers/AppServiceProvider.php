<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\BookingRequested;
use App\Events\BookingStatusUpdated;
use App\Listeners\NotifyDriverOnBooking;
use App\Listeners\NotifyFarmerOnStatusChange;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            BookingRequested::class,
            NotifyDriverOnBooking::class,
        );

        Event::listen(
            BookingStatusUpdated::class,
            NotifyFarmerOnStatusChange::class,
        );
    }
}
