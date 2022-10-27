<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\PaymentObserver;
use App\Models\Payment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Payment::observe(PaymentObserver::class);
    }
}
