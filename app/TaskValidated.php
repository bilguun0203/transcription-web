<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskValidated extends Model
{
    protected $table = 'task_validated';

    protected $fillable = [
        'task_id',
        'user_id',
        'task_transcribed_id',
        'validation_status'
    ];

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
