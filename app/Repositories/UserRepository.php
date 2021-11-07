<?php

namespace App\Repositories;
use App\Models\MUser;
use App\Utils\SessionManager;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Session;

class UserRepository extends BaseRepository
{
    /**
     * Create a new UserRepository instance.
     *
     * @param  App\Models\MUser $user
     * @return void
     */
    public function __construct(MUser $user)
    {
        $this->model = $user;
    }
    public function getByEmailOrLoginId($userNameOrEmail) {
        $userInfo = $this->model
            ->where("email", "=", $userNameOrEmail)
            ->first();
        return $userInfo;
    }
    /////////////login
    public function getByLoginId($userNameOrEmail) {
        $userInfo = $this->model
            ->where([['login_id', "=", $userNameOrEmail],
                ['deleted_flag','!=',1]
            ])
            ->first([
                'id',
                'login_id',
                'sns_id',
                'email',
                'phone_num',
                'nick_name',
                'password',
                'user_role',
            ]);
        return $userInfo;
    }
    public function check_API_token_User($login_id) {
        $api_token = $this->model->where([['login_id',$login_id],['deleted_flag','!=',1]])->first(['api_token']);
        return $api_token;
    }

    public function create_api_token($api_token,$email)
    {          $this->model->where('email',$email)->update(['api_token' => $api_token]);
        return $this->model->where('email',$email)->get([
            'id',
            'login_id',
            'email',
            'phone_num',
            'nick_name',
            'avatar',
            'remain_coin',
            'api_token',
        ]);
    }
    //////////////////////////Regist
    public function getLoginId() {
        $array_login_id = $this->model->where('deleted_flag','!=',1)->get(['login_id']);
        return $array_login_id->toArray();
    }
    public function registerUser($data)
    {
        $this->model->insert([
            'login_id'      => $data['login_id'],
            'email'         => $data['email'],
            'password'      => $data['password'],
            'phone_num'     => $data['phone_num'],
            'nick_name'     => $data['nick_name'],
            'user_role'     => $data['user_role'],
            'sns_id'        => $data['sns_id'],// =0
            'deleted_flag'  => $data['deleted_flag'],
            'created_user'  => $data['created_user'],
            'created_time'  => $data['created_time'],
            'updated_user'  => $data['updated_user'],
            'updated_time'  => $data['updated_time'],
        ]);
         return $this->model->where('login_id',$data['login_id'])->first(['id']);
    }
        public function updateAvatar($nameImage,$user_id)
    {               $this->model->where('id',$user_id)->update(['avatar' => $nameImage]);
            return  $this->model->where('id',$user_id)->get([
                'id',
                'login_id',
                'email',
                'phone_num',
                'nick_name',
                'avatar',
                'api_token',
                ]);
    }

    /////////////////////edit
    public function check_API_token_Test($user_id) {
        $api_token = $this->model->where([['id',$user_id],['deleted_flag','!=',1]])->first(['api_token']);
        return $api_token;
    }
    public function getLoginIDForEdit($user_id) {
        return $this->model->where([['id',$user_id],['deleted_flag','!=',1]])->first(['login_id']);
    }
    public function editProfile($data,$login_id)
    {
        $this->model->where('login_id', $login_id)->update($data);
        return $this->model->where('login_id',$login_id)->get([
            'id',
            'login_id',
            'email',
            'phone_num',
            'nick_name',
            'avatar',
            'remain_coin',
            'api_token',
        ]);
    }

    public static function findUser($name)
    {
        return MUser::where('email', $name)->first();
    }

    public static function loginAdmin()
    {
        $login_id = SessionManager::getLoginInfo();
        if($login_id != null)
        {
            $user = MUser::find($login_id);
            if(($user != null) && ($user->user_role) == 1) return true;
        }
        return false;
    }

    public function getAllUsers($search_query)
    {
        $users = $search_query->where("deleted_flag",0)->paginate(20);
        return $users;
    }

    public function getEmail($user_id){
        $email = $this->model->where('id',$user_id)->get(['email']);
        return $email->toArray();
    }

    public static function findUserRole($user_id)
    {
        return MUser::where('email', $user_id)->first();
    }

    //count total user(back end)
    public function countUsers()
    {
        $total = $this->model->where("deleted_flag",0)->count();
        return $total;
    }

}
