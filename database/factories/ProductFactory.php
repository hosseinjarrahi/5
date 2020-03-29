<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AliBayat\LaravelCategorizable\Category;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
    'title' => $faker->realText(90),
    'desc' => $faker->realText(5000),
    'status' => 'تکمیل',
    'slug' => Str::of($faker->realText(random_int(10,100)))->slug(),
    'percentage' => '90',
    'pic' => '/img/course-test.jpg',
    'course_items' => [
        'demo' => ['free' => true,'title' => 'فصل اول - توابع ریاضی هشتم','time' => '10:50','link'=>'/sds/sd.mp4','embed'=>'<script src="https://fast.wistia.com/embed/medias/ul18wxwckt.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding" style="padding:54.18% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_ul18wxwckt videoFoam=true" style="height:100%;position:relative;width:100%"><div class="wistia_swatch" style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;"><img src="https://fast.wistia.com/embed/medias/ul18wxwckt/swatch" style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" /></div></div></div></div>'],
        ['free' => false,'title' => 'فصل دوم - توابع ریاضی هشتم','time' => '10:50','link'=>'/link/to/file.mp4'],
        ['free' => false,'title' => 'فصل سوم - توابع ریاضی هشتم','time' => '10:50','link'=>'/link/to/file.mp4'],
    ],
    'price' => '100000',
    'offer' => random_int(0,1),
    'user_id' => '1',
    'meta' => ['description' => 'description' , 'title' => 'page title' ,'keywords' => 'keywords'],
    ];
});


$factory->afterCreating(Product::class, function (Product $product,Faker $faker) {
    $product->attachCategory(Category::inRandomOrder()->first());
    $product->attachTag('تگ تستی');
});

