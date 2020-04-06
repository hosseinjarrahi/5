<?php

namespace Admin;

use Illuminate\Support\Facades\Route;
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

    }
}