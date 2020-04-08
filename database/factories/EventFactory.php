<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'body' => '<img class="w-100 h-100" src="/img/event.jpg">',
        'start' => now(),
        'type' => 'top',
        'end' => now()->addYear(1)
    ];
});
