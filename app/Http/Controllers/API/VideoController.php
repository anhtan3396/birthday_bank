<?php

namespace App\Http\Controllers\API;

use App\Models\MUser;
use App\Models\MVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Repositories\VideoRepository;
class VideoController extends Controller
{  
	public function getListVideo(Request $request,VideoRepository $videoRepository , UserRepository $userRepository)
	{
		$user_id = $request->user_id;
		$api_token = $request->api_token;
		$check_api_token = $userRepository->check_API_token_Test($user_id);
				// var_dump($check_api_token->api_token);die();

		if ($check_api_token->api_token != $api_token) {
			return response()->json([
				'resultCode' => -1,
				'message' => 'Lỗi đăng nhập',
				'data' => null
				]);
		}else {
			//$listVideo = $videoRepository->getVideoToUserId();
			//$video_path = $videoRepository->getVideoPath();
			// foreach($listVideo as $vid)
			// {
			// 	preg_match('/(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=‌​(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+/', $vid->video_path, $matches);
			// 	if($matches == null){
			// 		$update = $videoRepository->updateDeletedFlag($vid->video_id);
			// 	}
				
			// }
			
			$res = $videoRepository->getVideoToUserId();
			return response()->json([
				'resultCode'        => 0,
				'message'           => 'Phản hồi thành công!',
				'data'              => $res
				]);
		}
	}
	public function searchVideo(Request $request,VideoRepository $videoRepository , UserRepository $userRepository)
	{
		$user_id = $request->user_id;
		$api_token = $request->api_token;
		$video_title = $request->video_title;
		$check_api_token = $userRepository->check_API_token_Test($user_id);
		if ($check_api_token->api_token != $api_token) {
			return response()->json([
				'resultCode' => -1,
				'message' => 'Lỗi đăng nhập',
				'data' => null
				]);
		}else {
			$video = $videoRepository->getVideoToUserId();
			$search = $videoRepository->searchVideo($video_title);
			var_dump($search);die();
			return response()->json([
				'resultCode'        => 0,
				'message'           => 'Phản hồi thành công!',
				'data'              => $video
				]);
		}
	}
}