<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Quizviran\Models\Question;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'type' => 'test',
        'pic' => '/img/slide0.jpg',
        'A' => 'گزینه اول',
        'B' => 'گزینه دوم',
        'C' => 'گزینه سوم',
        'D' => 'گزینه چهارم',
        'answer' => 'A',
        'desc' => 'زاویه مشخص شده در تصویر را پیدا کنی د آن را در باقی مانده ضرب آنها بگشایید تا شاید رستگار شوید',
        'user_id' => '1',
    ];
});
