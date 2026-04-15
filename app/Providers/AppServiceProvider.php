<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use App\Models\Booking;
use App\Models\Doctor;
use App\Models\Patient;
use App\Observers\BookingObserver;
use App\Observers\BookingStatusObserverr;
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
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
        Booking::observe(BookingObserver::class);
        Booking::observe(BookingStatusObserverr::class);
        

    }
}
