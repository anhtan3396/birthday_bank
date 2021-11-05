<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class TPurchase
 */
class TPurchase extends BaseModel
{
    protected $table = 't_purchase';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'purchase_item_type',
        'purchase_item_id',
        'purchase_coin',
        'purchase_time',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time'
    ];

    protected $guarded = [];
    
    public static function findPurchase($id)
    {
        $userField = 'id';
        return TPurchase::where($userField,$id)->get();
    }
        
}