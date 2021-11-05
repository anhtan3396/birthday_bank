<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class UserDevice
 */
class UserDevice extends BaseModel
{
    protected $table = 'user_devices';

    protected $primaryKey = 'device_id';

	public $timestamps = false;

    protected $fillable = [
        'user_id',
        'device_type',
        'device_serial_id',
        'last_login_time'
    ];

    protected $guarded = [];

        
}