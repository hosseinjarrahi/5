<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Question;
use Faker\Generator as Faker;

$factory->define(Quiz::class, function (Faker $faker) {
    return [
        'name' => ' آزمون شماره '.random_int(1,100).'ریاضی',
        'start' => Carbon::now(),
        'duration' => 60,
        'desc' => 'آزمون جدید ریاضی شامل 80 سوال و برنده 500 هزار تومن میبره چون که زیرا وگرنه نه خیر اصلا هم نمیشه.',
        'show' => 1,
        'type' => 'public',
        'user_id' => '1',
    ];
});

$factory->afterCreating(Quiz::class, function ($quiz, $faker) {
    $quiz->questions()->saveMany(factory(Question::class,5)->create());
});