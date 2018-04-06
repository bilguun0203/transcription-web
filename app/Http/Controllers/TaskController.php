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
use App\TaskEdit;
use App\TaskTranscribed;
use App\TaskValidated;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends TController
{

    /**
     * Бичвэрт буулгах хуудас, хэрэглэгчид даалгаварыг сонгож өгөх
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function transcribe(Request $request){
        $found = true;
        $result = null;
        $edit = false;
        if($request->has('edit') && Auth::user()->isAdmin){
            $edit = $request->input('edit');
        }
        else {
            $result = Task::where([['user_id', Auth::user()->id], ['type', 't']])->first();
        }
        if($result == null){
            if($edit == false) {
                $result = Task::where('type', 't')->where('status', 1)->where(function ($query) {
                    $query->where('user_id', null)->orWhere('updated_at', '<', Carbon::now()->subSeconds(env('TIME'))->toDateTimeString());
                })->first();
            }
            else {
                $result = Task::where('type', 't')->where('id', $edit)->where(function ($query) {
                    $query->where('user_id', null)->orWhere('user_id', Auth::user()->id)->orWhere('updated_at', '<', Carbon::now()->subSeconds(env('TIME'))->toDateTimeString());
                })->first();
                if($result == null){
                    return redirect(url()->previous())->withErrors(['Бичвэр оруулах боломжгүй.']);
                }
            }
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
                    'edit' => $edit,
                    'task' => $result
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
                if($task->status == 1 || (Auth::user()->isAdmin && $request->input('edit') != null)){
                    TaskTranscribed::create(['transcription' => $request->input('transcription'), 'task_id' => $request->input('task_id')]);
                }
            }
            else {
                return redirect()->route('home');
            }
        }
        if(Auth::user()->isAdmin && $request->input('edit') != null){
            return redirect(url()->previous())->with('msg', $request->input('edit') . ' дугаартай файлд бичвэр орууллаа.');
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
        $error = 2;
        if($ttask != null){
            if($ttask->user_id != Auth::user()->id && !$ttask->isAlreadyValidated() && $ttask->getRequiredValidation() > 0){
                TaskValidated::create(
                    [
                        'task_transcribed_id' => $request->input('transcription_id'),
                        'validation_status' => $request->input('validation'),
                        'task_id' => $request->input('task_id')
                    ]);
                $error--;
            }
            $error--;
        }
        if($request->has('multiple')){
            if($error == 2)
                return response()->json(array('id' => $request->input('id'), 'i' => $request->input('i')), 404);
            elseif ($error == 1)
                return response()->json(array('id' => $request->input('id'), 'i' => $request->input('i')), 403);
            else
                return response()->json(array('id' => $request->input('id'), 'i' => $request->input('i')), 200);
        }
        if($request->has('list')){
            if($error == 2)
                return redirect(url()->previous())->withErrors([$ttask->task->audio->id . ' дугаартай файлын бичвэрт санал өгөх даалгавар олдсонгүй.']);
            elseif ($error == 1)
                return redirect(url()->previous())->withErrors([$ttask->task->audio->id . ' дугаартай файлын бичвэрийг та оруулсан, эсвэл өмнө нь санал өгсөн тул санал өгөх боломжгүй.']);
            else
                return redirect(url()->previous())->with('msg', $ttask->task->audio->id . ' дугаартай файлын бичвэрт "' . ($request->input('validation') == 'a' ? 'зөв' : 'буруу') . '" санал өглөө.');
        }
        return redirect()->route('validate');
    }

    public function edit_transcription(Request $request){
        $found = true;
        $result = null;
        $te = TaskEdit::where([['user_id', Auth::user()->id], ['status', 0]])->first();
        $ttasks = TaskTranscribed::orderBy('id', 'asc');
        if($te == null){
            $result = $ttasks->whereIn('id', function($query) {
                $query->select('tt.id')
                    ->from('task_transcribed AS tt')
                    ->join(DB::raw('(SELECT task_id, MAX(created_at) AS latest FROM task_transcribed GROUP BY task_id) ld'),
                        function ($join) {
                            $join->on('ld.task_id', '=', 'tt.task_id');
                            $join->on('ld.latest', '=', 'tt.created_at');
                        })
                    ->join('task_validated AS tv', 'tv.task_transcribed_id', '=', 'tt.id')
                    ->join('task', 'tv.task_id', '=', 'task.id')
                    ->where('task.status', '=', env('VALIDATION_COUNT'))
                    ->groupBy('tt.id')
                    ->havingRaw('SUM(CASE WHEN tv.validation_status = \'a\' THEN 1 ELSE 0 END) > ' . env('VALIDATION_COUNT') / 2);
            })->has('edited', '<', 1)->orWhereHas('edited', function($q) {
                $q->where([
                    ['updated_at', '<', Carbon::now()->subSeconds(env('TIME'))->toDateTimeString()],
                    ['status', 0]
                ]);
            })->first();
//            dump($result);
//            return null;
//            $ttask = TaskTranscribed::where(['id', $task->id]);
            if($result != null){
                if($result->edited()->count() > 0){
                    $te = $result->edited()->latest()->first();
                    if($te->status == 0){
                        $te->user_id = Auth::user()->id;
                        $te->save();
                        $found = true;
                    }
                    else {
                        $found = false;
                    }
                }
                else {
                    $te = new TaskEdit();
                    $te->task_transcribed_id = $result->id;
                    $te->save();
                    $found = true;
                }
            }
            else {
                $found = false;
            }
        }
        else {
            $te->touch();
            $result = $te->transcribed;
        }
        if($found) {
            return view('transcription.edit',
                [
                    'task' => $te,
                    'task_transcribed' => $result
                ]);
        }
        return redirect()->route('home')->with('msg', 'Засах боломжтой бичвэр олдсонгүй. Дараа дахин шалгана уу.');
    }

}