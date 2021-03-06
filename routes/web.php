<?php
use Illuminate\Support\Facades\Route;

//Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['admin','web', 'auth']], function () {
//    \UniSharp\LaravelFilemanager\Lfm::routes();
//});

Route::get('/', 'HomeController@home')->name('home');

Route::view('/donate', 'donate')->name('donate');

Route::get('/complete', 'PaymentController@complete')->name('payment.pay');
Route::post('/complete/reply', 'PaymentController@reply')->name('payment.reply');

Route::post('/login', 'RegisterController@login')->middleware(['guest']);
Route::get('/logout', 'RegisterController@logout')->name('logout')->middleware('auth');
Route::post('/reset-password', 'RegisterController@resetPassword')->middleware(['throttle:500,1440','guest']);
Route::post('/register', 'RegisterController@register')->middleware(['throttle:1000,1440','guest']);
Route::post('/verify', 'RegisterController@verify')->middleware(['guest']);
Route::post('/check-auth', 'RegisterController@checkAuth');
Route::get('/profile', 'RegisterController@profile')->middleware(['auth']);
Route::post('/upload-avatar', 'RegisterController@uploadAvatar')->middleware(['auth']);
Route::post('/profile-change', 'RegisterController@changeProfile')->middleware(['auth']);

Route::get('/search', 'HomeController@search');
Route::get('/tag/{tag}', 'HomeController@tag');
Route::post('/check-coupon', 'HomeController@checkCoupon');
Route::get('/notifications', 'HomeController@notifications')->middleware(['auth']);

Route::resource('/comment', 'CommentController');
Route::resource('/file', 'FileController');
Route::get('/{category:slug}/{product:slug}', 'HomeController@product');
Route::get('/{category:slug}', 'HomeController@category');
