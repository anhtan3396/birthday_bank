<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use App\Repositories\TestRepository;
use App\Repositories\BaseRepository;
use App\Repositories\QuizRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

class TestRankController extends Controller
{
    public function getTestRank(Request $request, TestRepository $testRepository, QuizRepository $quizRepository, UserRepository $userRepository)
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
        }else {
            $type = !isset($request->type) ? "m" : $request->type;
            $array_all_point = $testRepository->getPointAnswers($type);
            return response()->json([
                'resultCode' => 0,
                'message' => 'Bảng xếp hạng',
                'data' => $array_all_point
            ]);
        }
    }
}
