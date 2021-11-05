<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class MTest
 */
class MTest extends BaseModel
{
    protected $table = 'm_test';

    protected $primaryKey = 'test_id';

	public $timestamps = false;

    protected $fillable = [
        'test_name',
        'test_image_icon',
        'test_price',
        'test_description',
        'test_type_id',
        'test_level_id',
        'test_limit_time_goi',
        'test_limit_time_choukai',
        'test_limit_time_gokai',
        'public_status',
        'public_date',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time'
    ];

    protected $guarded = [];

    public function getAllTests($search_query)
    {
        $tests = $search_query->where("deleted_flag",0)->paginate(5);
        return $tests;
    }

}