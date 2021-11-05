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

    Route::group(['prefix' => 'recharge'],function(){
            // Route::get('/payOnline', function(){
            //     return view('Backend.recharge.payOnline');
            // });
            Route::get("/payOnline", ["as"=>"backend.recharge.payOnline","uses"=>"Backend\RechargeController@payOnline"]);
            // Route::get('/payInfor', function(){
            //     return view('Backend.recharge.payInfo');
            // });
            Route::get('/payConfirm', function(){
                return view('Backend.recharge.payConfirm');
            });
            //////////
            //son 
            // làm bằng one pay không sử dụng nữa nhưng vẫn để
            // Route::post("/payConfirm",["as"=>"backend.recharge.payConfirm","uses"=>"Backend\RechargeController@rechargeCarpayment"]);
            // Route::get('/payInfoBankCharging',function(){
            //     return view("Backend.recharge.payInfoBankCharging");
            // });
            // Route::post('/payInfoBankCharging',["as"=>"backend.recharge.payInfoBankCharging","uses"=>"Backend\RechargeController@payInfoBankCharging"]);

            Route::get('/payInfoBankVtc',["as"=>"backend.recharge.getPayInfoBankVtc","uses"=>"Backend\RechargeController@getPayInfoBankVtc"]);
            Route::post('/payInfoBankVtc',["as"=>"backend.recharge.postPayInfoBankVtc","uses"=>"Backend\RechargeController@postPayInfoBankVtc"]);
            Route::get('/payConfirmBankVtc',["as"=>"backend.recharge.getPayConfirmBankVtc","uses"=>"Backend\RechargeController@getPayConfirmBankVtc"]);
            // Route::get("/payConfirmBankCharging",["as"=>"backend.recharge.payConfirmBankCharging","uses"=>"Backend\RechargeController@payConfirmBankCharging"]);
            Route::get("/payInfoCardVtc", ["as"=>"backend.recharge.getPayInfoCardVtc","uses"=>"Backend\RechargeController@getPayInfoCardVtc"]);
            Route::post("/payConfirmCardVtc",["as"=>"backend.recharge.postPayConfirmCardVtc","uses"=>"Backend\RechargeController@postPayConfirmCardVtc"]);
            Route::get("/payCancel",["as"=>"backend.recharge.payCancel","uses"=>"Backend\RechargeController@payCancel"]);
    });  
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
        //test
        Route::get('/test',['as' => 'tests','uses'=> 'Backend\TestController@index']);
        Route::get('/test/add',['as' => 'addTest','uses'=> 'Backend\TestController@create']);
        Route::post('/test/add', 'Backend\TestController@save');
        Route::get('/test/edit/{id}', ['as' => 'editTest', 'uses' => 'Backend\TestController@edit']);
        Route::post('/test/edit/{id}', 'Backend\TestController@save');
        Route::post('/test/loadQuizs', 'Backend\TestController@loadQuizs');
        Route::post('/test/loadTest', 'Backend\TestController@loadTest');
        Route::post('/test/checkValidationMondai', 'Backend\TestController@checkValidationMondai');
        Route::get('/test/delete/{id}','Backend\TestController@destroyTest');
        Route::post('/test/deleteall','Backend\TestController@deleteall');
        //bunpo
        Route::get('/bunpos',['as' => 'bunpos','uses'=> 'Backend\BunpoController@index']);
        Route::get('/bunpos/add',['as' => 'addBunpo','uses'=> 'Backend\BunpoController@createNewBunpoForm']);
        Route::post('/bunpos/add','Backend\BunpoController@createNewBunpo');
        Route::get('/bunpos/edit/{id}', ['as' => 'editBunpo', 'uses' => 'Backend\BunpoController@editBunpoForm']);
        Route::post('/bunpos/edit/{id}', 'Backend\BunpoController@updateBunpo');
        Route::get('/bunpos/detail/{id}',['as' => 'detailBunpo', 'uses' => 'Backend\BunpoController@detailBunpo']);
        Route::get('/bunpos/delete/{id}','Backend\BunpoController@destroyBunpo');
        Route::post('/bunpos/deleteall','Backend\BunpoController@deleteall');

        Route::post('/test/searchQuizs', 'Backend\TestController@searchQuizs');
          //video
        Route::get('/videos',['as' => 'videos','uses'=> 'Backend\VideoController@index']);
        Route::get('/videos/add',['as' => 'addVideo','uses'=> 'Backend\VideoController@createNewVideoForm']);
        Route::post('/videos/add','Backend\VideoController@createNewVideo');
        Route::get('/videos/edit/{id}', ['as' => 'editVideo', 'uses' => 'Backend\VideoController@editVideoForm']);
        Route::post('/videos/edit/{id}', 'Backend\VideoController@updateVideo');
        Route::get('/videos/detail/{id}',['as' => 'detailVideo', 'uses' => 'Backend\VideoController@detailVideo']);
        Route::get('/videos/delete/{id}','Backend\VideoController@destroyVideo');
        Route::post('/videos/deleteall','Backend\VideoController@deleteall');
        //feedback
        Route::get('/feedbacks',['as' => 'feedbacks','uses'=> 'Backend\FeedbackController@index']);
        Route::get('/feedbacks/detail/{id}',['as' => 'detailFeedback', 'uses' => 'Backend\FeedbackController@detailFeedback']); 
        Route::get('/feedbacks/reply/{id}',['as' => 'reply', 'uses' => 'Backend\FeedbackController@reply']);
        Route::post('/feedbacks/reply/{id}', 'Backend\FeedbackController@updateReply');

        Route::get('/feedbacks/delete/{id}','Backend\FeedbackController@destroyFeedback');
        Route::post('/feedbacks/deleteall','Backend\FeedbackController@deleteallFeedback');

        //ranking
        Route::get('/ranking/topOfMonth',['as' => 'topOfMonth', 'uses' => 'Backend\RankingController@topOfMonth']);
        Route::get('/ranking/topOfQuarterOfTheYear',['as' => 'topOfQuarterOfTheYear', 'uses' => 'Backend\RankingController@topOfQuarterOfTheYear']);
        Route::get('/ranking/topOfYear',['as' => 'topOfYear', 'uses' => 'Backend\RankingController@topOfYear']);
        
        //histories/purchase_recharge
        Route::get('/histories/purchase',['as' => 'purchase', 'uses' =>'Backend\PurchaseController@purchase' ]);
        Route::get('/histories/recharge',['as' => 'recharge', 'uses' =>'Backend\RechargeController@recharge' ]);

        //recharge
        Route::get('/histories/recharge/delete/{id}','Backend\RechargeController@destroyRecharge');
        Route::post('/histories/recharge/deleteall','Backend\RechargeController@deleteall');    
        Route::get('/histories/recharge/detail/{id}',['as' => 'detailRecharge', 'uses' => 'Backend\RechargeController@detailRecharge']); 
        
        //purchase
        Route::get('/histories/purchase/delete/{id}','Backend\PurchaseController@destroyPurchase');
        Route::post('/histories/purchase/deleteall','Backend\PurchaseController@deleteallPurchase');
        Route::get('/histories/purchase/detail/{id}',['as' => 'detailPurchase', 'uses' => 'Backend\PurchaseController@detailPurchase']); 

        //setting
        Route::get('/settings/list',['as' => 'list_settings', 'uses' => 'Backend\SettingController@index']);
        Route::get('/settings/add',['as' => 'add_settings', 'uses' => 'Backend\SettingController@show']);
        Route::post('/settings/add','Backend\SettingController@create');
        Route::get('/settings/list/edit/{id}',['as' => 'edit_settings', 'uses' => 'Backend\SettingController@edit']);
        Route::post('/settings/list/edit/{id}','Backend\SettingController@update');
        Route::get('/settings/list/delete/{id}','Backend\SettingController@destroy');
        Route::post('/settings/deleteall','Backend\SettingController@deleteall');

    });
});



