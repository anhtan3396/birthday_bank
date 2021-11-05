<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('getlisttest', 'API\TestController@getListTest');
Route::post('getlistfeedback', 'API\FeedbackController@getListFeedback');
Route::post('forgotpassword', 'API\ForgotController@forgotPassword');
Route::post('getlistvideo', 'API\VideoController@getListVideo');
Route::post('refreshtest', 'API\TestController@refreshTest');
Route::post('searchvideo', 'API\VideoController@searchVideo');
///////////////////////////////////////////////////////////////////////////
//User
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::post('editprofile', 'API\UserController@editProfile');
Route::post('checked', 'API\UserController@CheckedIn');
Route::post('loginwithsocial', 'API\UserController@loginWithSocial');
Route::post('refreshlogin', 'API\UserController@refreshLogin');
//Bài Test
Route::post('gettestquestions', 'API\TestController@getTestQuestions');
Route::post('getscore', 'API\TestController@getScore');
//Từ vựng
Route::post('updatebunpo', 'API\BunpoController@updateBunpo');
Route::post('getlistbunpo', 'API\BunpoController@getListBunpo');
Route::post('searchbunpo', 'API\BunpoController@searchBunpo');
// Xếp hạng
Route::post('gettestrank', 'API\TestRankController@getTestRank');
// Purchase
Route::post('purchasevideo', 'API\PurchaseController@purchaseVideo');
Route::post('purchasetest', 'API\PurchaseController@purchaseTest');