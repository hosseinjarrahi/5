<?php

use AliBayat\LaravelCategorizable\Category;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Slide;
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
        Product::truncate();
        Category::truncate();
        Profile::truncate();
        User::truncate();
        // factory(Quiz::class,5)->create();
        factory(Profile::class,2)->create();
        factory(Category::class,2)->create();
        factory(Product::class,50)->create();
        factory(Slide::class,5)->create();
    }
}
