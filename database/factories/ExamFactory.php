<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use Faker\Generator as Faker;
use Quizviran\Models\Exam;

$factory->define(Exam::class, function (Faker $faker) {
    return [
        'name' => ' آزمون شماره '.random_int(1,100).'ریاضی',
        'start' => Carbon::now(),
        'duration' => 60,
        'desc' => 'آزمون جدید ریاضی شامل 80 سوال و برنده 500 هزار تومن میبره چون که زیرا وگرنه نه خیر اصلا هم نمیشه.',
        'show' => 1,
        'type' => 'private',
        'user_id' => '1',
    ];
});
