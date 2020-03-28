<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\HomeBox;
use Faker\Generator as Faker;

$factory->define(HomeBox::class, function (Faker $faker) {
    return [
        'pic' => '/img/courses.png',
        'category_id' => random_int(1,2),
        'more_text' => 'مشاهده تمامی'
    ];
});
