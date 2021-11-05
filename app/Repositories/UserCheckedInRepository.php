<?php

namespace App\Repositories;
use App\Models\UserCheckedIn;
use App\Utils\SessionManager;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Session;

class UserCheckedInRepository extends BaseRepository
{
    /**
     * Create a new UserRepository instance.
     *
     * @param  App\Models\MUser $user
     * @return void
     */
    public function __construct(UserCheckedIn $userCheckedIn) 
    {
        $this->model = $userCheckedIn;
    }

        public function userChecked($user_id) {
        return $this->model->where([['user_id',$user_id],['deleted_flag','!=',1]])->first(['checkin_id']);
    }
    public function newChecked($new_data)
    {
        $this->model->insert([
            'action'            => $new_data['action'],
            'user_id'           => $new_data['user_id'],
            'related_id'        => $new_data['related_id'],
            'earned_coin'       => $new_data['earned_coin'],
            'checkedin_time'    => $new_data['checkedin_time'],
            'deleted_flag'      => $new_data['deleted_flag'],
            'created_user'      => $new_data['created_user'],
            'created_time'      => $new_data['created_time'],
            'updated_user'      => $new_data['updated_user'],
            'updated_time'      => $new_data['updated_time'],
        ]);

    }
}