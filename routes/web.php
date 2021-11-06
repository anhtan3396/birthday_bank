<?php

Route::group(['prefix' => '/'], function()
{
    //login
    Route::get('/login', 'Backend\BackendController@loginIndex');
    Route::post('/login', 'Backend\BackendController@login');
    Route::get('/logout', 'Backend\BackendController@logout');
    //resetPass
    Route::get('/send', 'Backend\ForgotPassController@index');
    Route::post('/send', 'Backend\ForgotPassController@sendMail');

    Route::get('/resetPassword/{email}/{hash}',['as' => 'reset','uses' =>'Backend\ForgotPassController@resetPassword']);

    Route::post('/resetPassword/{email}/{hash}',['as' => 'reset','uses' =>'Backend\ForgotPassController@updatePass']);
     //reset pass API
    Route::get('/forgotPassword/{email}/{hash}', ['as' => 'forgotPass','uses' => 'Backend\ForgotPassAPIController@forgotPassword']);

    Route::post('/forgotPassword/{email}/{hash}',['as' => 'forgotPass','uses' => 'Backend\ForgotPassAPIController@updatePassword']);

    //show video cho app
    Route::get('/showVideo','Backend\VideoController@showVideo');

    //web quản trị
    Route::group(['middleware' => ['AdminAuthencation']], function () {
        //dashboard
        Route::get('/', ['as' => 'home','uses'=> 'Backend\BackendController@index']);
        //user
        Route::get('/profile/{id}',[ 'as' => 'profile', 'uses' => 'Backend\UserController@profilePage']);
        Route::get('/users/add',['as' => 'add','uses'=> 'Backend\UserController@createUser']);
        Route::post('/users/add', 'Backend\UserController@create');
        Route::get('/users',['as' => 'users','uses'=> 'Backend\UserController@users']);
        Route::get('/users/edit/{id}', ['as' => 'edit', 'uses' => 'Backend\UserController@editForm']);
        Route::post('/users/edit/{id}', 'Backend\UserController@update');
        Route::get('/users/delete/{id}', 'Backend\UserController@destroy');
        //quiz
        Route::get('/quizs',['as' => 'quizs','uses'=> 'Backend\QuizController@index']);
        Route::get('/quizs/add',['as' => 'addQuiz','uses'=> 'Backend\QuizController@createNewQuizForm']);
        Route::post('/quizs/add','Backend\QuizController@createNewQuiz');
        Route::get('/quizs/edit/{id}', ['as' => 'editQuiz', 'uses' => 'Backend\QuizController@editQuizForm']);
        Route::post('/quizs/edit/{id}', 'Backend\QuizController@updateQuiz');
        Route::get('/quizs/detail/{id}',['as' => 'detailQuiz', 'uses' => 'Backend\QuizController@detailQuiz']);
        Route::get('/quizs/delete/{id}','Backend\QuizController@destroyQuiz');
        Route::post('/quizs/deleteall','Backend\QuizController@deleteall');
    });
});



