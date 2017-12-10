<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskValidated extends Model
{
    protected $table = 'task_validated';

    protected $fillable = [
        'task_id',
        'user_id',
        'task_transcribed_id',
        'validation_status'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->user_id = Auth::user()->id;
        });
        self::created(function ($model) {
            $model->task->user_id = null;
            $model->task->status = 0;
            $model->task->save();
            if($model->validation_status == 'd') {
                $task = $model->task->getTTask();
                $task->status = 1;
                $task->save();
            }
        });

        self::deleting(function ($model) {
            if($model->task->validated->count() == 1){
                $model->task->status = 1;
                $model->task->status = 1;
            }
        });
    }

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    public function transcribed()
    {
        return $this->belongsTo('App\TaskTranscribed', 'task_transcribed_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
