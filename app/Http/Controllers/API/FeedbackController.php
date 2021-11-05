<?php

namespace App\Http\Controllers\API;

use App\User;
use App\MFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use App\Repositories\UserRepository;
use App\Repositories\FeedbackRepository;
use Illuminate\Support\Facades\File;

class FeedbackController extends Controller
{  
    public function getListFeedback(Request $request,FeedbackRepository $feedbackRepository , UserRepository $userRepository)
    {
        $user_id = $request->user_id;
        $api_token = $request->api_token;
        $content = $request->content;

        $check_api_token = $userRepository->check_API_token_Test($user_id);
        if ($check_api_token->api_token != $api_token) 
        {
            return response()->json([
                'resultCode' => -1,
                'message' => 'Lỗi đăng nhập',
                'data' => null
                ]);
        }
        else 
        {   
            $email = $userRepository->getEmail($user_id);
            foreach ($email as $key ) {
             $fmail = $key;
            }
             $updated_time   = date('Y-m-d h:i:s');
             $updated_user   = 1;
             $created_user   = 1;
             $created_time   = date('Y-m-d h:i:s');
             $deleted_flag   = 0;
             $data           = array_merge($request->all(),[
                'deleted_flag'   => $deleted_flag,
                'created_user'   => $created_user,
                'created_time'   => $created_time,
                'updated_user'   => $updated_user, 
                'updated_time'   => $updated_time,

                ]);

             $mail = $feedbackRepository->insertMail($data);
             $result = array_merge($data,$fmail);
             unset($result['api_token']);
             if ($mail) {
                return response()->json([
                    'resultCode'        => 0,
                    'message'           => 'Phản hồi thành công!',
                    'data'              => $result
                    ]);
            }
            else{
                return response()->json([
                    'resultCode'        => -1,
                    'message'           => 'Phản hồi thất bại!',
                    'data'              => null
                    ]);
            } 
        }
    }

}
