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

Route::get('/', 'HomeController@home')->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/transcribe', 'TaskController@transcribe')->name('transcribe');
    Route::get('/validate', 'TaskController@validate_transcription')->name('validate');
    Route::get('/profile', 'HomeController@profile')->name('profile');
    Route::group(['middleware' => ['admin']], function () {
        Route::get('/audio', 'AudioController@audio')->name('audio.list');
        Route::get('/audio/upload', 'AudioController@add')->name('audio.upload');
    });
});

//Route::get('protected', ['middleware' => ['auth', 'admin']], function () {
//});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
