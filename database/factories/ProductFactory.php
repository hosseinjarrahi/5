<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AliBayat\LaravelCategorizable\Category;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
    'title' => $faker->realText(10),
    'desc' => $faker->realText(5000),
    'status' => 'تکمیل',
    'slug' => \Str::of($faker->realText(100))->slug(),
    'percentage' => '90',
    'pic' => '/img/course-test.jpg',
    'course_items' => [
        ['title' => 'فصل اول - توابع ریاضی هشتم','time' => '10:50','link'=>'/link/to/file.mp4'],
        ['title' => 'فصل دوم - توابع ریاضی هشتم','time' => '10:50','link'=>'/link/to/file.mp4'],
        ['title' => 'فصل سوم - توابع ریاضی هشتم','time' => '10:50','link'=>'/link/to/file.mp4'],
    ],
    'price' => random_int(0,100),
    'offer' => random_int(0,100),
    'user_id' => '1',
    'meta' => ['description' => 'description' , 'title' => 'page title' ,'keywords' => 'keywords'],
    ];
});


$factory->afterCreating(Product::class, function (Product $product,Faker $faker) {
    $product->attachCategory(Category::inRandomOrder()->first());
});

