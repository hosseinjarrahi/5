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

    }

    public function boot()
    {

    }
}