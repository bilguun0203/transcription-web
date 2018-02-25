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
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;


class AudioController extends TController
{

    public function audio(Request $request){

//        $ld = DB::table('task_transcribed AS ld')
//            ->select('ld.task_id', DB::raw('MAX(ld.created_at) as latest'))
//            ->groupBy('ld.task_id')
//            ->get();

//        $tt = DB::table('task_transcribed AS tt')
//            ->select('tt.task_id', 'tt.transcription', 'tt.user_id')
//            ->whereIn('tt.task_id', function($query) {
//                $query->select('task_id', DB::raw('MAX(created_at) as latest'))
//                    ->from(with(new TaskTranscribed)->getTable())
//                    ->groupBy('task_id');
//            });

        /*
        $tt = DB::table('task_transcribed AS tt')
            ->select('task.audio_id', 'tt.task_id', 'tt.transcription', 'tt.user_id')
            ->join(DB::raw('(SELECT task_id, MAX(created_at) AS latest FROM task_transcribed GROUP BY task_id) ld'),
                function($join) {
                    $join->on('ld.task_id', '=', 'tt.task_id');
                    $join->on('ld.latest', '=', 'tt.created_at');
                })
            ->join('task', 'tt.task_id', '=', 'task.id')
            ->where('transcription', '=', '<p>%өө</p>')
            ->get();

//        dump($);
        dump($tt);
        return 0;
        */
//        $validatedData = $request->validate([
//            'page' => ['min:1']
//        ]);
        $order_by = 'id';
        $order_type = 'asc';
        $search_col = null;
        $search_val = null;
        $search_operator = null;
        $item_per_page = 10;
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

        if($search_col != null && $search_val != null){
            /**
             * Аудио хүснэгт доторх хайлт
             */
            if($search_col == 'id' || $search_col == 'file') {
                if ($search_operator != null) {
                    $audios->where($search_col, $search_operator, $search_val);
                } else {
                    $audios->where($search_col, $search_val);
                }
            }
            /**
            * Өөр хүснэгтээс хийх хайлтууд
            */
            else {
                switch ($search_col) {
                    case 'transcription':
                        $audios->whereIn('id', function($query) use($search_operator, $search_val) {
                            $query->select('task.audio_id')
                                ->from('task_transcribed AS tt')
                                ->join(DB::raw('(SELECT task_id, MAX(created_at) AS latest FROM task_transcribed GROUP BY task_id) ld'),
                                    function($join) {
                                        $join->on('ld.task_id', '=', 'tt.task_id');
                                        $join->on('ld.latest', '=', 'tt.created_at');
                                    })
                                ->join('task', 'tt.task_id', '=', 'task.id')
                                ->where('transcription', $search_operator, $search_val);
                        });
                        break;
                    case 'user':
                        $audios->whereIn('id', function($query) use($search_operator, $search_val) {
                            $query->select('task.audio_id')
                                ->from('task_transcribed AS tt')
                                ->join(DB::raw('(SELECT task_id, MAX(created_at) AS latest FROM task_transcribed GROUP BY task_id) ld'),
                                    function($join) {
                                        $join->on('ld.task_id', '=', 'tt.task_id');
                                        $join->on('ld.latest', '=', 'tt.created_at');
                                    })
                                ->join('users', 'tt.user_id', '=', 'users.id')
                                ->join('task', 'tt.task_id', '=', 'task.id')
                                ->where('users.name', $search_operator, $search_val);
                        });
                        break;
                    case 'validation_required':
//                        $result = $result->filter(function($value) use ($search_operator, $search_val) {
//                            if($value->tasks[0]->getLatestTranscribed() != null) {
//                                return $this->compare__operators($value->tasks[0]->getLatestTranscribed()->getRequiredValidation(), $search_val, 'number', $search_operator);
//                            }
//                            return false;
//                        });
                        break;
                    case 'accepted':
//                        $result = $result->filter(function($value) use ($search_operator, $search_val) {
//                            if($value->tasks[0]->getLatestTranscribed() != null) {
//                                return $this->compare__operators($value->tasks[0]->getLatestTranscribed()->getNumberOfAccepted(), $search_val, 'number', $search_operator);
//                            }
//                            return false;
//                        });
                        break;
                    case 'declined':
//                        $result = $result->filter(function($value) use ($search_operator, $search_val) {
//                            if($value->tasks[0]->getLatestTranscribed() != null) {
//                                return $this->compare__operators($value->tasks[0]->getLatestTranscribed()->getNumberOfDeclined(), $search_val, 'number', $search_operator);
//                            }
//                            return false;
//                        });
                        break;
                    case 'status':
//                        $result = $result->filter(function($value) use ($search_operator, $search_val) {
//                            $status = 0;
//                            if($value->tasks[0]->getLatestTranscribed() == null) {
//                                $status = 0;
//                            }
//                            else {
//                                if ($value->tasks[0]->getLatestTranscribed()->getRequiredValidation() > 0) {
//                                    $status = 1;
//                                }
//                                if ($value->tasks[0]->getLatestTranscribed()->getRequiredValidation() == 0) {
//                                    if ($value->tasks[0]->getLatestTranscribed()->getValidationStatus() > 0) {
//                                        $status = 2;
//                                    }
//                                    else if ($value->tasks[0]->getLatestTranscribed()->getValidationStatus() < 0) {
//                                        $status = 3;
//                                    }
//                                }
//                            }
//                            return $this->compare__operators($status, $search_val, 'number', $search_operator);
//                        });
                        break;
                    default: break;
                }

            }
        }
        $result = $audios->paginate($item_per_page);

        return view('transcription.audio_list',
            [
                'audios' => $result,
                'total' => $result->total(),
                'page' => $result->currentPage(),
                'firstItem' => $result->firstItem(),
                'lastItem' => $result->lastItem(),
                'hasMorePages' => $result->hasMorePages(),
                'lastPage' => $result->lastPage(),
                'perPage' => $result->perPage(),
                'count' => $result->count(),
                'request' => $request
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

    public function export(Request $request) {
        $result = Audio::all();
        $result = $result->filter(function($value) {
            if($value->tasks[0]->getLatestTranscribed() != null){
                if ($value->tasks[0]->getLatestTranscribed()->getRequiredValidation() == 0 && $value->tasks[0]->getLatestTranscribed()->getValidationStatus() > 0) {
                    return true;
                }
            }
            return false;
        });
        $json = [];
        foreach($result as $item){
            array_push($json, [
                'id' => $item->id,
                'file' => $item->file,
                'task' => [
                    'transcribe' => [
                        'id' => $item->tasks[0]->getTTask()->id,
                        'transcription' => $item->tasks[0]->getLatestTranscribed()->transcription
                    ],
                    'validate' => [
                        'id' => $item->tasks[0]->getVTask()->id,
                        'number_of_accepted' => $item->tasks[0]->getLatestTranscribed()->getNumberOfAccepted(),
                        'number_of_declined' => $item->tasks[0]->getLatestTranscribed()->getNumberOfDeclined(),
                    ]
                ]
            ]);
        }

        $dest = storage_path('json');
        $filename = time().'-'.'export.json';
        $file_path = $dest . '/' . $filename;
        File::put($file_path, json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        return Response::download($file_path);
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