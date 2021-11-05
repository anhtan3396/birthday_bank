<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class TUserTestAnswer
 */
class TUserTestAnswer extends BaseModel
{
    protected $table = 't_user_test_answers';

    protected $primaryKey = 'ans_id';

	public $timestamps = false;

    protected $fillable = [
        'user_id',
        'test_id',
        'test_score_id',
        'quiz_id',
        'ans_result',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time'
    ];

    protected $guarded = [];

        
}