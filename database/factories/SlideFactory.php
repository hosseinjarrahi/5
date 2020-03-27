<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Slide;
use Faker\Generator as Faker;

$factory->define(Slide::class, function (Faker $faker) {
    return [
        'link' => url(''),
        'pic' => '/img/slide'.random_int(0,1).'.jpg',
    ];
});
