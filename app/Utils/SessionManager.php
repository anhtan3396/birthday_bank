<?php

namespace App\Utils;

use Carbon\Carbon;
use App\Models\MUser;
use Illuminate\Support\Facades\Session;

class SessionManager extends Session
{

    public static function setLoginInfo($userInfo) {
        Session::put("USER_LOGIN_INFO", $userInfo);
    }

    public static function getLoginInfo() {
        $loginUserInfo = null;
        if(Session::has("USER_LOGIN_INFO")) {
            $loginUserInfo = Session::get("USER_LOGIN_INFO");
        }
        return $loginUserInfo;
    }
    
    public static function isAdmin() {
        $info = SessionManager::getLoginInfo();
        $loginUserInfo = MUser::findOrFail($info->id);
        $isAdmin = false;
        if($loginUserInfo != null && ($loginUserInfo->user_role == 1)) {
            $isAdmin = true;
        }
        return $isAdmin;
    }

    public static function getLoginId() {
        $loginUserInfo = SessionManager::getLoginInfo();
        $loginId = null;
        if($loginUserInfo != null) {
            $loginId = $loginUserInfo->id;
        }
        return $loginId;
    }

    public static function logout() {
        Session::flush();
    }

    public static function generateToken()
	{
		return md5(Carbon::now() . rand(100000, 999999));
	}

}