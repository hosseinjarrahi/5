<?php

Route::group(['prefix' => 'quiz'], function () {
    Route::get('/', 'HomeController@home');
});
























Route::get('/quiz/assets/{folder}/{file}', [
    function ($folder, $file) {

        $path = app_path("../quizviran/public/$folder/$file");

        if (! \File::exists($path)) {
            return response()->json(['not found'], 404);
        }
        if (\File::extension($path) == 'css') {
            return response()->file($path, ['Content-Type' => 'text/css']);
        }
        if (\File::extension($path) == 'svg') {
            return response()->file($path, ['Content-Type' => 'image/svg+xml']);
        }

        return response()->download($path, "$file");
    },
]);
