<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function task_transcribed()
    {
        return $this->hasMany('App\TaskTranscribed');
    }

    public function task_validated()
    {
        return $this->hasMany('App\TaskValidated');
    }

    public function task_edited()
    {
        return $this->hasMany('App\TaskEdit');
    }

    public function isAdmin()
    {
        return $this->isAdmin;
    }

    public function isBanned()
    {
        return $this->status == 0 ? true : false;
    }

    public function status()
    {
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
        foreach ($this->task_transcribed as $item){
            if($item->getRequiredValidation() == 0){
                if($item->getValidationStatus() > 0){
                    $status['transcribe']['a']++;
                }
                else {
                    $status['transcribe']['d']++;
                }
            }
            else {
                $status['transcribe']['p']++;
            }
        }
        foreach ($this->task_validated as $item){
            $status['validate'][$item->validation_status]++;
        }
        $status['edit'] = $this->task_edited()->count();
        return $status;
    }

    public function score()
    {
        $status = $this->status();
        $score['transcribe'] =
            (
                $status['transcribe']['a']
                + $status['transcribe']['d']
                + $status['transcribe']['p']
            ) * env('SCORE_TRANSCRIPTION_ADD')
            + $status['transcribe']['a'] * env('SCORE_PER_ACCEPTED_TRANSCRIPTION')
            + $status['transcribe']['d'] * env('SCORE_PER_DECLINED_TRANSCRIPTION');
        $score['validate'] = ($status['validate']['a'] + $status['validate']['d']) * env('SCORE_VALIDATE');
        $score['edit'] = $status['edit'] * env('SCORE_EDIT_TRANSCRIPTION');
        return $score;
    }
}
