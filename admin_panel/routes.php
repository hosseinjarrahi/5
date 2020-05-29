
<?php

Route::group(['prefix' => 'manager','as'=>'admin.','middleware' => ['auth','admin']], function () {
    Route::get('/','HomeController@dashboard')->name('home');

    Route::resource('/product', 'ProductController');
    Route::resource('/category', 'CategoryController');
    Route::resource('/slide', 'SlideController');
    Route::resource('/event', 'EventController');
    Route::resource('/comment', 'CommentController');
    Route::resource('/user', 'UserController');
    Route::resource('/setting', 'SlideController');

    Route::post('/products', 'ProductController@give');
    Route::post('/product/upload', 'ProductController@upload');
});
