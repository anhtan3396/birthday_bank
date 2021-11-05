<?php

namespace App\Repositories;
use App\Models\MFeedback;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Schema;

class FeedbackRepository extends BaseRepository
{
	public function __construct(
        MFeedback $mFeedback
    ) 
    {
        $this->model = $mFeedback;
    }

    public function getAllFeedback($search_query)
    {
        $emails = $search_query->where("deleted_flag",0)->paginate(20);
        return $emails;
    }
    public function getAllEmailFromFeedback($user_id){
         $email = $this->model->where("user_id","=",$user_id)->get([
                'user_id',  
                'email',
                'content',
                'deleted_flag',
            ]);
        return $email->toArray();
    }
    public function insertMail($data)
    {
        return $this->model->insert([
            'user_id'      => $data['user_id'],
            'content'       => $data['content'],
            'deleted_flag'  => $data['deleted_flag'],
            'created_user'  => $data['created_user'],
            'created_time'  => $data['created_time'],
            'updated_user'   => $data['updated_user'],
            'updated_time'   => $data['updated_time']
        ]);
    }
    public function getUserId($feedback_id){
        $user = $this->model->where("feedback_id",$feedback_id)->first();
        return $user;
    }

}