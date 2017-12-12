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
            $model->task->status = $model->transcribed->getTotalValidation();
            $model->task->save();
            if($model->transcribed->getTotalValidation() == env('VALIDATION_COUNT')){
                if($model->transcribed->getValidationStatus() < 0){
                    $model->task->getTTask()->status = 1;
                    $model->task->getTTask()->save();
                }
            }
        });

        self::deleting(function ($model) {
            $latest = $model->task->getLatestTranscribed();
            if($latest->id == $model->transcribed->id) {
                $model->task->status = $model->transcribed->getTotalValidation();
                $model->task->save();
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
