<?php

use Illuminate\Support\Facades\Route;

//quiz
Route::group(['prefix' => 'quizviran'], function () {
    Route::get('/', 'quiz\HomeController@index');
    Route::get('/results/{quiz}', 'quiz\HomeController@result');

    Route::resource('/quiz', 'quiz\QuizController');
    Route::resource('/question', 'quiz\QuestionController');
    Route::resource('/work', 'quiz\WorkController');
    Route::resource('/send', 'quiz\SendController');
    Route::resource('/answer', 'quiz\AnswerController');
    Route::resource('/file', 'quiz\FileController');

    Route::post('/complete', 'QuizController@complete')->middleware('auth');
    //admin
    Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth']], function () {
        Route::get('/', 'quiz\AdminController@index');
        Route::get('add-question', 'quiz\QuizController@addQuestion')->name('question.add');
        Route::post('add-question', 'quiz\QuizController@add')->name('question.add.post');
        Route::get('quiz/detail/{quiz}', 'quiz\QuizController@quizDetail');
    });
});

//admin
Route::get('test', function () {
    $p = Product::first();
    $c = Category::create([
        'name' => 'test',
        'slug' => 'test',
    ]);
    $c = Category::first();
    $p->attachCategory($c);
});

//main
Route::get('/', 'main\HomeController@home');
Route::post('/login', 'RegisterController@login');
Route::get('/logout', 'RegisterController@logout')->middleware('auth');
Route::post('/send-code', 'RegisterController@sendCode')->middleware('throttle:1,3600');
Route::post('/register', 'RegisterController@register')->middleware('throttle:5,3600');
Route::post('/verify', 'RegisterController@verify');
Route::post('/check-auth', 'RegisterController@checkAuth');
Route::get('/{category}/{product:slug}', 'main\HomeController@product');
Route::get('/{category:slug}', 'main\HomeController@category');
