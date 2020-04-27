<?php

Route::group(['prefix' => 'quiz','middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@home')->withoutMiddleware('auth');

    Route::resource('/exam', 'ExamController');
    Route::post('/exam/{exam}/revival', 'ExamController@revival');
    Route::get('/exam/{exam}/manage-questions', 'ExamController@manageQuestions');

    Route::get('/exam/{exam}/results', 'ExamController@completeResult');
    Route::get('/exam/{exam}/pdf', 'ExamController@pdf');

    Route::resource('/question', 'QuestionController');
    Route::get('/question/{question}/add-to-exam', 'QuestionController@addToExam');
    Route::get('/question/{question}/delete-from-exam', 'QuestionController@deleteFromExam');

    Route::post('/complete', 'ExamController@complete');
    Route::get('/results/{exam}','ExamController@result');

    Route::group(['prefix' => 'panel'], function () {
        Route::get('/','PanelController@home');
        Route::get('/rooms','PanelController@home');
        Route::resource('/room','RoomController');

        Route::get('/room/{room}/members','RoomController@members');
        Route::get('/room/{room}/exams', 'ExamController@exams');
        Route::get('/room/{room}/lock', 'RoomController@lock');
        Route::get('/room/{room}/gap-lock', 'RoomController@gapLock');

        Route::post('/room/comment','RoomController@addComment');
        Route::put('/room/comment/{comment}','RoomController@updateComment');
        Route::delete('/room/comment/{comment}','RoomController@deleteComment');


        Route::get('/join-room', 'StudentController@join');
        Route::post('/join-room', 'StudentController@addStudent');

    });

});

Route::get('/quiz/assets/{folder}/{file}', 'HomeController@asset');
