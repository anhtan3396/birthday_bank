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
            if($currentLogin->user_role == 3 || $user->email == $currentLogin->email)
            {
                return view('Backend.User.editForm', ['user' => $user]);
            }
            else
            {
                if($user->user_role == 1 || $user->user_role == 3){
                    return redirect()->back()->withErrors(['users' => "Không thể thực hiện yêu cầu, tài khoản bạn muốn sửa là người quản trị"])->withInput();
                }else
                {
                    return view('Backend.User.editForm', ['user' => $user]);
                }
            }
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
        'phone_num'              => 'required|digits_between:10,15|numeric',
        'nick_name'              => 'required|max:30',
        'password'               => 'required|min:6|regex:/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/|confirmed',
        'remain_coin'            => 'sometimes|digits_between:0,15|numeric',
        ],
        [
        'email.required'       => 'Vui lòng nhập email ',
        'email.unique'         => 'Email đã tồn tại. Vui lòng nhập email khác',
        'email.email'          => 'Email phải là địa chỉ email hợp lệ',
        'email.regex'          => 'Vui lòng nhập email không chứa những kí hiệu đặc biệt',
        'avatar.image'         => 'Vui lòng chọn đúng kiểu hình ảnh',
        'avatar.size'          => 'Hình ảnh chọn phải nhỏ hơn 4MB',
        'avatar.uploaded'      => 'Vui lòng chọn đúng hình ảnh',
        'password.regex'       => 'Mật khẩu buộc phải có kí tự in hoa, kí tự thường và số',
        'password.required'    => 'Vui lòng nhập mật khẩu',
        'password.min'         => 'Mật khẩu có ít nhất 6 ký tự',
        'password.confirmed'   => 'Nhập lại mật khẩu không đúng. Vui lòng nhập lại mật khẩu',
        'remain_coin.numeric'  => 'Vui lòng nhập xu bằng con số',
        'remain_coin.digits_between'        => 'Vui lòng nhập số xu bằng số. Số xu có tối thiểu 1 số và tối đa 15 số',
        'phone_num.required'   => 'Vui lòng nhập số điện thoại',
        'phone_num.numeric'    => 'Vui lòng nhập số điện thoại bằng số',
        'phone_num.digits_between'        => 'Vui lòng nhập số điện thoại bằng số. Số điện thoại có tối thiểu 10 số và tối đa 15 số',
        'nick_name.max'        => 'Tên người dùng có nhiều nhất 30 ký tự',
        'nick_name.required'   => 'Vui lòng nhập tên người dùng',
        ]);


     if ($validator->fails())
     {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    else{
        $imageURL    = "default_avt.png";
        $sns_id      = $request->input('sns_id');
        $email       = $request->input('email');
        $phone_num   = $request->input('phone_num');
        $nick_name   = $request->input('nick_name');
        $password    = Hash::make($request->input('password'));


        $user = $userRepository->create(
            [
            "avatar"         =>$imageURL,
            "login_id"       =>$email,
            "email"          =>$email,
            "phone_num"      =>$phone_num,
            "nick_name"      =>$nick_name,
            "password"       =>$password,
            ]);
        if ($user->id > 0) {
                // Edit image
            if(Input::hasfile('avatar'))
            {
                    //image
                $nameImage = Input::file('avatar')->getClientOriginalExtension();
                $imageURL = $user->id . "." . date("H_i_s",time()). ".". $nameImage;
                if(File::exists(public_path('upload/image/avatar/') . $imageURL))
                {
                    unlink(public_path('upload/image/avatar/') . $imageURL);
                }
                Input::file('avatar')->move(public_path('upload/image/avatar/'), $imageURL);
            }else
            {
                $imageURL = "default_avt.png";
            }
            $userRepository->update([
                'avatar'     =>  $imageURL,
                ], $user->id, "id");

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
    if($request->get('password') == '')
    {
        $validator = Validator::make($request->all(), [
            'phone_num'          => 'required|digits_between:10,15|numeric',
            'nick_name'          => 'required|max:30',
            'remain_coin'        => 'sometimes|digits_between:0,15|numeric',
            'avatar'             => 'sometimes|image|max:4096',

            ],
            [
            'phone_num.required'              => 'Vui lòng nhập số điện thoại',
            'phone_num.digits_between'        => 'Số điện thoại có thiểu 10 số và tối đa 15 số',
            'phone_num.numeric'               => 'Vui lòng nhập số điện thoại bằng số',
            'phone_num.digits_between'        => 'Vui lòng nhập số điện thoại bằng số. Số điện thoại có tối thiểu 10 số và tối đa 15 số',

            'nick_name.required'              => 'Vui lòng nhập tên người dùng',
            'remain_coin.numeric'  => 'Vui lòng nhập xu bằng con số',
            'remain_coin.digits_between'        => 'Vui lòng nhập số xu bằng số. Số xu có tối thiểu 1 số và tối đa 15 số',
            'avatar.uploaded'                 => 'Hình ảnh chọn phải nhỏ hơn 4MB',
            ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{

            if (Input::hasfile('avatar'))
            {
                $nameImage = Input::file('avatar')->getClientOriginalExtension();
                $imageURL = $id . "." . date("H_i_s",time()). ".". $nameImage;
                if(File::exists(public_path('upload/image/avatar/') . $imageURL))
                {
                    unlink(public_path('upload/image/avatar/') . $imageURL);
                }
                Input::file('avatar')->move(public_path('upload/image/avatar/'), $imageURL);
                $userRepository->update(
                    [
                    "avatar"          => $imageURL,
                    ],
                    $id,
                    "id"
                    );
            }
            $userRepository->update(
                [
                "phone_num" => $request->get('phone_num'),
                "nick_name" => $request->get('nick_name'),
                "remain_coin" => $request->get('remain_coin')
                ],
                $id,
                "id"
                );

            return redirect('users');
        }
    }else
    {
        $validator = Validator::make($request->all(), [
            'password'          => 'required|min:6|regex:/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/|confirmed',
            'phone_num'         => 'required|digits_between:10,15|numeric',
            'nick_name'         => 'required|max:30',
            'remain_coin'       => 'required|digits_between:0,15|numeric',

            ],
            [ 'password.regex'       => 'Mật khẩu phải có kí tự in hoa, kí tự thường và số',
            'password.min'         => 'Mật khẩu có ít nhất 6 ký tự',
            'password.confirmed'   => 'Vui lòng nhập lại mật khẩu',
            'phone_num.required'   => 'Số điện thoại không được để trống',
            'phone_num.digits_between'        => 'Số điện thoại có thiểu 10 số và tối đa 15 số',
            'phone_num.numeric'    => 'Vui lòng nhập bằng số',
            'phone_num.digits_between'        => 'Vui lòng nhập số điện thoại bằng số. Số điện thoại có tối thiểu 10 số và tối đa 15 số',
            'remain_coin.numeric'  => 'Vui lòng nhập xu bằng con số',
            'remain_coin.digits_between'        => 'Vui lòng nhập số xu bằng số. Số xu có tối thiểu 1 số và tối đa 15 số',
            'nick_name.required'   => 'Tên không được để trống',
            ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $userRepository->update(
                [
                "password"   =>Hash::make($request->get('password')),
                "phone_num"  => $request->get('phone_num'),
                "nick_name"  => $request->get('nick_name'),
                "remain_coin" => $request->get('remain_coin'),
                ],
                $id,
                "id"
                );
            return redirect('users');
        }
    }
}

    //destroy user
public function destroy($id, UserRepository $userRepository)
{
    $currentLogin = SessionManager::getLoginInfo();
    $userOjb = $userRepository->find((int)$id);
    if($currentLogin->user_role == 3){
        $userRepository->update(
            [
            "deleted_flag"          => 1,
            ],
            $id,
            "id"
            );
        return redirect()->back();
    }else
    {
        if($userOjb->user_role == 1 || $userOjb->user_role == 3)
        {
            return redirect()->back()->withErrors(['users' => "Xin lỗi, tài khoản bạn đang xóa là người quản trị"])->withInput();
        }else
        {
            $userRepository->update(
                [
                "deleted_flag"          => 1,
                ],
                $id,
                "id"
                );
            return redirect()->back();
        }
    }
}

}



