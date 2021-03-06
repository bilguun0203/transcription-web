<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Audio extends Model
{
    protected $table = 'audio';

    protected $fillable = [
        'file',
        'url'
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            Task::create(['audio_id' => $model->id, 'type' => 't', 'status' => 1]);
            Task::create(['audio_id' => $model->id, 'type' => 'v', 'status' => -1]);
        });
        self::deleting(function ($model) {
            if($model->isLocal){
                File::delete($model->url . $model->file);
            }
        });
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
