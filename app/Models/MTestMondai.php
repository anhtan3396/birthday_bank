<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class MTestMondai
 */
class MTestMondai extends BaseModel
{
    protected $table = 'm_test_mondai';

    protected $primaryKey = 'mondai_id';

	public $timestamps = false;

    protected $fillable = [
        'test_id',
        'mondai_name',
        'mondai_description',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time'
    ];

    protected $guarded = [];

        
}