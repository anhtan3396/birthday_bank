<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class TRechargeHistory
 */
class TRechargeHistory extends BaseModel
{
    protected $table = 't_recharge_history';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'recharge_type',
        'card_type',
        'money',
        'coin',
        'recharge_time',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time'
    ];

    protected $guarded = [];

        
}