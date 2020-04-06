<?php

Route::group(['prefix' => 'manager'], function () {
    Route::get('/','HomeController@dashboard');

    Route::resource('/product', 'ProductController');
    Route::post('/products', 'ProductController@give');
    Route::post('/product/upload', 'ProductController@upload');
});























Route::get('/assets/{folder}/{file}', [ function ( $folder, $file) {

  $path = app_path("../admin_panel/public/$folder/$file");

  if (!\File::exists($path)) {
    return response()->json(['not found'], 404);
  }
  if(\File::extension($path) == 'css')
      return response()->file($path,['Content-Type'=>'text/css']);
  return response()->download($path, "$file");
}]);
