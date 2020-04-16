<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'main\HomeController@home')->name('login');

Route::post('/login', 'RegisterController@login');
Route::get('/logout', 'RegisterController@logout')->name('logout')->middleware('auth');
Route::post('/reset-password', 'RegisterController@resetPassword')/*->middleware('throttle:1,3600')*/;
Route::post('/register', 'RegisterController@register')/*->middleware('throttle:5,3600')*/;
Route::post('/verify', 'RegisterController@verify');
Route::post('/check-auth', 'RegisterController@checkAuth');
Route::get('/profile', 'RegisterController@profile');
Route::post('/upload-avatar', 'RegisterController@uploadAvatar');
Route::post('/profile-change', 'RegisterController@changeProfile');

Route::get('/search', 'main\HomeController@search');
Route::get('/tag/{tag}', 'main\HomeController@tag');
Route::post('/check-coupon', 'main\HomeController@checkCoupon');
Route::get('/notifications', 'main\HomeController@notifications');

Route::resource('/comment', 'main\CommentController');
Route::resource('/file', 'FileController');
Route::get('/{category:slug}/{product:slug}', 'main\HomeController@product');
Route::get('/{category:slug}', 'main\HomeController@category');
