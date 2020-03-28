<?php

namespace App\Providers;

use App\Models\Quiz;
use App\Models\News;
use App\Models\Homework;
use App\Models\Product;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class DbServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        // Relation::morphMap([
        //     Quiz::class => 'quiz',
        //     Homework::class => 'homework',
        //     News::class => 'news',
        //     Product::class => 'product',
        // ]);
    }
}
