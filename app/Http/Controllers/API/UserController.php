<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use App\Repositories\UserRepository;
use App\Repositories\UserCheckedInRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

// use Illuminate\Validation\Validator;
class UserController extends Controller
{
    public function login(Request $request, UserRepository $userRepository, TestRepository $testRepository)
    {
        $validator = Validator::make($request->all(),
            [
                'login_id'          => 'required|email|regex:/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/',
                'password'          => 'required',
            ],[

                'login_id.required'    => 'Vui lòng nhập tài khoản và mật khẩu!',
                'password.required'    => 'Vui lòng nhập tài khoản và mật khẩu!',
                'login_id.email'       => 'login_id phải là email',
                'login_id.regex'       => 'Vui lòng nhập login_id không chứa những kí hiệu đặc biệt',
            ]);
        if ($validator->fails())
        {
            return response()->json([
                'resultCode'            => -1,
                'message'               => $validator->errors()->first(),
                'data'                  => null
            ]);
        }else{
            $login_id           = $request->login_id;
            $password           = $request->password;
            $user               = $userRepository->getByLoginId($login_id);
            $check_api_token    = $userRepository->check_API_token_User($login_id);
            // var_dump($check_api_token['api_token']);die();
            // if ($check_api_token['api_token'] != null || $check_api_token['api_token'] != '') {
            //             return response()->json([
            //             'resultCode'            => -1,
            //             'message'               => 'Có tài khoản đã đăng nhập!',
            //             'data'                  => null
            //             ]);
            // }else{
            if ($user){
                if($user->user_role == 0 || $user->user_role == 1){
                    $user_point = $testRepository->getPointUser($user->user_id);
                    $array_user_point = array();
                    $array_test_id = array();
                    foreach ($user_point as $key) {
                        if (in_array($key->test_id , $array_test_id, true)){
                        }else{
                            $array_test_id[] = $key->test_id;
                            $array_user_point[] = $key->sum_total_right_answers+0;
                        }
                    }
                    $total_point_user = array_sum($array_user_point);
                    if (Hash::check($password, $user['password'])){
                        $user['api_token']  = str_random(60);
                        $create_api         = $userRepository->create_api_token($user['api_token'],$login_id);
                        $json               = $create_api->toArray();
                        foreach ($create_api as $key) {
                            if (!empty($key['avatar'])) {
                                if(File::exists(public_path('upload/image/avatar/') . $key['avatar'])){
                                    $file_image_url = url('/').'/upload/image/avatar/'.$key['avatar'];
                                    $key['file_avatar_url'] = $file_image_url;
                                    $key['total_point'] = $total_point_user;
                                }else{
                                    $key['file_avatar_url'] = '';
                                    $key['total_point'] = $total_point_user;
                                }
                            }else{
                                $key['file_avatar_url'] = '';
                                $key['total_point'] = $total_point_user;
                            }
                            $user_data[] = $key;
                        }
                        return response()->json([
                            'resultCode'        => 0,
                            'message'           => 'Login success!',
                            'data'              => $user_data,
                        ]);
                    }
                }
            }
            return response()->json([
                'resultCode'            => -1,
                'message'               => 'Login failed!',
                'data'                  => null
            ]);
            // }
        }
    }


