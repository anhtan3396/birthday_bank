<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class MUser
 */
class MUser extends BaseModel
{
    protected $table = 'm_user';

    protected $primaryKey = 'user_id';

	public $timestamps = false;

    protected $fillable = [
        'login_id',
        'sns_id',
        'email',
        'phone_num',
        'nick_name',
        'password',
        'login_type',
        'user_role',
        'remain_coin',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time',
        'avatar',
        'api_token',
        'remember_token',
        'token',
        'request_password_hash',
        'request_expired'
    ];

    protected $hidden = ['password'];
    
    protected $guarded = [];

        
}