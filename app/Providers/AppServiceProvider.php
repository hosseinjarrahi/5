<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Facades\Payment\Idpay;
use App\Facades\Payment\PayFacade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        Schema::defaultStringLength('190');
        Carbon::setLocale('fa');
        PayFacade::choose(Idpay::class);
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        view()->composer('*', function ($view) {
            $view->with('user', auth()->user());
        });
    }
}
