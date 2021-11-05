<?php

namespace App\Utils;

use Carbon\Carbon;
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
        $loginUserInfo = SessionManager::getLoginInfo();
        $isAdmin = false;
        if($loginUserInfo != null && ($loginUserInfo->user_role == 1 || $loginUserInfo->user_role == 3)) {
            $isAdmin = true;
        }
        return $isAdmin;
    }

    public static function getLoginId() {
        $loginUserInfo = SessionManager::getLoginInfo();
        $loginId = null;
        if($loginUserInfo != null) {
            $loginId = $loginUserInfo->user_id;
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