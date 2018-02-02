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

Route::group(['middleware' => ['web', 'notbanned']], function () {
    Route::get('/', 'HomeController@home')->name('home');
    Route::get('/home', 'HomeController@home')->name('home');

    Route::group(['middleware' => ['auth', 'web']], function () {
        Route::get('/transcribe', 'TaskController@transcribe')->name('transcribe');
        Route::post('/transcribe', 'TaskController@transcribe_save')->name('transcribe.save');
        Route::get('/transcribe/skip', 'TaskController@transcribe_skip')->name('transcribe.skip');

        Route::get('/validate', 'TaskController@validate_transcription')->name('validate');
        Route::post('/validate', 'TaskController@validate_transcription_save')->name('validate.save');
        Route::get('/profile', 'HomeController@profile')->name('profile');
        Route::post('/profile/info', 'HomeController@profile_save')->name('profile.info');
        Route::post('/profile/password', 'HomeController@profile_change_password')->name('profile.password');
        Route::group(['middleware' => ['admin']], function () {
            Route::get('/audio', 'AudioController@audio')->name('audio.list');
            Route::post('/audio/delete', 'AudioController@audio_delete')->name('audio.delete');
            Route::get('/audio/upload', 'AudioController@add')->name('audio.add');
            Route::post('/audio/upload', 'AudioController@upload')->name('audio.upload');
            Route::get('/audio/export', 'AudioController@export')->name('audio.export');
            Route::get('/users', 'UserController@users')->name('user.list');
            Route::post('/users', 'UserController@usersUpdate')->name('user.post');
        });
    });
});

Auth::routes();
