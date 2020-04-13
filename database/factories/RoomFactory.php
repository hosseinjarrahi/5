<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Quizviran\Models\Room;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'name' => 'کلاس ریاضی',
        'link' => '@x'.random_int(1,500),
        'code' => random_int(100000,99999999),
        'user_id' => 1
    ];
});
