<?php

Route::group(['prefix' => 'quiz'], function () {
    Route::get('/','HomeController@dashboard');
});























Route::get('/quiz/assets/{folder}/{file}', [ function ( $folder, $file) {

  $path = app_path("../admin_panel/public/$folder/$file");

  if (!\File::exists($path)) {
    return response()->json(['not found'], 404);
  }
  if(\File::extension($path) == 'css')
      return response()->file($path,['Content-Type'=>'text/css']);
  return response()->download($path, "$file");
}]);
