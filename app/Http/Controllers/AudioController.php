<?php
/**
 * Created by IntelliJ IDEA.
 * User: bilguun
 * Date: 12/9/17
 * Time: 10:55 PM
 */

namespace App\Http\Controllers;

use \App\Audio;
use App\Task;
use App\TaskTranscribed;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class AudioController extends TController
{

    public function audio(Request $request){
//        $validatedData = $request->validate([
//            'page' => ['min:1']
//        ]);
        $page = 1;
        $order_by = 'id';
        $order_type = 'asc';
        $search_col = null;
        $search_val = null;
        $search_operator = null;
        $item_per_page = 10;
        if($request->has('page')){
            $page = $request->input('page');
        }
        if($request->has('item_per_page')){
            $item_per_page = $request->input('item_per_page');
        }
        if($request->has('search_col')){
            $search_col = $request->input('search_col');
            if($request->has('search_val')){
                $search_val = $request->input('search_val');
                if($request->has('search_operator')){
                    $search_operator = $request->input('search_operator');
                }
            }
        }
        if($request->has('order_by')){
            $order_by = $request->input('order_by');
        }
        if($request->has('order_type')){
            $order_type = $request->input('order_type');
        }
        $offset = $item_per_page * ($page-1);
        $audios = Audio::orderBy($order_by, $order_type)->offset($offset)->limit($item_per_page);
        if($search_col != null && $search_val != null){
            if($search_operator != null){
                $audios->where($search_col, $search_operator, $search_val);
            }
            else {
                $audios->where($search_col, $search_val);
            }
        }
        $result = $audios->get();
        $total_rows = Audio::get()->count();
        return view('transcription.audio_list',
            [
                'audios' => $result,
                'row_from' => $offset+1,
                'row_to' => $offset + $result->count(),
                'page' => $page,
                'results' => $result->count(),
                'total_page' => ceil($total_rows/$item_per_page),
                'total_rows' => $total_rows,
                'request' => $request
            ]);
    }

    public function audio_delete(Request $request) {
        $request->validate(['delete' => 'required']);
        $model = Audio::find($request->input('delete'));
        $model->delete();
        return redirect(url()->previous())->with('msg', $request->input('delete') . ' дугаартай аудио холбогдох мэдээллийн хамт устлаа.');
    }

    public function add(){
        return view('transcription.audio_upload');
    }

    public function upload(Request $request){

        $audiofile = $request->file('audiofile');
        if($audiofile->extension() == 'wav') {
            $audioprop = [
                'filename' => $audiofile->getClientOriginalName(),
                'size' => $audiofile->getSize()
            ];
            $audioName = pathinfo($audiofile->getClientOriginalName(), PATHINFO_FILENAME);
            $newAudioName = $audioName . '-' . str_random(4) . '.' . $audiofile->extension();

            $date = new DateTime();
            $ts = $date->getTimestamp();

            $dir = 'audio_files/' . ($ts % 1000);
            if (!is_dir(public_path($dir))) {
                File::makeDirectory(public_path($dir), 0775);
            }
            $audiofile->move($dir, $newAudioName);
            $uploaded_audio = Audio::create(['file' => $newAudioName, 'url' => $dir . '/']);

            $audioprop['newname'] = $newAudioName;
            $audioprop['id'] = $uploaded_audio->id;
            return response()->json(array('audiofile' => $audioprop), 200);
        }
        else {
            return response()->json(false, 200);
        }
    }

}