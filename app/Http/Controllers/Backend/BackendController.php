<?php

namespace App\Http\Controllers\Backend;

use App\Models\MUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Utils\SessionManager;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\UserRepository;

class BackendController extends Controller
{
    
    //view dashboard 1
    public function index( UserRepository $user )
    {
        $totalTests = 0;
        $totalBunpos = 0;
        $totalVideos = 0;
        $totalUsers = $user->countUsers();
        return view('Backend.index',
        [
            'totalTests'    => $totalTests,
            'totalBunpos'   => $totalBunpos,
            'totalVideos'   => $totalVideos,
            'totalUsers'    => $totalUsers
        ]);
    }


    //view profile
   
    //view index
    public function loginIndex()
    {
        $sessionLogin = SessionManager::getLoginInfo();
        if($sessionLogin)
        {
          return redirect()->back();
        }
        return view('Backend.loginPage');
    }
    
    //check login
    public function login(Request $request,UserRepository $userRepository )
    {
        //get cookie
        $validator = Validator::make($request->all(), [
          'email'             => 'required',
          'password'          => 'required'
          ],
          [
              'email.required'    => 'Vui lòng nhập email người dùng',
              'password.required'  => 'Vui lòng nhập mật khẩu để đăng nhập.',
          ]);

          if ($validator->fails())
          {
              return redirect()->back()->withErrors($validator)->withInput();
          }
          else
          {
              $email = $request->get('email');
              $password = $request->get('password');
              $user = $userRepository->findUser($email);
              if ($user)
              {
                  if($user->user_role === 1)
                  {
                      if (Hash::check($password, $user['password']))
                      {
                          //if check remember me, rand auto a string and make remember_token of user 
                          if($request->get('remember'))
                          {
                              $user->remember_token = SessionManager::generateToken();
                              $user->save();
                              Cookie::queue(Cookie::make('remember_token', $user->remember_token, 119));
                              
                          }
                          SessionManager::setLoginInfo($user);
                          return redirect()->route('dashboard');                    
                      }
                      else return redirect()->back()->withErrors(['login' => "Tài khoản hoặc mật khẩu không đúng"])->withInput();
                  }else return redirect()->back()->withErrors(['login' => "Tên người dùng không phải là admin "])->withInput();
                      
              }
              else return redirect()->back()->withErrors(['login' => "Tài khoản hoặc mật khẩu không đúng"])->withInput();
              
          }
        
    
    }

    //logout
    public function logout()
    {   
        Cookie::queue(Cookie::forget('remember_token'));
        Session::flush();
        return redirect()->route('admin_login');
    }

}
