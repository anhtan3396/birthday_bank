<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class TTransaction
 */
class TTransaction extends BaseModel
{
    protected $table = 't_transaction';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'trans_id',
        'order_id',
        'trans_type',
        'trans_status',
        'money',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time'
    ];

    protected $guarded = [];

        
}