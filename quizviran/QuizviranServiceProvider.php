<?php

namespace Quizviran;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Quizviran\ComponentControllers\Header;

class QuizviranServiceProvider extends ServiceProvider
{
    private $namespace = 'Quizviran\Http\Controllers';

    public function register()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/resources/views','Quizviran');

    }

    public function boot()
    {
        Blade::component('header',Header::class);
    }
}
