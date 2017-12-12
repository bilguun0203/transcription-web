<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    protected $table = 'audio';

    protected $fillable = [
        'file'
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            Task::create(['audio_id' => $model->id, 'type' => 't', 'status' => 1]);
            Task::create(['audio_id' => $model->id, 'type' => 'v', 'status' => -1]);
        });
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
