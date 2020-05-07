<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
    'title' => $faker->realText(90),
    'desc' => $faker->realText(5000),
    'status' => 'تکمیل',
    'slug' => Str::of($faker->realText(random_int(10,100)))->slug(),
    'percentage' => '90',
    'pic' => '/img/course-test.jpg',
    'video' => '/img/course-test.jpg',
    'course_items' => [
        ['free' => false,'title' => 'فصل دوم - توابع ریاضی هشتم','time' => '10:50','hash'=>'/link/to/file.mp4'],
        ['free' => false,'title' => 'فصل سوم - توابع ریاضی هشتم','time' => '10:50','hash'=>'/link/to/file.mp4'],
    ],
    'price' => '100000',
    'offer' => random_int(0,1),
    'user_id' => '1',
    'meta' => ['description' => 'description' , 'title' => 'page title' ,'keywords' => 'keywords'],
    ];
});


$factory->afterCreating(Product::class, function (Product $product,Faker $faker) {
    $product->categories()->attach(Category::inRandomOrder()->first());
    $product->tag(['تگ تستی',$faker->realText('10')]);
});

