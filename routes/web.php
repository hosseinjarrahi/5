<?php

use Illuminate\Support\Facades\Route;
//main
Route::get('/','main\HomeController@home');
Route::get('/category/{category?}','main\HomeController@category');
Route::get('/product/{product?}','main\HomeController@product');

//quiz
Route::group(['prefix'=>'quiz'],function(){
    Route::get('/','quiz\HomeController@index');
    Route::get('/results/{quiz}','quiz\HomeController@result');

    Route::resource('/quiz','quiz\QuizController');
    Route::resource('/question','quiz\QuestionController');
    Route::resource('/work','quiz\WorkController');
    Route::resource('/send','quiz\SendController');
    Route::resource('/answer','quiz\AnswerController');
    Route::resource('/file','quiz\FileController');

    Route::post('/complete','QuizController@complete')->middleware('auth');
// auth
    Route::post('/login','quiz\RegisterController@login');
    Route::get('/logout','quiz\RegisterController@logout')->middleware('auth');
    Route::post('/send-code','quiz\RegisterController@sendCode')->middleware('throttle:1,3600');
    Route::post('/register','quiz\RegisterController@register')->middleware('throttle:5,3600');
    Route::post('/verify','quiz\RegisterController@verify');
    Route::post('/check-auth','quiz\RegisterController@checkAuth');
//admin
    Route::group(['prefix' => 'admin','middleware' => ['admin','auth']],function(){
        Route::get('/','quiz\AdminController@index');
        Route::get('add-question','quiz\QuizController@addQuestion')->name('question.add');
        Route::post('add-question','quiz\QuizController@add')->name('question.add.post');
        Route::get('quiz/detail/{quiz}','quiz\QuizController@quizDetail');
    });

});

//admin