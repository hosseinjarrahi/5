<?php

namespace Admin;

use Admin\ComponentControllers\Menu;
use Admin\ComponentControllers\TopNavigation;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    private $namespace = 'Admin\Http\Controllers';

    public function register()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/resources/views','Admin');


    }

    public function boot()
    {
        Blade::component('menu', Menu::class);
        Blade::component('top-navigation', TopNavigation::class);
    }
}
