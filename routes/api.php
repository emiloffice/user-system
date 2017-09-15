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

/*Route::middleware('client.credentials')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/user', function(Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group([
    'prefix'=>'/v1',
    'middleware' => ['client','auth:api']
], function () {
    Route::get('/user/info',function (Request $request){
        return $request->user();
    });
    Route::post('/user/info',function (Request $request){
        return $request->user();
    });
//    Route::get('/user-info','Api\UserController@info');
    Route::get('/user-info','Api\UserController@info');
    Route::post('/user/feedback','Api\UserController@feedback');
    Route::get('/user/feedback','Api\UserController@feedback');
});
Route::group([
    'prefix'=>'/v1'
], function (){
    Route::any('game-update-at', 'Api\GameController@update_at');
});