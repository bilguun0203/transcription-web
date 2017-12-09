<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';

    protected $fillable = [
        'audio_id',
        'user_id',
        'type',
        'status'
    ];

    public function audio()
    {
        return $this->belongsTo('App\Audio');
    }

    public function transcribed()
    {
        return $this->hasMany('App\TaskTranscribed');
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