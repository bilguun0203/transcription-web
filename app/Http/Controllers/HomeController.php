<?php
/**
 * Created by IntelliJ IDEA.
 * User: bilguun
 * Date: 12/9/17
 * Time: 11:02 PM
 */

namespace App\Http\Controllers;


use App\Rules\SisiID;
use App\TaskTranscribed;
use App\TaskValidated;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class HomeController extends TController
{

    public function home(){
        $status = [
            'transcribe' => [
                'a' =>0,
                'd' =>0,
                'p' =>0,
            ],
            'validate' => [
                'a' =>0,
                'd' =>0,
            ],
            'edit' => 0
        ];
        $score = [
            'transcribe' => 0,
            'validate' => 0,
            'edit' => 0
        ];
        if(Auth::check()){
            $status = Auth::user()->status();
            $score = Auth::user()->score();
        }
        return view('transcription.home',
            [
                'status' => $status,
                'score' => $score
            ]);
    }

    public function profile(){
        return view('transcription.profile');
    }

    public function profile_save(Request $request){
        $validatedData = $request->validate([
//            'name' => ['required','string','max:255', new SisiID, Rule::unique('users')->ignore(Auth::user()->id)],
            'email' => ['required','string','email','max:255',Rule::unique('users')->ignore(Auth::user()->id)],
        ]);
        $user = User::findOrFail(Auth::user()->id);
//        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
//        return redirect()->route('profile')->with('msg', 'Нэр, цахим шуудан амжилттай хадгалагдлаа.');
        return redirect()->route('profile')->with('msg', 'Цахим шуудан амжилттай хадгалагдлаа.');
    }

    public function profile_change_password(Request $request){
        $validatedData = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        if(Hash::check($request->input('current_password'), Auth::user()->password)){
            $user = User::findOrFail(Auth::user()->id);
            $user->password = bcrypt($request->input('password'));
            $user->save();
            return redirect()->route('profile')->with('msg', 'Нууц үг амжилттай хадгалагдлаа.');
        }
        return redirect()->route('profile')->withErrors(['Одоогийн нууц үг тохирсонгүй.']);
    }

}