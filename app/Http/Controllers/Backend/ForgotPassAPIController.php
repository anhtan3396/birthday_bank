<?php

namespace App\Http\Controllers\Backend;

use App\Models\MUser;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Mail\ForgotPass;
use Illuminate\Support\Facades\Hash;
use App\Utils\SessionManager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPassAPIController extends Controller
{
    public function forgotPassword($email, $hash, UserRepository $userRepository){
        if (empty($email) || empty($hash))
            return view('Backend.forgotPasswordAPI.fail_forgot');

        // kiem tra hash
        $user = $userRepository->findUser($email);
        if($user && $user->request_password_hash == $hash )
        {
            // kiem tra neu hash con thoi gian
            if ($user->request_expired > time())
                return view('Backend.forgotPasswordAPI.editPass');
            else
                return view('Backend.forgotPasswordAPI.fail_forgot');
        }       
        else {
            return view('Backend.forgotPasswordAPI.fail_forgot');
        }   
    }
   

    public function updatePassword(Request $request,UserRepository $userRepository )
    {
        $email = $request->segment(2);
        $user = $userRepository->findUser($email);
        if($user != null)
        {
            $validator = Validator::make($request->all(), 
                [
                
                'password'               => 'required|min:6|regex:/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/|confirmed',
                ],
                [
                    
                    'password.min'      => 'Mật khẩu có tối thiểu 6 ký tự.',
                    'password.regex'    => 'Mật khẩu buộc phải có kí tự in hoa, kí tự thường và số',
                    'password.confirmed'=> 'Nhập lại mật khẩu không đúng. Vui lòng nhập lại mật khẩu',
                    'password.required'  => 'Vui lòng nhập mật khẩu mới.',
                ]);

            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else
            {
                $userRepository->update(
                    [
                        "password"   =>Hash::make($request->get('password')),
                        "request_password_hash"        => "",
                        "request_expired"              => 0
                    ], 
                    $user->user_id,
                    "user_id"
                    );
                
                return view('Backend.forgotPasswordAPI.thank_forgot');
            }
        }else
        {
            return redirect()->back()->withErrors(['forgotPassword' => "Tài khoản không tồn tại"])->withInput();
        }
    }  


}