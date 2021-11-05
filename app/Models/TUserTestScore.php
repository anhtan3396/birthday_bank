<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class TUserTestScore
 */
class TUserTestScore extends BaseModel
{
    protected $table = 't_user_test_scores';

    protected $primaryKey = 'test_score_id';

	public $timestamps = false;

    protected $fillable = [
        'user_id',
        'test_id',
        'test_date',
        'quiz_group',
        'total_right_answers_goi',
        'total_question_goi',
        'total_right_answers_dokkai',
        'total_question_dokkai',
        'total_right_answers_choikai',
        'total_question_choikai',
        'total_play_time',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time'
    ];

    protected $guarded = [];

        
}