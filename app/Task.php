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

    public function getLatestTranscribed()
    {
        $task = $this;
        if($this->type == 'v'){
            foreach ($this->audio->tasks as $item){
                if($item->type == 't'){
                    $task = $item;
                }
            }
        }
        return $task->transcribed->sortByDesc('created_at')->first();
    }

    public function getLatestValidated()
    {
        $task = $this->getVTask();
        return $task->validated->sortByDesc('created_at')->first();
    }

    public function getNotValidated()
    {
        $task = $this->getTTask();
        return $task->transcribed->sortByDesc('created_at')->first();
    }

    public function getTTask()
    {
        if($this->type == 'v'){
            foreach ($this->audio->tasks as $item){
                if($item->type == 't'){
                    return $item;
                }
            }
        }
        return $this;
    }

    public function getVTask()
    {
        if($this->type == 't'){
            foreach ($this->audio->tasks as $item){
                if($item->type == 'v'){
                    return $item;
                }
            }
        }
        return $this;
    }
}
