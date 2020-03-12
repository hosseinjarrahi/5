<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'type' => 'test',
        'A' => 'گزینه اول',
        'B' => 'گزینه دوم',
        'C' => 'گزینه سوم',
        'D' => 'گزینه چهارم',
        'answer' => 'A',
        'desc' => 'زاویه مشخص شده در تصویر را پیدا کنی د آن را در باقی مانده ضرب آنها بگشایید تا شاید رستگار شوید',
    ];
});
