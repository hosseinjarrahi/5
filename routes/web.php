<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

////quiz
//Route::group(['prefix' => 'quizviran'], function () {
//    Route::get('/', 'quiz\HomeController@index');
//    Route::get('/results/{quiz}', 'quiz\HomeController@result');
//
//    Route::resource('/quiz', 'quiz\QuizController');
//    Route::resource('/question', 'quiz\QuestionController');
//    Route::resource('/work', 'quiz\WorkController');
//    Route::resource('/send', 'quiz\SendController');
//    Route::resource('/answer', 'quiz\AnswerController');
//    Route::resource('/file', 'quiz\FileController');
//
//    Route::post('/complete', 'QuizController@complete')->middleware('auth');
//    //admin
//    Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth']], function () {
//        Route::get('/', 'quiz\AdminController@index');
//        Route::get('add-question', 'quiz\QuizController@addQuestion')->name('question.add');
//        Route::post('add-question', 'quiz\QuizController@add')->name('question.add.post');
//        Route::get('quiz/detail/{quiz}', 'quiz\QuizController@quizDetail');
//    });
//});

//admin
Route::get('/test', function(){
    $user = auth()->user();
    $user->notify(new \App\Notifications\TestNotification());
});

//main
Route::get('/', 'main\HomeController@home');

Route::post('/login', 'RegisterController@login');
Route::get('/logout', 'RegisterController@logout')->middleware('auth');
Route::post('/reset-password', 'RegisterController@resetPassword')/*->middleware('throttle:1,3600')*/;
Route::post('/register', 'RegisterController@register')/*->middleware('throttle:5,3600')*/;
Route::post('/verify', 'RegisterController@verify');
Route::post('/check-auth', 'RegisterController@checkAuth');

Route::get('/search', 'main\HomeController@search');
Route::get('/tag/{tag}', 'main\HomeController@tag');
Route::post('/check-coupon', 'main\HomeController@checkCoupon');
Route::get('/notifications', 'main\HomeController@notifications');

Route::resource('/comment', 'main\CommentController');
Route::get('/{category:slug}/{product:slug}', 'main\HomeController@product');
Route::get('/{category:slug}', 'main\HomeController@category');
