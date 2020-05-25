<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Facades\Payment\Idpay;
use App\Facades\Payment\PayFacade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        PayFacade::choose(Invoice::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength('190');
        Carbon::setLocale('fa');
        PayFacade::choose(Idpay::class);
    }
}
