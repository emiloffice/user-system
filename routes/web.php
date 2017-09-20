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
    Route::get('/fb-login','OAuth\FbController@login');
    Route::get('/fb-callback','OAuth\FbController@callback');
});