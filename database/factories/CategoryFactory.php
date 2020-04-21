<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$categories = [
    ['name' => 'جزوات و نمونه سوال','slug'=>'جزوات','pic' => '/img/jozavat.png'],
];

$factory->define(Category::class, function (Faker $faker) use ($categories) {
    return $categories[0];
});
