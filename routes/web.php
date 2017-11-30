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
    return view('transcription.index');
})->name('index');

Route::get('/home', function () {
    return view('transcription.index');
})->name('home');

Route::get('/audio', function () {
    return view('transcription.audio');
})->name('audio');

Route::get('/validation', function () {
    return view('transcription.validation');
})->name('validation');
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
