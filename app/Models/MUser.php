<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class MUser
 */
class MUser extends BaseModel
{
    protected $table = 'users';

    protected $primaryKey = 'id';

	public $timestamps = false;

    protected $fillable = [
        'email',
        'phone',
        'nick_name',
        'password',
        'login_type',
        'user_role',
        'deleted_flag',
        'avatar',
        'created_at',
        'created_at',
        'level',
        'experience',
        'group_id'
    ];

    protected $hidden = ['password'];
    
    protected $guarded = [];

        
}