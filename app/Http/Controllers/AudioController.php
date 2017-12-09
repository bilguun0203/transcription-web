<?php
/**
 * Created by IntelliJ IDEA.
 * User: bilguun
 * Date: 12/9/17
 * Time: 10:55 PM
 */

namespace App\Http\Controllers;


class AudioController extends TController
{

    public function audio(){
        return view('transcription.audio_list');
    }

    public function add(){
        return view('transcription.audio_upload');
    }

}