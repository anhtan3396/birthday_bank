<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class MQuiz
 */
class MVideo extends BaseModel
{
    protected $table = 'm_video';

    protected $primaryKey = 'video_id';

	public $timestamps = false;

    protected $fillable = [
        'video_id',
        'video_image',
        'video_title',
        'video_description',
        'video_path',
        'video_price',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time'
    ];

    protected $guarded = [];

   
}