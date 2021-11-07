<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class Group
 */
class Group extends BaseModel
{
    protected $table = 'groups';

    protected $primaryKey = 'id';

	public $timestamps = false;

    protected $fillable = [
        'name',
        'level',
        'experience',
    ];

    protected $hidden = [''];
    
    protected $guarded = [];

    public function users()
    {
      return $this->hasMany('App\Models\MUser');
    } 
}