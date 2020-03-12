<?php

use App\Question;
use App\Quiz;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Quiz::truncate();
        Question::truncate();
        factory(Quiz::class,5)->create();
    }
}
