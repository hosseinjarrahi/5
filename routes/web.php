<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeController@index');

Route::resource('/quiz','QuizController');
Route::resource('/question','QuestionController');
Route::resource('/work','WorkController');
Route::resource('/send','SendController');
Route::resource('/answer','AnswerController');

Route::post('/complete','QuizController@complete');
Route::post('/message/{message}','HomeController@showMessage')->name('message');

