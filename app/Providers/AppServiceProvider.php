<?php

namespace App\Providers;

use App\Models\OrderSource;
use App\Observers\OrderSourceObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);

        // Register the observer
        OrderSource::observe(OrderSourceObserver::class);
    }
}
