<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MUser;
use App\Models\MVideo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Schema\Blueprint;
use App\Repositories\UserRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\TestRepository;
use App\Repositories\VideoRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function purchaseVideo(Request $request, VideoRepository $videoRepository, UserRepository $userRepository, PurchaseRepository $purchaseRepository)
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
            $data = array(
                'user_id'            => $user_id,
                'purchase_item_type' => $request->purchase_item_type,
                'purchase_item_id'   => $request->purchase_item_id,
                'purchase_coin'      => $request->purchase_coin,
                'purchase_time'      => date('Y-m-d h:i:s'),
                'deleted_flag'       => 0,
                'created_user'       => 1,
                'created_time'       => date('Y-m-d h:i:s'),
                'updated_user'       => 1,
                'updated_time'       => date('Y-m-d h:i:s'),
            );
            $insert_status = $purchaseRepository->createPurchase($data);
            if($insert_status) {
                return response()->json([
                    'resultCode' => 0,
                    'message' => 'Mua video thành công!',
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'resultCode' => -1,
                    'message' => 'Mua video thất bại!',
                    'data' => null
                ]);
            }

        }
    }

    public function purchaseTest(Request $request, TestRepository $testRepository, UserRepository $userRepository, PurchaseRepository $purchaseRepository)
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
            $data = array();
            return response()->json([
                'resultCode' => 0,
                'message' => 'Mua bài test thành công!',
                'data' => $data
            ]);
        }
    }
}