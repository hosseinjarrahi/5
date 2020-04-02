<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            if (Cache::has('notification-count')) {
                $count = Cache::get('notification-count');
            }else{
                $count = (auth()->user() ? auth()->user()->notifications()->count() : 0);
                Cache::add('notification-count', $count, 60);
            }

            $view->with('notifications', Cache::get('notification-count'));
        });
    }
}
