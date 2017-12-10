<?php
/**
 * Created by IntelliJ IDEA.
 * User: bilguun
 * Date: 12/9/17
 * Time: 10:55 PM
 */

namespace App\Http\Controllers;

use App\Rules\Cyrillic;
use \App\Task;
use App\TaskTranscribed;
use App\TaskValidated;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends TController
{

    public function transcribe(){
        $found = true;
        $result = Task::where([['user_id', Auth::user()->id], ['type', 't']])->first();
        if($result == null){
            $result = Task::where('type', 't')->where('status', 1)->where(function($query){
                $query->where('user_id', null)->orWhere('updated_at', '<', Carbon::now()->subDays(1)->toDateTimeString());
            })->first();
            if($result != null){
                $result->user_id = Auth::user()->id;
                $result->save();
                $found = true;
            }
            else {
                $found = false;
            }
        }
        else {
            $result->touch();
        }
        if($found) {
            return view('transcription.transcribe',
                [
                    'result' => $result
                ]);
        }
        return redirect()->route('home')->with('msg', 'Бичвэр болгох боломжтой аудио файл олдсонгүй.');
    }

    public function transcribe_save(Request $request){
        $validatedData = $request->validate([
            'transcription' => ['required', 'max:255'],
            'task_id' => ['required']
        ]);
        TaskTranscribed::create(['transcription' => $request->input('transcription'), 'task_id' => $request->input('task_id')]);
        return redirect()->route('transcribe');
    }

    public function transcribe_skip(){
        $result = Task::where([['user_id', Auth::user()->id], ['type', 't']])->first();
        $result->user_id = null;
        $result->save();
        return redirect()->route('transcribe');
    }

    public function validate_transcription(){
        $found = true;
        $task = Task::where([['user_id', Auth::user()->id], ['type', 'v']])->first();
        if($task == null){
            $task = Task::where('type', 'v')->where('status', 1)->where(function($query){
                $query->where('user_id', null)->orWhere('updated_at', '<', Carbon::now()->subDays(1)->toDateTimeString());
            })->first();
            if($task != null) {
                $task->user_id = Auth::user()->id;
                $task->save();
                $found = true;
            }
            else {
                $found = false;
            }
        }
        else {
            $task->touch();
        }
        if($found) {
            return view('transcription.validate',
                [
                    'task' => $task,
                    'transcribed' => $task->getLatestTranscribed()
                ]);
        }
        return redirect()->route('home')->with('msg', 'Баталгаажуулах боломжтой аудио файл олдсонгүй.');
    }

    public function validate_transcription_save(Request $request) {
        $validatedData = $request->validate([
            'validation' => ['required', Rule::in(['a', 'd'])],
            'task_id' => ['required'],
            'transcription_id' => ['required']
        ]);
        TaskValidated::create(
            [
                'task_transcribed_id' => $request->input('transcription_id'),
                'validation_status' => $request->input('validation'),
                'task_id' => $request->input('task_id')
            ]);
        return redirect()->route('validate');
    }

}