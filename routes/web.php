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
Route::get('/results/{quiz}','HomeController@result');

Route::resource('/quiz','QuizController');
Route::resource('/question','QuestionController');
Route::resource('/work','WorkController');
Route::resource('/send','SendController');
Route::resource('/answer','AnswerController');

Route::post('/complete','QuizController@complete');
Route::post('/message/{message}','HomeController@showMessage')->name('message');
Route::post('/login','RegisterController@login');
Route::get('/logout','RegisterController@logout');
Route::post('/send-code','RegisterController@sendCode');
Route::post('/register','RegisterController@register');
Route::post('/verify','RegisterController@verify');
Route::post('/check-auth','RegisterController@checkAuth');

