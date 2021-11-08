<?php

namespace App\Http\Controllers\Frontend;

use App\Models\MUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Utils\SessionManager;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\UserRepository;

class FrontendController extends Controller
{
  public function index( )
  {
    return view('Frontend.index');
  }
  public function profile( )
  {
    return view('Frontend.profile');
  }

  public function loginIndex()
  {
    $sessionLogin = SessionManager::getLoginInfo();
    if($sessionLogin)
    {
      return redirect()->back();
    }
    return view('Frontend.auth.loginPage');
  }

  public function resetPassIndex()
  {
    $info = SessionManager::getLoginInfo();
    $loginUserInfo = MUser::findOrFail($info->id);
    if($loginUserInfo){
      if($loginUserInfo->reset_pass)
      {
        return redirect()->route('profile');
      }
      return view('Frontend.auth.resetPass');
    }else{
      return redirect()->route('guest_login');
    }
  }


  public function resetPass(Request $request, UserRepository $userRepository)
  {
    $info = SessionManager::getLoginInfo();
    $sessionLogin = MUser::findOrFail($info->id);
    if($sessionLogin->reset_pass)
    {
      return redirect()->route('profile');
    }
    $validator = Validator::make($request->all(), [
      'password'                => 'required|min:6|confirmed'
      ],
      [
        'password.confirmed'         => 'Nhập lại mật khẩu không đúng',
        'password.min'               => 'Mật khẩu có ít nhất 6 ký tự' 
      ]);

    if ($validator->fails())
    {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    $userRepository->update(
      [
        "password"        => Hash::make($request->get('password')),
        "reset_pass"      => 1
      ],
        $sessionLogin->id,
        "id"
    );
    $user = MUser::findOrFail($sessionLogin->id);
    SessionManager::setLoginInfo($user);
    return redirect()->route('profile')->with(['success' => 'Cập nhật mật khẩu thành công']);
  }


  public function logout()
  {
    Session::flush();
    return redirect()->route('home');
  }
}
