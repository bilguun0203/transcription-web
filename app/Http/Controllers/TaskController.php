<?php
/**
 * Created by IntelliJ IDEA.
 * User: bilguun
 * Date: 12/9/17
 * Time: 10:55 PM
 */

namespace App\Http\Controllers;

use App\Rules\TranscriptionRule;
use \App\Task;
use App\TaskTranscribed;
use App\TaskValidated;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends TController
{

    /**
     * Бичвэрт буулгах хуудас, хэрэглэгчид даалгаварыг сонгож өгөх
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function transcribe(){
        $found = true;
        $result = Task::where([['user_id', Auth::user()->id], ['type', 't']])->first();
        if($result == null){
            $result = Task::where('type', 't')->where('status', 1)->where(function($query){
                $query->where('user_id', null)->orWhere('updated_at', '<', Carbon::now()->subSeconds(env('TIME'))->toDateTimeString());
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
        return redirect()->route('home')->with('msg', 'Бичвэр болгох боломжтой аудио файл олдсонгүй. Дараа дахин шалгана уу.');
    }

    /**
     * Бичвэрт буулгасан мэдээллийг хадгалах
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transcribe_save(Request $request){
        $validatedData = $request->validate([
            'transcription' => ['required', 'max:5000', new TranscriptionRule],
            'task_id' => ['required']
        ]);
        $task = Task::find($request->input('task_id'));
        if($task != null){
            if($task->user_id == Auth::user()->id){
                TaskTranscribed::create(['transcription' => $request->input('transcription'), 'task_id' => $request->input('task_id')]);
            }
        }
        return redirect()->route('transcribe');
    }

    public function transcribe_skip(){
        $result = Task::where([['user_id', Auth::user()->id], ['type', 't']])->first();
        $result->user_id = null;
        $result->save();
        return redirect()->route('transcribe');
    }

    /**
     * Бичвэрийг баталгаажуулах хуудас, баталгаажуулах даалгаварыг хэрэглэгчдэд сонгож өгөх
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function validate_transcription(){
        $found = true;
        $task = Task::where([['user_id', Auth::user()->id], ['type', 'v']])->first();
        if($task == null){
            $tasks = Task::where('type', 'v')->whereBetween('status', [0, env('VALIDATION_COUNT') - 1])->where(function($query){
                $query->where('user_id', null)->orWhere('updated_at', '<', Carbon::now()->subSeconds(env('TIME'))->toDateTimeString());
            })->get();
            $task = null;
            foreach ($tasks as $item){
                if($item->getLatestTranscribed()->user_id != Auth::user()->id && !$item->getLatestTranscribed()->isAlreadyValidated()){
                    $task = $item;
                    break;
                }
            }
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
        return redirect()->route('home')->with('msg', 'Баталгаажуулах боломжтой аудио файл олдсонгүй. Дараа дахин шалгана уу.');
    }

    /**
     * Баталгаажуулсан мэдээллийг хадгалах
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validate_transcription_save(Request $request) {
        $validatedData = $request->validate([
            'validation' => ['required', Rule::in(['a', 'd'])],
            'task_id' => ['required'],
            'transcription_id' => ['required']
        ]);
        $ttask = TaskTranscribed::find($request->input('transcription_id'));
        if($ttask != null){
            if($ttask->user_id != Auth::user()->id){
                TaskValidated::create(
                    [
                        'task_transcribed_id' => $request->input('transcription_id'),
                        'validation_status' => $request->input('validation'),
                        'task_id' => $request->input('task_id')
                    ]);
            }
        }
        return redirect()->route('validate');
    }

}