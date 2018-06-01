<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function task_transcribed()
    {
        return $this->hasMany('App\TaskTranscribed');
    }

    public function task_validated()
    {
        return $this->hasMany('App\TaskValidated');
    }

    public function task_edited()
    {
        return $this->hasMany('App\TaskEdit');
    }

    public function isAdmin()
    {
        return $this->isAdmin;
    }

    public function isBanned()
    {
        return $this->status == 0 ? true : false;
    }

    public function status()
    {
        $sub = DB::table('task_validated as tv')
            ->rightJoin('task_transcribed as tt', 'tt.id', '=', 'tv.task_transcribed_id')
            ->select(
                "tt.id",
                DB::raw("MAX(tt.user_id) as user_id"),
                DB::raw("COUNT(tv.id) AS 'vcount'"),
                DB::raw("(CASE WHEN SUM(CASE WHEN tv.validation_status = 'a' THEN 1 ELSE 0 END) > SUM(CASE WHEN tv.validation_status = 'd' THEN 1 ELSE 0 END) THEN 1 ELSE 0 END) AS 'vstatus'")
            )->groupBy('tt.id')->having('user_id', '=', $this->id);
        $tt = DB::table(DB::raw("({$sub->toSql()}) sub"))
            ->mergeBindings($sub)
            ->select(
                "user_id",
                DB::raw("COUNT(id) AS transcription_count"),
                DB::raw("SUM(CASE WHEN vcount >= 3 AND vstatus = 1 THEN 1 ELSE 0 END) AS total_a"),
                DB::raw("SUM(CASE WHEN vcount >= 3 AND vstatus = 0 THEN 1 ELSE 0 END) AS total_d"),
                DB::raw("SUM(CASE WHEN vcount < 3 THEN 1 ELSE 0 END) AS total_p")
            )->groupBy('user_id')->first();
        $tv = DB::table('task_validated AS tv')
            ->select(
                'tv.user_id',
                DB::raw("SUM(CASE WHEN validation_status = 'a' THEN 1 ELSE 0 END) AS 'a'"),
                DB::raw("SUM(CASE WHEN validation_status = 'd' THEN 1 ELSE 0 END) AS 'd'")
            )->groupBy('tv.user_id')
            ->having('tv.user_id', '=', $this->id)->first();
        $status = [
            'transcribe' => [
                'a' => $tt != null ? $tt->total_a : 0,
                'd' => $tt != null ? $tt->total_d : 0,
                'p' => $tt != null ? $tt->total_p : 0,
            ],
            'validate' => [
                'a' => $tv != null ? $tv->a : 0,
                'd' => $tv != null ? $tv->a : 0,
            ],
            'edit' => $this->task_edited()->count()
        ];
        return $status;
    }

    public function score()
    {
        $status = $this->status();
        $score['transcribe'] =
            (
                $status['transcribe']['a']
                + $status['transcribe']['d']
                + $status['transcribe']['p']
            ) * env('SCORE_TRANSCRIPTION_ADD')
            + $status['transcribe']['a'] * env('SCORE_PER_ACCEPTED_TRANSCRIPTION')
            + $status['transcribe']['d'] * env('SCORE_PER_DECLINED_TRANSCRIPTION');
        $score['validate'] = ($status['validate']['a'] + $status['validate']['d']) * env('SCORE_VALIDATE');
        $score['edit'] = $status['edit'] * env('SCORE_EDIT_TRANSCRIPTION');
        return $score;
    }
}
