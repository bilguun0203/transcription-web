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

Route::get('/transcribe', function () {
    return view('transcription.transcribe');
})->name('transcribe');
Route::get('/validate', function () {
    return view('transcription.validate');
})->name('validate');

Route::get('/validation', function () {
    return view('transcription.validation');
})->name('validation');

Route::get('/test', function () {

//    $a = new \App\Audio;
//    $a->file = "/home/a/abc.wav";
//    $a->save();

//    $a = \App\Audio::find(1);
//
//    $t = new \App\Task;
//    $t->audio_id = 2;
//    $t->assigned_to = 1;
//    $t->type = 'v';
//    $t->status = 'a';
//    $t->save();

//    $tt = new \App\TaskTranscribed;
//    $tt->user_id = 1;
//    $tt->task_id = 2;
//    $tt->transcription = "Another test";
//    $tt->save();

//    $tv = new \App\TaskValidated;
//    $tv->user_id = 1;
//    $tv->task_id = 1;
//    $tv->validated_transcription_id = 2;
//    $tv->validation_status = 'a';
//    $tv->save();

    $audio = \App\Audio::all();
    $user = \App\User::all();
    $task = \App\Task::all();
    $task_t = \App\TaskTranscribed::all();
    $task_v = \App\TaskValidated::all();

    $relation_audio = [];
    foreach ($audio as $item){
        array_push($relation_audio, $item->tasks);
    }

    $relation_user = [];
    foreach ($user as $item){
        array_push($relation_user, $item->tasks);
    }

    $relation_task_audio = [];
    $relation_task_user = [];
    $relation_task_transcribed = [];
    $relation_task_validated = [];
    foreach ($task as $item){
        array_push($relation_task_audio, $item->audio);
        array_push($relation_task_user, $item->user);
        array_push($relation_task_transcribed, $item->transcribed);
        array_push($relation_task_validated, $item->validated);
    }

    $relation_taskt_user = [];
    $relation_taskt_task = [];
    $relation_taskt_validated = [];
    foreach ($task_t as $item){
        array_push($relation_taskt_user, $item->user);
        array_push($relation_taskt_task, $item->task);
        array_push($relation_taskt_validated, $item->validated);
    }

    $relation_taskv_user = [];
    $relation_taskv_task = [];
    $relation_taskv_transcribed = [];
    foreach ($task_v as $item){
        array_push($relation_taskv_user, $item->user);
        array_push($relation_taskv_task, $item->task);
        array_push($relation_taskv_transcribed, $item->transcribed);
        dump($item);
    }

//    dump($relation_audio);
//    dump($relation_user);
//    dump($relation_task_audio);
//    dump($relation_task_user);
//    dump($relation_task_transcribed);
//    dump($relation_task_validated);
//    dump($relation_taskt_user);
//    dump($relation_taskt_task);
//    dump($relation_taskt_validated);
//    dump($relation_taskv_user);
//    dump($relation_taskv_task);
//    dump($relation_taskv_transcribed);

    return '';

//    return view('test', [
//        'audio' => $audio,
//        'user' => $user,
//        'task' => $task,
//        'task_t' => $task_t,
//        'task_v' => $task_v,
//        'r_user' => $relation_user,
//        'r_audio' => $relation_audio,
//    ]);
})->name('test');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
