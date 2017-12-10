<?php
/**
 * Created by IntelliJ IDEA.
 * User: bilguun
 * Date: 12/9/17
 * Time: 10:55 PM
 */

namespace App\Http\Controllers;

use \App\Audio;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class AudioController extends TController
{

    public function audio(){

        return view('transcription.audio_list');
    }

    public function add(){
        return view('transcription.audio_upload');
    }

    public function upload(Request $request){
        $audiofile = $request->file('audiofile');
        $audioprop = [
            'filename' => $audiofile->getClientOriginalName(),
            'size' => $audiofile->getSize()
        ];
        $audioName = pathinfo($audiofile->getClientOriginalName(), PATHINFO_FILENAME);
        $newAudioName = $audioName . '-' . str_random(4) . '.' . $audiofile->extension();

        $date = new DateTime();
        $ts = $date->getTimestamp();

        $dir = 'audio_files/' . ($ts % 1000);
        if(!is_dir(public_path($dir))){
            File::makeDirectory(public_path($dir));
        }
        $audiofile->move($dir, $newAudioName);
        $uploaded_audio = Audio::create(['file' => $dir. '/' . $newAudioName]);

        $audioprop['newname'] = $newAudioName;
        $audioprop['id'] = $uploaded_audio->id;
        return response()->json(array('audiofile' => $audioprop), 200);
    }

}