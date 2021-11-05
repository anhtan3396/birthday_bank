<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Models\MUser;
use App\Mail\ForgotPasswordAPI;
use App\Mail\ressetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ForgotController extends Controller
{
	public function forgotPassword(Request $request,UserRepository $userRepository)
	{
        $email = $request->email;
        $user = MUser::where("email", $email)->first();
        if (!$user) {
            return response()->json([
                'resultCode'        => -1,
                'message'           => 'Lỗi!',
                'data'              => null
                ]);
        }else{
            $nick_name = $user->nick_name;
            $login_type = $user->login_type;
            //var_dump($user);die();

            if($user->email != $email || $login_type == 2  || $login_type == 3 )
            {
                return response()->json([
                    'resultCode'        => -1,
                    'message'           => 'Lỗi!',
                    'data'              => null
                    ]);
            }
            else
            {
                $user  = $userRepository->findUser($email);
                if ($user != null) {
                    // thoi gian het han
                    $timeout = time() + (60 * 60); // 60p
            // tao hash truoc khi gui email
                    $hash = md5(time() . $email . rand(0,9999999));

            // save hash into db
                    $userRepository->update(
                        [
                        "request_password_hash"        => $hash,
                        "request_expired"              => $timeout
                        ], 
                        $user->user_id,
                        "user_id"
                        );
                    Mail::to($email)->send(new ForgotPasswordAPI($email,$hash,$nick_name, $timeout));

                    return response()->json([
                        'resultCode'        => 0,
                        'message'           => 'Phản hồi thành công!',
                        'data'              => null
                        ]);
                }
            }
        }
        
    }
    // public function ressetPass(Request $request,ForgotRepository $forgotRepository , UserRepository $userRepository)
    // {
    //     $user_id = $request->user_id;
    //     $token = $request->token;
    //     $password = $request->password;
    //     $api_token = $request->api_token;
    //     $check_api_token = $userRepository->check_API_token_Test($user_id);      
    //     $email = MUser::find((int) $user_id)->email;
    //     $user  = $userRepository->findUser($email);
    //     $check_mail_token = $userRepository->check_token_mail($token,$user_id);
    //     var_dump($check_mail_token);die();
    //     $validator = Validator::make($request->all(), 
    //         [
    //         'token'             =>'required',
    //         'password'          => 'required|min:6|regex:/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
    //         'password_confirm'  => 'required|min:6|max:30|same:password',
    //         ],
    //         [
    //         'token.required'    => 'Vui lòng nhập dãy mã bảo mật.', 
    //         'password.required' => 'Vui lòng nhập mật khẩu.',
    //         'password.min'      => 'Mật khẩu có tối thiểu 6 ký tự.',
    //         'password.regex'    => 'Mật khẩu buộc phải có kí tự in hoa, kí tự thường và số',
    //         'password_confirm.required'   => 'Vui lòng xác nhận mật khẩu',
    //         'password_confirm.same'       => 'Nhập lại mật khẩu không đúng. Vui lòng nhập lại mật khẩu',

    //         ]);
    //     if (count($check_mail_token) == 0 && $check_api_token->api_token != $api_token) {
    //         return response()->json([
    //             'resultCode' => -1,
    //             'message' => 'Lỗi !',
    //             'data' => null
    //             ]);
    //     }

    //     else{
    //         if ($validator->fails())
    //         {
    //             return $validator->errors()->first();
    //         }else{
    //             $userRepository->update(
    //                 [
    //                 "password"   =>Hash::make($request->get('password')),
    //                 ], 
    //                 $user->user_id,
    //                 "user_id"
    //                 );
    //             Mail::to($email)->send(new ressetPassword($email));
    //             return response()->json([
    //                 'resultCode'        => 0,
    //                 'message'           => 'Đổi mật khẩu thành công!',
    //                 'data'              => null
    //                 ]);
    //         }
    //     }
    // }       

}