    public function register(Request $request, UserRepository $userRepository)
    {

        $validator = Validator::make($request->all(),
            [
                'login_id'          => 'required|email|regex:/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/',
                'nick_name'         => 'required|min:6|max:30',
                'password'          => 'required|min:6|max:30',
                'phone_num'         => 'required|min:10|numeric',
                'password_confirm'  => 'required|min:6|max:30|same:password',
                'avatar'            => 'sometimes|image|max:4096',
            ],
            [
                'phone_num.required'          => 'Vui lòng nhập số điện thoại',
                'password.required'           => 'Vui lòng nhập mật khẩu',
                'password_confirm.required'   => 'Vui lòng xác nhận mật khẩu',
                'login_id.required'           => 'Vui lòng nhập email',
                'nick_name.required'          => 'Vui lòng tên người dùng',
                'login_id.email'              => 'Tên đăng nhập phải là email',
                'login_id.exists'             => 'Email này không tồn tại',
                'login_id.regex'              => 'Vui lòng nhập tên đăng nhập không chứa những kí hiệu đặc biệt',
                'avatar.image'                => 'Avatar phải là hình ảnh',
                'avatar.max'                  => 'Hình ảnh chọn phải nhỏ hơn 4MB',
                'avatar.uploaded'             => 'Vui lòng chọn đúng hình ảnh',
                'password_confirm.same'       => 'Nhập lại mật khẩu không đúng. Vui lòng nhập lại mật khẩu',
                'password.min'                => 'Mật khẩu có ít nhất 6 ký tự',
                'password.max'                => 'Mật khẩu có nhiều nhất 30 ký tự',
                'phone_num.required'          => 'Vui lòng nhập số điện thoại',
                'phone_num.min'               => 'Số điện thoại phải có ít nhất 10 số',
                'phone_num.max'               => 'Số điện thoại có nhiều nhất 30 số',
                'phone_num.numeric'           => 'Số điện thoại phải là số',
                'nick_name.max'               => 'Tên người dùng có nhiều nhất 30 ký tự',
                'nick_name.min'               => 'Tên người dùng có ít nhất 6 ký tự',

            ]);
        if ($validator->fails())
        {
            return response()->json([
                'resultCode'            => -1,
                'message'               => $validator->errors()->first(),
                'data'                  => null
            ]);
        }else{

            $data           = array_merge($request->all(),[
                'email'         => $request->get('login_id'),
                'updated_time'       => date("Y-m-d H:i:s"),
                'updated_user'       => 1,
                'created_user'      => 1,
                'created_time'      => date("Y-m-d H:i:s"),
                'deleted_flag'      => 0,
                'sns_id'        => null,
                'user_role'     => 0,
                'login_type'    => 1,
                'remain_coin'   => 0,
                'api_token'     => null,
            ]);

            $check = $userRepository->getLoginId();
            foreach ($check as $row) {
                foreach ($row as $key) {
                    $array_Login_id[]= $key;
                }
            }

            $login_id = $request->get('login_id');
            if (in_array($login_id, $array_Login_id,true))
            {
                return response()->json([
                    'resultCode'    => -1,
                    'message'       => 'Tên đăng nhập này đã tồn tại',
                    'data'          => null,
                ]);
            } else{
                if($request->privacy) {
                    $data['password']      = bcrypt($data['password']);
                    $user = $userRepository->registerUser($data);
                    $file = $request->file('avatar');
                    if(Input::hasfile('avatar'))
                    {
                        $nameImage = $user->user_id.".".date("H_i_s",time()).'.'.$file->getClientOriginalExtension();
                        $file->move('upload/image/avatar/',$nameImage);
                    } else
                    {
                        $nameImage = "default_avt.png";
                    }
                    $user = $userRepository->updateAvatar($nameImage,$user->user_id);

                    return response()->json([
                        'resultCode'=> 0,
                        'message'   => 'Đăng ký thành công!',
                        'data'      => $user
                    ]);
                } else {
                    return response()->json([
                        'resultCode'=> -1,
                        'message'   => 'Bạn chưa đồng ý với điều khoản sử dụng!',
                        'data'      => null
                    ]);
                }
            }

        }
    }

    public function editProfile(Request $request, UserRepository $userRepository, TestRepository $testRepository)
    {
        $user_id = $request->user_id;
        $api_token = $request->api_token;
        $check_api_token = $userRepository->check_API_token_Test($user_id);
        if ($check_api_token->api_token != $api_token) {
            return response()->json([
                'resultCode' => -1,
                'message' => 'Lỗi đăng nhập',
                'data' => null
            ]);
        } else {
            $validator = Validator::make($request->all(),
                [
                    'nick_name' => 'required',
                    'phone_num' => 'required',
//                     'avatar'            => 'required',
                ]);
            if ($validator->fails()) {
                return response()->json([
                    'resultCode'            => -1,
                    'message'               => 'Vui lòng nhập đủ thông tin!',
                    'data'                  => null
                ]);
            } else {

                $validator = Validator::make($request->all(),
                    [
                        'nick_name' => 'max:20',
                        'phone_num' => 'min:10|numeric',
                    ],
                    [
                        'phone_num.min' => 'Số điện thoại phải có ít nhất 10 số',
                        'phone_num.numeric' => 'Số điện thoại phải là số',
                        'nick_name.max' => 'Tên người dùng có nhiều nhất 20 ký tự',

                    ]);
                if ($validator->fails()) {

                    return response()->json([
                        'resultCode'            => -1,
                        'message'               => $validator->errors()->first(),
                        'data'                  => null
                    ]);
                } else {

                    $data = array(
                        'updated_time' => date('Y/m/d'),
                        'updated_user' => 1,
                        'nick_name' => $request->nick_name,
                        'phone_num' => $request->phone_num,
                    );

                    if($request->avatar != '') {
                        if($request->avatar_size > 2000000) {
                            return response()->json([
                                'resultCode'            => -1,
                                'message'               => 'Kích thước ảnh quá lớn, vui lòng chọn dưới 2Mb',
                                'data'                  => null
                            ]);
                        }else {
                            if($request->old_avatar != '') {
                                if(File::exists(public_path('upload/image/avatar/') . $request->old_avatar))
                                {
                                    unlink(public_path('upload/image/avatar/') . $request->old_avatar);
                                }
                            }
                            $image = base64_decode($request->avatar);
                            $image_name= $user_id.".".date("H_i_s",time()).".png";
                            $path = public_path() . "/upload/image/avatar/" . $image_name;

                            file_put_contents($path, $image);
                            $data['avatar'] = $image_name;
                        }
                    }


                    $check = $userRepository->getLoginId();
                    foreach ($check as $row) {
                        foreach ($row as $key) {
                            $array_Login_id[] = $key;
                        }
                    }

                    $result = $userRepository->getLoginIDForEdit($request->user_id);
                    $login_id = $result['login_id'];
                    if (in_array($login_id, $array_Login_id, true)) {
                        $user = $userRepository->editProfile($data, $login_id);

                        //get total_point
                        $user_point = $testRepository->getPointUser($user_id);
                        $array_user_point = array();
                        $array_test_id = array();
                        foreach ($user_point as $key) {
                            if (in_array($key->test_id , $array_test_id, true)){
                            }else{
                                $array_test_id[] = $key->test_id;
                                $array_user_point[] = $key->sum_total_right_answers+0;
                            }
                        }
                        $total_point_user = array_sum($array_user_point);
                        //

//                        return $data;
//
//                        $json[] = $data;
//                        unset($json['api_token']);
                        $user[0]['total_point'] = $total_point_user;
                        return response()->json([
                            'resultCode' => 0,
                            'message' => 'Cập nhật thành công!',
                            'data' => $user
                        ]);

                    } else {

                        return response()->json([
                            'resultCode' => -1,
                            'message' => 'Tên đăng nhập này chưa đăng kí',
                            'data' => null,
                        ]);
                    }

                }
            }
        }
    }

