<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@home')->name('home');

Route::get('/complete', 'PaymentController@complete');
Route::post('/complete/reply', 'PaymentController@reply');

Route::post('/login', 'RegisterController@login');
Route::get('/logout', 'RegisterController@logout')->name('logout')->middleware('auth');
Route::post('/reset-password', 'RegisterController@resetPassword')->middleware('throttle:5,1440');
Route::post('/register', 'RegisterController@register')->middleware('throttle:10,1440');
Route::post('/verify', 'RegisterController@verify');
Route::post('/check-auth', 'RegisterController@checkAuth');
Route::get('/profile', 'RegisterController@profile');
Route::post('/upload-avatar', 'RegisterController@uploadAvatar');
Route::post('/profile-change', 'RegisterController@changeProfile');

Route::get('/search', 'HomeController@search');
Route::get('/tag/{tag}', 'HomeController@tag');
Route::post('/check-coupon', 'HomeController@checkCoupon');
Route::get('/notifications', 'HomeController@notifications');

Route::resource('/comment', 'CommentController');
Route::resource('/file', 'FileController');
Route::get('/{category:slug}/{product:slug}', 'HomeController@product');
Route::get('/{category:slug}', 'HomeController@category');
