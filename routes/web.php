<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'TestController@index')->name('test');
Route::get('/test/info', 'TestController@info')->name('info');

Route::any('captcha-test', 'TestController@captcha');
Route::any('game-project-create', 'GameController@updateCreate');
Route::group([
    'prefix'=>'/OAuth',
], function () {
    /*Route::get('/fb-login','OAuth\FbController@login');
    Route::get('/fb-callback','OAuth\FbController@callback');*/
    Route::get('/twitter-login','OAuth\TwitterController@redirectToProvider');
    Route::get('/twitter-callback','OAuth\TwitterController@handleProviderCallback');
    Route::get('/fb-login','OAuth\FbController@redirectToProvider');
    Route::get('/fb-callback','OAuth\FbController@handleProviderCallback');
    Route::get('/fb-get-token','OAuth\FbController@getAccessToken');
});
Route::group([
    'prefix'=>'',
    'namespace'=>'Home'
], function ($router) {
    $router::get('/ambassador','AmbassadorController@index');
    $router->any('/ambassador/{code}', 'AmbassadorController@ambassadorCode');
    $router::get('/uc','AmbassadorController@center');
    $router::get('/user-center','AmbassadorController@center');
    $router::get('/login','UserController@login');
    $router::post('/login','UserController@login');
    $router->any('logout', 'UserController@logout');
    $router::get('/register','UserController@register');
    $router::post('/register','UserController@register');
    $router->any('oauth-confirm-email', 'UserController@OAuthConfirmEmail');
    $router->any('confirm-email', 'UserController@confirmEmail');
    $router->any('verify-email-default', 'UserController@confirmEmail');
    $router->any('send-email', 'UserController@sendConfirmEmail');
    $router->any('verify-email-oauth', 'UserController@OauthVerifyUserEmail');
    $router->any('verify-email-default', 'UserController@defaultVerifyUserEmail');
});