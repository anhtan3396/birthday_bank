<?php

namespace App\Http\Controllers\Backend;

use App\Models\MUser;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Utils\SessionManager;

class UserController extends Controller
{

    public function profilePage($id)
    {

        $user = MUser::find((int) $id);
        return view('Backend.User.profile',['user' => $user]);

    }

    //form create new user
    public function createUser()
    {
         return view('Backend.User.createUser');
    }

    //form edit user's infor
    public function editForm($id)
    {
        $currentLogin = SessionManager::getLoginInfo();
        $user = MUser::find((int) $id);
        $validator = Validator::make(['id' => $id], [
            'id'   => 'exists:users,id'
            ], []);

        if ($validator->fails())
        {
          return redirect()->back();
        }
        else
        {
          $disableRole = false;
          if($user->id === $currentLogin->id){
            $disableRole = true;
          }
          return view('Backend.User.editForm', ['user' => $user,"disableRole" => $disableRole]);
        }
    }

    //view all users and search multi
    public function users(Request $request, UserRepository $userRepository)
    {
        $phone_num    = $request->input('phone_num');
        $email      = $request->input('email');
        $nick_name  = $request->input('nick_name');
        $deleted_flag = $request->input('deleted_flag');
        // $Image = $request->input('Image');
        $search_query = MUser::query();
        if($phone_num)
        {
            $search_query->where('phone', 'like', '%'.$phone_num.'%');
        }
        if($email)
        {
            $search_query->where('email', 'like', '%'.$email.'%');
        }
        if($nick_name)
        {
            $search_query->where('nick_name', 'like', '%'.$nick_name.'%');
        }

        $users = $userRepository->getAllUsers($search_query);
        return view('Backend.User.users', ['users' => $users]);
    }

    //create new user
    public function create(Request $request, UserRepository $userRepository )
    {
     $validator = Validator::make($request->all(), [
        'avatar'                 => 'sometimes|image|size:4096',
        'email'                  => 'required|email|unique:users,email|regex:/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/',
        'nick_name'              => 'required|max:30',
        ],
        [
        'email.required'       => 'Vui lòng nhập email ',
        'email.unique'         => 'Email đã tồn tại. Vui lòng nhập email khác',
        'email.email'          => 'Email phải là địa chỉ email hợp lệ',
        'email.regex'          => 'Vui lòng nhập email không chứa những kí hiệu đặc biệt',
        'nick_name.max'        => 'Tên người dùng có nhiều nhất 30 ký tự',
        'nick_name.required'   => 'Vui lòng nhập tên người dùng',
        ]);


     if ($validator->fails())
     {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    else{
        $imageURL    = "default_avt.png";
        $email       = $request->input('email');
        // $phone_num   = $request->input('phone_num');
        $nick_name   = $request->input('nick_name');
        $password    = Hash::make($request->input('password')||123123);

        $user = $userRepository->create(
            [
            "avatar"         =>$imageURL,
            "email"          =>$email,
            "nick_name"      =>$nick_name,
            "password"       =>$password,
            "user_role"      =>$request->input('user_role')
            ]);
        if ($user->id > 0) {
          return redirect('admin/users')->with('notify', "Add success!");
        }
        else {
          return redirect('admin/users')->with('notify', "Add failed!");
        }

    }

}

    //edit user
public function update(Request $request, $id, UserRepository $userRepository )
{
    $userRepository->find($id);
    $validator = Validator::make($request->all(), [
        'nick_name'          => 'required|max:30',
        ],
        [
        'nick_name.required'              => 'Vui lòng nhập tên người dùng',
        ]);

    if ($validator->fails())
    {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    else{
      if(!$request->get('password')){
        $userRepository->update(
          [
            "nick_name"       => $request->get('nick_name'),
            "user_role"       => $request->input('user_role')
          ],
            $id,
            "id"
          );
      }else{
        $userRepository->update(
        [
          "password"        =>Hash::make($request->get('password')),
          "nick_name"       => $request->get('nick_name'),
          "user_role"       => $request->input('user_role')
        ],
          $id,
          "id"
        );
      }
        return redirect('admin/users');
    }
}

    //destroy user
public function destroy($id, UserRepository $userRepository)
{
    $currentLogin = SessionManager::getLoginInfo();
    $userOjb = $userRepository->find((int)$id);
    if($userOjb->user_role == 1)
    {
      return redirect()->back()->withErrors(['user_del' => "Xin lỗi, tài khoản bạn đang xóa là người quản trị"])->withInput();
    }else
    {
      $userRepository->update(
        [
          "deleted_flag"  => 1,
        ],
          $id,
          "id"
        );
      return redirect()->back();
    }
  }

}



