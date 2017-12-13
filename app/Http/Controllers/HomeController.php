<?php
/**
 * Created by IntelliJ IDEA.
 * User: bilguun
 * Date: 12/9/17
 * Time: 11:02 PM
 */

namespace App\Http\Controllers;


use App\TaskTranscribed;
use App\TaskValidated;
use Illuminate\Support\Facades\Auth;

class HomeController extends TController
{

    public function home(){
        $statust = [
            'a' =>0,
            'd' =>0,
            'p' =>0,
        ];
        $statusv = [
            'a' =>0,
            'd' =>0,
        ];
        if(Auth::check()){
            $transcriptions = TaskTranscribed::where('user_id', Auth::user()->id)->get();
            foreach ($transcriptions as $item){
                if($item->getRequiredValidation() == 0){
                    if($item->getValidationStatus() > 0){
                        $statust['a']++;
                    }
                    else {
                        $statust['d']++;
                    }
                }
                else {
                    $statust['p']++;
                }
            }
            $validations = TaskValidated::where('user_id', Auth::user()->id)->get();
            foreach ($validations as $item){
                $statusv[$item->validation_status]++;
            }
        }
        return view('transcription.home',
            [
                'statust' => $statust,
                'statusv' => $statusv,
            ]);
    }

    public function profile(){
        return view('transcription.profile');
    }

}