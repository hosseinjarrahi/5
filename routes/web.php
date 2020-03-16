<?php

use Illuminate\Support\Facades\Route;

Route::get('/','HomeController@index');
Route::get('/results/{quiz}','HomeController@result');

Route::resource('/quiz','QuizController');
Route::resource('/question','QuestionController');
Route::resource('/work','WorkController');
Route::resource('/send','SendController');
Route::resource('/answer','AnswerController');

Route::post('/complete','QuizController@complete');
Route::post('/message/{message}','HomeController@showMessage')->name('message');
// auth
Route::post('/login','RegisterController@login');
Route::get('/logout','RegisterController@logout');
Route::post('/send-code','RegisterController@sendCode');
Route::post('/register','RegisterController@register');
Route::post('/verify','RegisterController@verify');
Route::post('/check-auth','RegisterController@checkAuth');
//admin
Route::group(['prefix' => 'admin'],function(){
    Route::get('/','AdminController@index');
    Route::get('add-question','QuizController@addQuestion')->name('question.add');
    Route::post('add-question','QuizController@add')->name('question.add.post');
    Route::get('quiz/detail/{quiz}','QuizController@quizDetail');
});
