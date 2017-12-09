<?php
/**
 * Created by IntelliJ IDEA.
 * User: bilguun
 * Date: 12/9/17
 * Time: 11:02 PM
 */

namespace App\Http\Controllers;


class HomeController extends TController
{

    public function home(){
        return view('transcription.index');
    }

    public function profile(){
        return view('transcription.profile');
    }

}