<?php

use App\Payment\Idpay;
use Illuminate\Support\Facades\Http;

Route::group(['prefix' => 'quiz'], function () {
    Route::get('/', 'HomeController@home');
    Route::resource('/exam', 'QuizController');
    Route::post('/exam/{exam}/revival', 'QuizController@revival');
    Route::get('/exam/{exam}/manage-questions', 'QuizController@manageQuestions');

    Route::get('/exam/{exam}/results', 'QuizController@more');
    Route::get('/exam/{exam}/pdf', 'QuizController@pdf');

    Route::resource('/question', 'QuestionController');
    Route::get('/question/{question}/add-to-exam', 'QuestionController@addToExam');
    Route::get('/question/{question}/delete-from-exam', 'QuestionController@deleteFromExam');

    Route::post('/complete', 'QuizController@complete');
    Route::get('/results/{quiz}','QuizController@result');

    Route::group(['prefix' => 'panel','middleware' => ['auth']], function () {
        Route::get('/','PanelController@home');
        Route::get('/rooms','PanelController@home');
        Route::resource('/room','RoomController');
        Route::get('/room/{room}/members','RoomController@members');
        Route::post('/room/comment','RoomController@addComment');
        Route::put('/room/comment/{comment}','RoomController@updateComment');
        Route::delete('/room/comment/{comment}','RoomController@deleteComment');

        Route::get('/room/{room}/exams', 'QuizController@exams');

        Route::get('/room/{room}/lock', 'RoomController@lock');
        Route::get('/join-class', 'StudentController@join');
        Route::post('/join-class', 'StudentController@addStudent');

    });

});

Route::get('/quiz/assets/{folder}/{file}', 'HomeController@asset');
