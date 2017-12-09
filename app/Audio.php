<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    protected $table = 'audio';

    protected $fillable = [
        'file'
    ];

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
