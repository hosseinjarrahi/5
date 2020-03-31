<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'comment' => $faker->realText(200),
        'user_id' => 1,
        'commentable_id' => random_int(1,100),
        'commentable_type' => Product::class,
        'show' => true,
    ];
});
