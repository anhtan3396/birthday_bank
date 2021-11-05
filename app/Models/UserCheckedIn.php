<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class UserCheckedIn
 */
class UserCheckedIn extends BaseModel
{
    protected $table = 'user_checked_in';

    protected $primaryKey = 'checkin_id';

	public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'related_id',
        'earned_coin',
        'checkedin_time',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time'
    ];

    protected $guarded = [];

        
}