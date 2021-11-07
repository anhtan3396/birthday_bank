<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class MQuiz
 */
class MQuiz extends BaseModel
{
    protected $table = 'quizs';

    protected $primaryKey = 'id';

	public $timestamps = false;

    protected $fillable = [
        'level',
        'content',
        'image',
        'sound',
        'ans1',
        'ans2',
        'ans3',
        'ans4',
        'right_ans',
        'right_ans_exp',
        'deleted_flag',
        'created_at',
        'updated_at',
    ];

    protected $guarded = [];

    /**
    * Get Level.
    */
    public function level()
    {
        return $this->hasOne('App\Models\MSetting', 's_value', 'level_id')
        ->where('s_key','LEVEL')->select(['s_value','s_name']);
    }
    /**
    * Get Type.
    */
    public function type()
    {
        return $this->hasOne('App\Models\MSetting', 's_value', 'quiz_type')
        ->where('s_key','QUIZ_TYPE')->select(['s_value','s_name']);
    }
    /**
    * Get Group.
    */
    public function group()
    {
        return $this->hasOne('App\Models\MSetting', 's_value', 'quiz_kbn')
        ->where('s_key','QUIZ_KBN')->select(['s_value', 's_name']);
    }

}