<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AliBayat\LaravelCategorizable\Category;
use Faker\Generator as Faker;

$categories = [
    ['name' => 'فروشگاه','slug'=>'فروشگاه','pic' => 'img/course.png'],
    ['name' => 'جزوات و نمونه سوال','slug'=>'فروشگاه','pic' => 'img/jozavat.png'],
];

$factory->define(Category::class, function (Faker $faker) use ($categories) {
    return $categories[random_int(0,1)];
});
