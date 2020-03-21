<?php

namespace App\Providers;

use App\Models\Quiz\Quiz;
use App\Models\Main\News;
use App\Models\Quiz\Homework;
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
        Relation::morphMap([
            Quiz::class => 'quiz',
            Homework::class => 'homework',
            News::class => 'news',
        ]);
    }
}
