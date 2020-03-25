<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Profile;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'birth' => '2020/2/2 01:01:01',
        'bio' => $faker->realText(300),
    ];
});

$factory->afterCreating(Profile::class, function (Profile $profile,Faker $faker) {
    $profile->user()->associate(factory(User::class,1)->create());
});