<?php

Route::group(['prefix' => '/admin'], function () {
    //login
    Route::get('/login', 'Backend\BackendController@loginIndex')->name("admin_login");
    Route::post('/login', 'Backend\BackendController@login')->name("post_admin_login");
    Route::get('/logout', 'Backend\BackendController@logout')->name("admin_logout");

    Route::get('/set-pass', 'Backend\BackendController@setPass')->name("admin_setpass");
    Route::post('/set-pass', 'Backend\BackendController@setPassPost')->name("post_admin_setpass");
    //web quản trị
    Route::group(['middleware' => ['AdminAuthencation','CheckActivePass']], function () {
        //dashboard
        Route::get('/', ['as' => 'dashboard', 'uses' => 'Backend\BackendController@index']);
        //user
        Route::get('/profile/{id}',[ 'as' => 'user.profile', 'uses' => 'Backend\UserController@profilePage']);
        Route::get('/users/add',['as' => 'user.add','uses'=> 'Backend\UserController@createUser']);
        Route::post('/users/add', 'Backend\UserController@create');
        Route::get('/users',['as' => 'users','uses'=> 'Backend\UserController@users']);
        Route::get('/users/edit/{id}', ['as' => 'user.edit', 'uses' => 'Backend\UserController@editForm']);
        Route::post('/users/edit/{id}', 'Backend\UserController@update');
        Route::get('/users/delete/{id}', 'Backend\UserController@destroy');
        //quiz
        Route::get('/quizs', ['as' => 'quizs', 'uses' => 'Backend\QuizController@index']);
        Route::get('/quizs/add', ['as' => 'addQuiz', 'uses' => 'Backend\QuizController@createNewQuizForm']);
        Route::post('/quizs/add', 'Backend\QuizController@createNewQuiz');
        Route::get('/quizs/edit/{id}', ['as' => 'editQuiz', 'uses' => 'Backend\QuizController@editQuizForm']);
        Route::post('/quizs/edit/{id}', 'Backend\QuizController@updateQuiz');
        Route::get('/quizs/detail/{id}', ['as' => 'detailQuiz', 'uses' => 'Backend\QuizController@detailQuiz']);
        Route::get('/quizs/delete/{id}', 'Backend\QuizController@destroyQuiz');
        Route::post('/quizs/deleteall', 'Backend\QuizController@deleteall');
    });
});

//site
Route::group(['prefix' => '/'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'Frontend\FrontendController@index']);
    Route::get('/profile', ['as' => 'home', 'uses' => 'Frontend\FrontendController@index']);

    Route::get('/login', 'Frontend\FrontendController@loginIndex')->name("guest_login");
    Route::post('/login', 'Auth\LoginController@postLogin')->name("post_guest_login");
    Route::get('/logout', 'Frontend\FrontendController@logout')->name("guest_logout");

    Route::get('/reset-password', 'Frontend\FrontendController@resetPassIndex')->name("guest_reset_pass");
    Route::post('/reset-password', 'Frontend\FrontendController@resetPass')->name("post_guest_reset_pass");
    Route::group(['middleware' => ['auth','CheckActivePass']], function () {
    });
});
