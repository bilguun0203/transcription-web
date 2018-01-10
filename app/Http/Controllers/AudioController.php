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
use function PHPSTORM_META\type;


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
        $audios = Audio::orderBy($order_by, $order_type);
        /**
         * Аудио доторх хайлт
         */
        if($search_col != null && $search_val != null){
            if($search_col == 'id' || $search_col == 'file') {
                if ($search_operator != null) {
                    $audios->where($search_col, $search_operator, $search_val);
                } else {
                    $audios->where($search_col, $search_val);
                }
            }
        }
        $result = $audios->get();

        /**
         * Өөр хүснэгтээс хийх хайлтууд
         */
        switch ($search_col) {
            case 'transcription':
                $result = $result->filter(function($value) use ($search_operator, $search_val) {
                    if($value->tasks[0]->getLatestTranscribed() != null) {
                        return $this->compare__operators($value->tasks[0]->getLatestTranscribed()->transcription, $search_val, 'string', $search_operator);
                    }
                    return false;
                });
                break;
            case 'user':
                $result = $result->filter(function($value) use ($search_operator, $search_val) {
                    if($value->tasks[0]->getLatestTranscribed() != null) {
                        return $this->compare__operators($value->tasks[0]->getLatestTranscribed()->user->name, $search_val, 'string', $search_operator);
                    }
                    return false;
                });
                break;
            case 'validation_required':
                $result = $result->filter(function($value) use ($search_operator, $search_val) {
                    if($value->tasks[0]->getLatestTranscribed() != null) {
                        return $this->compare__operators($value->tasks[0]->getLatestTranscribed()->getRequiredValidation(), $search_val, 'number', $search_operator);
                    }
                    return false;
                });
                break;
            case 'accepted':
                $result = $result->filter(function($value) use ($search_operator, $search_val) {
                    if($value->tasks[0]->getLatestTranscribed() != null) {
                        return $this->compare__operators($value->tasks[0]->getLatestTranscribed()->getNumberOfAccepted(), $search_val, 'number', $search_operator);
                    }
                    return false;
                });
                break;
            case 'declined':
                $result = $result->filter(function($value) use ($search_operator, $search_val) {
                    if($value->tasks[0]->getLatestTranscribed() != null) {
                        return $this->compare__operators($value->tasks[0]->getLatestTranscribed()->getNumberOfDeclined(), $search_val, 'number', $search_operator);
                    }
                    return false;
                });
                break;
            case 'status':
                $result = $result->filter(function($value) use ($search_operator, $search_val) {
                    $status = 0;
                    if($value->tasks[0]->getLatestTranscribed() == null) {
                        $status = 0;
                    }
                    else {
                        if ($value->tasks[0]->getLatestTranscribed()->getRequiredValidation() > 0) {
                            $status = 1;
                        }
                        if ($value->tasks[0]->getLatestTranscribed()->getRequiredValidation() == 0) {
                            if ($value->tasks[0]->getLatestTranscribed()->getValidationStatus() > 0) {
                                $status = 2;
                            }
                            else if ($value->tasks[0]->getLatestTranscribed()->getValidationStatus() < 0) {
                                $status = 3;
                            }
                        }
                    }
                    return $this->compare__operators($status, $search_val, 'number', $search_operator);
                });
                break;
            default: break;
        }
        $offset = $item_per_page * ($page-1);
        $filtered = $result->slice($offset, $item_per_page);
        $total_rows = $result->count();
        return view('transcription.audio_list',
            [
                'audios' => $filtered,
                'row_from' => $offset+1,
                'row_to' => $offset + $filtered->count(),
                'page' => $page,
                'results' => $filtered->count(),
                'total_page' => ceil($total_rows/$item_per_page),
                'total_rows' => $total_rows,
                'request' => $request,
                'item_per_page' => $item_per_page
            ]);
    }

    public function audio_delete(Request $request) {
        $request->validate(['delete' => 'required']);
        $model = Audio::find($request->input('delete'));
        if($model != null) {
            $model->delete();
            if($request->has('multiple')){
                return response()->json(array('id' => $request->input('delete'), 'i' => $request->input('i')), 200);
            }
            return redirect(url()->previous())->with('msg', $request->input('delete') . ' дугаартай аудио холбогдох мэдээллийн хамт устлаа.');
        }
        if($request->has('multiple')){
            return response()->json(array('id' => $request->input('delete'), 'i' => $request->input('i')), 404);
        }
        return redirect(url()->previous())->with('msg', $request->input('delete') . ' дугаартай аудио олдсонгүй.');
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

    private function compare__operators($val1, $val2, $type = 'number', $operator = '='){
        if($type == 'number'){
            switch ($operator) {
                case '>':
                    return $val1 > $val2;
                    break;
                case '<':
                    return $val1 < $val2;
                    break;
                case '>=':
                    return $val1 >= $val2;
                    break;
                case '<=':
                    return $val1 <= $val2;
                    break;
                case '!=':
                    return $val1 != $val2;
                    break;
                default:
                    return $val1 == $val2;
                    break;
            }
        }
        else if($type == 'string'){
            switch ($operator) {
                case '!=':
                    return $val1 > $val2;
                    break;
                case 'contains':
                    return strpos($val1, $val2) !== false;
                    break;
                default:
                    return $val1 == $val2;
                    break;
            }
        }
    }

}