<?php

use App\Models\Event;
use App\Models\Comment;
use App\Models\HomeBox;
use App\Models\Product;
use App\Models\Profile;
use App\Models\User;
use App\Models\Slide;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Quizviran\Models\Question;
use Quizviran\Models\Exam;
use Quizviran\Models\Room;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Exam::truncate();
        Question::truncate();
        Room::truncate();
        Product::truncate();
        Category::truncate();
        Profile::truncate();
        HomeBox::truncate();
        User::truncate();
        Comment::truncate();
        Slide::truncate();
        Event::truncate();
        // factory(Exam::class,5)->create();
        factory(Category::class, 1)->create();
        factory(Product::class, 50)->create();
        factory(User::class, 5)
            ->create()
            ->each(function ($user) {
                $user->profile()->save(factory(Profile::class, 1)->make()->first());
            });
        factory(User::class, 1)
            ->create()
            ->each(function ($user) {
                $user->profile()->save(factory(Profile::class, 1)->make()->first());
                $user->email = 'hj021hj@gmail.com';
                $user->phone = '09023144565';
                $user->save();
            });
        factory(Slide::class, 5)->create();
        factory(HomeBox::class, 1)->create();
        factory(Comment::class, 100)->create();
        factory(Event::class, 1)->create();
//        factory(Question::class,10)->create();
//
//        factory(Exam::class, 10)
//        ->create()
//        ->each(function ($quiz) {
//            $quiz->questions()->save(Question::first());
//        });

        Event::create([
            'body' => '/img/event.png',
            'start' => now(),
            'type' => 'main',
            'end' => now()
        ]);

//        factory(Room::class,1)->create()
//        ->create()
//        ->each(function ($room) {
//            $room->exams()->save(Exam::first());
//        });

    }
}
