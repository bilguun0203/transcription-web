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

Route::get('/', 'HomeController@home')->name('index');

Route::get('/transcribe', 'TaskController@transcribe')->name('transcribe');

Route::get('/validate', 'TaskController@validate_transcription')->name('validate');

Route::get('/profile', 'HomeController@profile')->name('profile');

Route::get('/audio', 'AudioController@audio')->name('audio.list');

Route::get('/audio/upload', 'AudioController@add')->name('audio.upload');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
