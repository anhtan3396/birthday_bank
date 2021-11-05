<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class MQuiz
 */
class MUserBunpo extends BaseModel
{
    protected $table = 'm_user_bunpo';

    protected $primaryKey = 'user_bunpo_id';

	public $timestamps = false;

    protected $fillable = [
        'bunpo_id',
        'user_id',
        'bunpo_type_id',
        'bunpo_level_id',
        'practice_count',
        'practice_time',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time'
    ];
    protected $guarded = []; 
}