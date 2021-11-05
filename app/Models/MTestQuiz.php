<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class MTestQuiz
 */
class MTestQuiz extends BaseModel
{
    protected $table = 'm_test_quiz';

    protected $primaryKey = 'test_quiz_id';

	public $timestamps = false;

    protected $fillable = [
        'test_quiz_id',
        'test_id',
        'quiz_id',
        'quiz_group',
        'mondai_grp',
        'sort_order',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time'
    ];

    protected $guarded = [];

     /**
     * Get the quiz.
     */
    public function quiz()
    {
        return $this->hasOne('App\Models\MQuiz', 'quiz_id', 'quiz_id')
        ->with(["type","level","group"])
        ->select([
            'quiz_id',
            'level_id',
            'quiz_type',
            'quiz_kbn',
            'content',
            'image',
            'sound',
            'ans1',
            'ans2',
            'ans3',
            'ans4',
            'ans5',
            'ans6',
            'right_ans',
            'right_ans_exp'
        ])->where('deleted_flag', 0);
    }

    /**
     * Get the mondai.
     */
    public function mondai()
    {
        return $this->hasOne('App\Models\MTestMondai', 'mondai_id', 'mondai_grp')->select([
            'mondai_id',
            'test_id',
            'mondai_name',
            'mondai_description'
        ]);
    }
}