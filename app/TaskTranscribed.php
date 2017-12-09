<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskTranscribed extends Model
{
    protected $table = 'task_transcribed';

    protected $fillable = [
        'user_id',
        'transcription',
        'task_id'
    ];

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
}
