<?php

namespace App\Providers;

use App\Models\Event;
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
        $topEvent = Event::where('type','top')->first() ?? new Event();
        $topEvent->show = false;
        if($topEvent)
        {
            if(now()->greaterThan($topEvent->start) && now()->lessThan($topEvent->end))
                $topEvent->show = true;
        }

        view()->composer('*', function ($view) use ($topEvent) {
            if (Cache::has('notification-count')) {
                $count = Cache::get('notification-count');
            }else{
                $count = (auth()->user() ? auth()->user()->unReadNotifications()->count() : 0);
                Cache::add('notification-count', $count, 30);
            }

            $view->with('notifications', Cache::get('notification-count'));
            $view->with('topEvent', $topEvent);
        });
    }
}
