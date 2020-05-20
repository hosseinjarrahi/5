<?php

Route::group(['prefix' => 'manager','middleware' => ['auth','admin']], function () {
    Route::get('/','HomeController@dashboard');

    Route::resource('/product', 'ProductController');
    Route::resource('/category', 'CategoryController');
    Route::resource('/slide', 'SlideController');
    Route::resource('/event', 'EventController');
    Route::resource('/comment', 'CommentController',['as' => 'admin']);
    Route::resource('/user', 'UserController');
    Route::resource('/setting', 'SlideController');

    Route::post('/products', 'ProductController@give');
    Route::post('/product/upload', 'ProductController@upload');
});

Route::get('/assets/{path}', 'HomeController@asset')->where('path','.*');
