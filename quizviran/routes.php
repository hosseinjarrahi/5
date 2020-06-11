<?php

Route::group(['prefix' => 'quiz','as' => 'quizviran.','middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@home')->name('home')->withoutMiddleware('auth');

    Route::resource('/exam', 'ExamController');
    Route::post('/exam/{exam}/revival', 'ExamController@revival')->name('exam.revival');
    Route::get('/exam/{exam}/manage-questions', 'ExamController@manageQuestions')->name('questions.manage');

    Route::get('/exam/{exam}/results', 'ExamController@completeResult')->name('exam.result.teacher');
    Route::get('/exam/{exam}/pdf', 'ExamController@pdf')->name('exam.pdf');

    Route::resource('/question', 'QuestionController');
    Route::get('/question/{question}/add-to-exam', 'QuestionController@addToExam')->name('question.addTo.exam');
    Route::post('/question/add-many-to-exam', 'QuestionController@addManyToExam')->name('questions.addTo.exam');
    Route::get('/question/{question}/delete-from-exam', 'QuestionController@deleteFromExam')->name('question.deleteFrom.exam');
    Route::post('/question/delete-many-from-exam', 'QuestionController@deleteManyFromExam')->name('questions.deleteFrom.exam');

    Route::post('/complete', 'ExamController@complete')->name('exam.complete');
    Route::get('/results/{exam}','ExamController@result')->name('exam.result.student');

    Route::group(['prefix' => 'panel'], function () {
        Route::get('/','PanelController@home')->name('panel');

        Route::resource('/category','CategoryController');

        Route::post('/room/{room}/comments/paginate','CommentController@paginate')->name('comment.paginate');

        Route::get('/rooms','PanelController@home')->name('rooms');
        Route::resource('/room','RoomController');

        Route::get('/room/{room}/members','RoomController@members')->name('room.members');
        Route::get('/room/{room}/exams', 'ExamController@exams')->name('exam.manage');
        Route::get('/room/{room}/lock', 'RoomController@lock')->name('room.lock');
        Route::get('/room/{room}/gap-lock', 'RoomController@gapLock')->name('room.gapLock');

        Route::post('/room/comment','RoomController@addComment')->name('room.add.comment');
        Route::put('/room/comment/{comment}','RoomController@updateComment')->name('room.update.comment');
        Route::delete('/room/comment/{comment}','RoomController@deleteComment')->name('room.delete.comment');


        Route::get('/join-room', 'StudentController@join')->name('room.join.page');
        Route::post('/join-room', 'StudentController@addStudent')->name('room.join');

    });

});
