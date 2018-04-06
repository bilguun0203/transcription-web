<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskEdit extends Model
{
    protected $fillable = [
        'user_id',
        'task_transcribed_id',
        'transcription',
        'status'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $tt = TaskTranscribed::where('id', $model->task_transcribed_id)->first();
            $model->user_id = Auth::user()->id;
            $model->transcription = $tt->transcription;
            $model->status = 0;
        });
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
