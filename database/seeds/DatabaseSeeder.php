<?php

use AliBayat\LaravelCategorizable\Category;
use App\Models\HomeBox;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Slide;
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
        HomeBox::truncate();
        User::truncate();
        // factory(Quiz::class,5)->create();
        factory(Category::class, 2)->create();
        factory(Product::class, 50)->create();
        factory(User::class, 5)
            ->create()
            ->each(function ($user) {
                $user->profile()->save(factory(Profile::class, 1)->make()->first());
            });
        factory(Slide::class, 5)->create();
        factory(HomeBox::class, 3)->create();
    }
}
