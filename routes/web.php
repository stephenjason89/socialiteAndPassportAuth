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
Route::get('oauth/{provider}', 'Auth\SocialController@redirectSocial');
Route::get('auth/callback/{provider}', 'Auth\SocialController@runCallback2');
