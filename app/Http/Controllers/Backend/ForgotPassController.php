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

class ForgotPassController extends Controller
{
    public function index(){
    	return view('Backend.resetPassword.mail');
    }

    public function sendMail(Request $request, UserRepository $userRepository)
    {
        $email = $request->get('email');
        $user  = $userRepository->findUser($email);

        if ($user) {
            $nick_name = $user->nick_name;
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
            //Send mail
                    Mail::to($email)->send(new ForgotPass($email,$hash,$nick_name, $timeout));
                    return redirect('/');
                }
                else{
                    return redirect()->back()->withErrors(['error' => "Xin lỗi chúng tôi không tìm được email của bạn!"])->withInput();
                } 
            }
            public function resetPassword($email, $hash, UserRepository $userRepository){
                if (empty($email) || empty($hash))
                    return redirect("/login");

        // kiem tra hash
                $user = $userRepository->findUser($email);
                if($user && $user->request_password_hash == $hash)
                {

                    if ($user->request_expired > time()){
                        return view('Backend.resetPassword.editPassword');
                    }
                    else
                        return redirect("/login");
                }       
                else {
                    return redirect("/login");
                } 
            }


            public function updatePass(Request $request,UserRepository $userRepository )
            {
                $email = $request->get('email');
                $user = $userRepository->findUser($email);
                if($user != null)
                {
                    $validator = Validator::make($request->all(), 
                        [
                        'email'                  => 'required|email|regex:/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/',
                        'password'               => 'required|min:6|regex:/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/|confirmed',
                        ],
                        [
                        'email.required'    => 'Vui lòng nhập email của bạn.',
                        'email.regex'       => 'Vui lòng nhập email không chứa những kí hiệu đặc biệt',
                        'password.min'      => 'Mật khẩu có tối thiểu 6 ký tự.',
                        'password.regex'    => 'Mật khẩu buộc phải có kí tự in hoa, kí tự thường và số',
                        'password.confirmed'=> 'Nhập lại mật khẩu không đúng. Vui lòng nhập lại mật khẩu',
                        'password.require'  => 'Vui lòng nhập mật khẩu để đăng nhập.',
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
                        return redirect('/');
                    }
                }else
                {
                    return redirect()->back()->withErrors(['resetPassword' => "Tài khoản không tồn tại"])->withInput();
                }
            }


        }