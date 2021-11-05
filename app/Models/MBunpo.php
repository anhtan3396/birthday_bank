<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class MQuiz
 */
class MBunpo extends BaseModel
{
    protected $table = 'm_bunpo';

    protected $primaryKey = 'bunpo_id';

	public $timestamps = false;

    protected $fillable = [
        'image',
        'hiragana',
        'katakana',
        'kanji',
        'meaning',
        'sound',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time',
        'is_n1',
        'is_n2',
        'is_n3',
        'is_n4',
        'is_n5',
        'is_type_practice',
        'is_type_test'
    ];
    protected $guarded = []; 

    public static function findBunpo($id)
    {
        $userField = 'bunpo_id';
        return MBunpo::where($userField,$id)->get();
    }
}