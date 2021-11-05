<?php

namespace App\Models;
use App\Models\BaseModel;

/**
 * Class MQuiz
 */
class MFeedback extends BaseModel
{
    protected $table = 'm_feedback';

    protected $primaryKey = 'feedback_id';

	public $timestamps = false;
 
    protected $fillable = [
        'user_id',
        'content',
        'content_reply',
        'topic',
        'deleted_flag',
        'created_user',
        'created_time',
        'updated_user',
        'updated_time'
        
    ];
    protected $guarded = []; 

    public static function findFeedback($id)
    {
        $userField = 'feedback_id';
        return MBunpo::where($userField,$id)->get();
    }
    public function getAllFeedback($search_query)
    {
        $feedbacks = $search_query->where("deleted_flag",0)->paginate(20);
        return $feedbacks;
    }
}