    public function CheckedIn(Request $request, UserRepository $userRepository, UserCheckedInRepository $userCheckedInRepository)
    {

        $user_id = $request->user_id;
        $api_token = $request->api_token;
        $action = $request->action;
        $earned_coin = $request->earned_coin;
        $check_api_token = $userRepository->check_API_token_Test($user_id);

        if ($check_api_token == null || $check_api_token->api_token != $api_token) {

            return response()->json([
                'resultCode' => -1,
                'message' => 'L?i dang nh?p',
                'data' => null
            ]);
        } else {

                $new_data = [
                    'action' => $action,
                    'user_id' => $user_id,
                    'related_id' => null,
                    'checkedin_time' => date("Y-m-d H:i:s"),
                    'earned_coin' => $earned_coin,
                    'updated_time' => date("Y-m-d H:i:s"),
                    'updated_user' => 1,
                    'created_user' => 1,
                    'created_time' => date("Y-m-d H:i:s"),
                    'deleted_flag' => 0,
                ];
                $new_checked = $userCheckedInRepository->newChecked($new_data);
                return response()->json([
                    'resultCode' => 0,
                    'message' => 'Điểm danh thành công',
                    'data' => $new_data
                ]);
        }
    }

    public function loginWithSocial(Request $request, UserRepository $userRepository)
    {
            $sns_id                 = $request->sns_id;
            $result                 = $userRepository->checkUserLoginSocial($sns_id);
            $api_token              = str_random(60);
            if(count($result) != 0)
            {
                $data_update        = [
                    'api_token'     => $api_token,
                    'updated_time'  => date("Y-m-d H:i:s"),
                ];
                $user               = $userRepository->updateUserSocial($data_update,$sns_id);
            }else{
                $file = $request->file('avatar');
                if(Input::hasfile('avatar'))
                { 
                    $nameImage = $request->nick_name.".".$file->getClientOriginalExtension();
                    $file->move('upload/avatar/',$nameImage);
                } else
                {
                    $nameImage = "default_avt.png";
                }
            $data_create            =   [ 
                    'email'         => $request->login_id,
                    'login_id'      => $request->login_id,
                    'nick_name'     => $request->nick_name,
                    'phone_num'     => $request->phone_num,
                    'password'      => null,
                    'updated_time'  => date("Y-m-d H:i:s"),
                    'updated_user'  => 1,
                    'created_user'  => 1,
                    'created_time'  => date("Y-m-d H:i:s"),
                    'deleted_flag'  => 0,
                    'sns_id'        => $sns_id,
                    'user_role'     => 0,
                    'login_type'    => 1,
                    'remain_coin'   => null,
                    'api_token'     => $api_token,
                    'avatar'        => $nameImage
                                    ];
                $user               = $userRepository->createUserSocial($data_create);
            }
            
            return response()->json([
                    'resultCode'=> 0,
                    'message'   => 'Đăng nhập thành công!',
                    'data'      => $user
                    ]);
    }

    public function refreshLogin(Request $request, UserRepository $userRepository)
    {

        $user_id = $request->user_id;
        $api_token = $request->api_token;
        $check_api_token = $userRepository->check_API_token_Test($user_id);
        if ($check_api_token == null || $check_api_token->api_token != $api_token) {
            return response()->json([
                'resultCode' => -1,
                'message' => 'Lỗi đăng nhập',
                'data' => null
            ]);
        } else {
                $new_data = [
                    'api_token' => $api_token,
                    'user_id' => $user_id,
                    'updated_time' => date("Y-m-d H:i:s"),
                    'updated_user' => 1,
                    'created_user' => 1,
                    'created_time' => date("Y-m-d H:i:s"),
                    'deleted_flag' => 0,
                ];
                $new_checked = $userRepository->refreshLogin($api_token,$user_id);
                return response()->json([
                    'resultCode' => 0,
                    'message' => 'Đăng nhập thành công',
                    'data' => $new_checked
                ]);
        }
    }
}
