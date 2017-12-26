<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskTranscribed extends Model
{
    protected $table = 'task_transcribed';

    protected $fillable = [
        'user_id',
        'transcription',
        'task_id'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->user_id = Auth::user()->id;
        });
        self::created(function ($model) {
            $model->task->user_id = null;
//            $task = Task::where('task_id', $model->task_id)->first;
            $model->task->status = 0;
            $model->task->save();
            $task = $model->task->getVTask();
            $task->status = 1;
            $task->save();
        });

        self::deleting(function ($model) {
            if($model->task->transcribed->count() == 1){
                $model->task->status = 1;
                $model->task->save();
                $vtask = $model->task->getVTask();
                $vtask->status = 0;
                $vtask->save();
            }
        });
    }

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    public function validated()
    {
        return $this->hasMany('App\TaskValidated');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getTotalValidation(){
        return $this->validated->count();
    }

    public function getRequiredValidation(){
        return env('VALIDATION_COUNT') - $this->getTotalValidation();
    }

    public function getNumberOfAccepted(){
        return count($this->validated->where('validation_status', 'a'));
    }

    public function getNumberOfDeclined(){
        return count($this->validated->where('validation_status', 'd'));
    }

    public function getValidationStatus(){
        $status = $this->getNumberOfAccepted() - $this->getNumberOfDeclined();
        return $status;
    }

    public function isAlreadyValidated($user_id = 0) {
        $user_id = $user_id == 0 ? Auth::user()->id : $user_id;
        foreach ($this->validated as $item){
            if($item->user_id == $user_id){
                return true;
            }
        }
        return false;
    }
}
