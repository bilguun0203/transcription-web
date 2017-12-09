<?php
/**
 * Created by IntelliJ IDEA.
 * User: bilguun
 * Date: 12/9/17
 * Time: 10:55 PM
 */

namespace App\Http\Controllers;


class TaskController extends TController
{

    public function transcribe(){
        return view('transcription.transcribe');
    }

    public function validate_transcription(){
        return view('transcription.validate');
    }

}