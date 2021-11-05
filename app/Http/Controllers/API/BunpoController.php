<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use App\Repositories\UserRepository;
use App\Repositories\BunpoRepository;

use DateTime;
use Illuminate\Support\Facades\File;


class BunpoController extends Controller
{
    public function getListBunpo(Request $request, UserRepository $userRepository, BunpoRepository $bunpoRepository)
    {
        $user_id = $request->user_id;
        $api_token = $request->api_token;
//        return $user_id;
        $check_api_token = $userRepository->check_API_token_Test($user_id);
        if ($check_api_token == null || $check_api_token->api_token != $api_token)
        {
            return response()->json([
                'resultCode' => -1,
                'message' => 'Lỗi đăng nhập',
                'data' => null
            ]);
        }else
        {

            if ($request->is_n1 == 1) {
                $level = 'is_n1';

            }
            elseif ($request->is_n2 == 1) {
                $level = 'is_n2';

            }
            elseif ($request->is_n3 == 1) {
                $level = 'is_n3';

            }
            elseif ($request->is_n4 == 1) {
                $level = 'is_n4';

            }
            elseif ($request->is_n5 == 1) {
                $level = 'is_n5';

            }
            if ($request->is_type_practice == 1) {
                $type = 'is_type_practice';

            }
            elseif ($request->is_type_test == 1) {
                $type = 'is_type_test';

            }

            $result_List  = $bunpoRepository->getListBunpo($level,$type);
            if ($result_List == null) {
                return response()->json([
                    'resultCode' => -1,
                    'message' => 'Không tìm được dữ liệu',
                    'data' => null
                ]);
            }
            foreach ($result_List as $key) {
                if (!empty($key['image'])) {
                    if(File::exists(public_path('upload/image/bunpo/') . $key['image']))
                    {
                        $file_image_url = url('/').'/upload/image/bunpo/'. $key['image'];
                        $key['file_image_url'] = $file_image_url;
                    }else{
                        $key['file_image_url'] = '';
                    }
                }else{
                    $key['file_image_url'] = '';
                }
                if (!empty($key['sound'])) {
                    if(File::exists(public_path('upload/audio/bunpo/') . $key['sound']))
                    {
                        $file_sound_url = url('/').'/upload/audio/bunpo/' . $key['sound'];
                        $key['file_sound_url'] = $file_sound_url;
                    }else{
                        $key['file_sound_url'] = '';
                    }
                }else{
                    $key['file_sound_url'] = '';
                }
                $lastBunpodata[] = $key;
            }
            return $json = [	'resultCode' 	=> 0,
                'Message'		=> 'Data List Bunpo',
                'data'			=>$lastBunpodata

            ];
        }
    }

        public function searchBunpo(Request $request, UserRepository $userRepository, BunpoRepository $bunpoRepository)
    {
        $user_id = $request->user_id;
        $api_token = $request->api_token;
        $bunpo_key = $request->bunpo_key;
        $check_api_token = $userRepository->check_API_token_Test($user_id);
        if ($check_api_token == null || $check_api_token->api_token != $api_token)
        {
            return response()->json([
                'resultCode' => -1,
                'message' => 'Lỗi đăng nhập',
                'data' => null
            ]);
        }else
        {

            if ($request->is_n1 == 1) {
                $level = 'is_n1';

            }
            elseif ($request->is_n2 == 1) {
                $level = 'is_n2';

            }
            elseif ($request->is_n3 == 1) {
                $level = 'is_n3';

            }
            elseif ($request->is_n4 == 1) {
                $level = 'is_n4';

            }
            elseif ($request->is_n5 == 1) {
                $level = 'is_n5';

            }
            if ($request->is_type_practice == 1) {
                $type = 'is_type_practice';

            }
            elseif ($request->is_type_test == 1) {
                $type = 'is_type_test';

            }
            // var_dump($bunpo_key);die();
            $result_List  = $bunpoRepository->searchBunpo($level,$type,$bunpo_key);
            if ($result_List == null) {
                return response()->json([
                    'resultCode' => -1,
                    'message' => 'Không tìm được dữ liệu',
                    'data' => null
                ]);
            }
            foreach ($result_List as $key) {
                if (!empty($key['image'])) {
                    if(File::exists(public_path('upload/image/bunpo/') . $key['image']))
                    {
                        $file_image_url = url('/').'/upload/image/bunpo/'. $key['image'];
                        $key['file_image_url'] = $file_image_url;
                    }else{
                        $key['file_image_url'] = '';
                    }
                }else{
                    $key['file_image_url'] = '';
                }
                if (!empty($key['sound'])) {
                    if(File::exists(public_path('upload/audio/bunpo/') . $key['sound']))
                    {
                        $file_sound_url = url('/').'/upload/audio/bunpo/' . $key['sound'];
                        $key['file_sound_url'] = $file_sound_url;
                    }else{
                        $key['file_sound_url'] = '';
                    }
                }else{
                    $key['file_sound_url'] = '';
                }
                $lastBunpodata[] = $key;
            }
            return $json = [    'resultCode'    => 0,
                'Message'       => 'Data List Bunpo',
                'data'          =>$lastBunpodata

            ];
        }
    }
}
    // public function updateBunpo(Request $request, UserRepository $userRepository, BunpoRepository $bunpoRepository)
    // {
    //     $user_id 			= $request->user_id;
    //     $api_token 			= $request->api_token;
    //     $bunpo_id 			= $request->bunpo_id;
    //  $bunpo_type 		= $request->bunpo_type;
    //  $bunpo_level_id 	= $request->bunpo_level_id;
    //     $check_api_token 	= $userRepository->check_API_token_Test($user_id);
    //     if ($check_api_token->api_token != $api_token)
    //     {
    //         return response()->json([
    //         'resultCode' 	=> -1,
    //         'message' 		=> 'Lỗi đăng nhập',
    //         'data' 			=> null
    //         ]);
    //     }else
    //     {
    //     	$list_bunpo_id = $bunpoRepository->getAllDataUserBunpo($user_id,$bunpo_id,$bunpo_type,$bunpo_level_id);
    //     	if (count($list_bunpo_id) > 0) {
    //     		// Update

    //      	foreach ($list_bunpo_id as $row ) {
    //      			$array_bunpo_id[]= $row['bunpo_id'];
    //      			$array_bunpo_type[]= $row['bunpo_type'];
    //      			$array_bunpo_level_id[]= $row['bunpo_level_id'];
    //          }

    //      	if (in_array($bunpo_id+0, array_unique($array_bunpo_id),true) && in_array($bunpo_type+0, array_unique($array_bunpo_type),true) && in_array($bunpo_level_id+0, array_unique($array_bunpo_level_id),true)){
    //      		$result_count 		= $bunpoRepository->getCount($bunpo_id,$user_id);
    //      		$practice_count 	= $result_count['practice_count'] + 1;
    //      		$date 				= date("Y-m-d H:i:s");
    //      		$data_update 		= [
    //      				'user_id' 			=> $user_id,
    //      				'bunpo_id' 			=> $bunpo_id,
    //      				'bunpo_type_id' 	=> $bunpo_type,
    // 						'bunpo_level_id'	=> $bunpo_level_id,
    //      				'practice_count' 	=> $practice_count,
    //      				'practice_time'		=> $date
    //      		];

    //      		$bunpo_user_update = $bunpoRepository->updateCountTime($data_update);

    //      		if ($bunpo_user_update) {
    //             return response()->json([
    //             'resultCode' 		=> 0,
    //             'message' 			=> 'Update success',
    //             'data' 				=> $data_update
    //             ]);
    //         }
    //     else{
    //     		return response()->json([
    //             'resultCode' 		=> -1,
    //             'message' 			=> 'Update failed',
    //             'data' 				=> null
    //             ]);
    //         }
    //      	}
    //     	}
    //     	// Create
    // 		$data_create 		= [
    // 				'deleted_flag'		=> 0,
    // 				'bunpo_id' 			=> $bunpo_id,
    // 				'user_id' 			=> $user_id,
    // 				'bunpo_type' 	    => $bunpo_type,
    // 				'bunpo_level_id'	=> $bunpo_level_id,
    // 				'practice_count' 	=> 1,
    // 				'practice_time'		=> date("Y-m-d H:i:s")
    // 		];

    // 		$bunpo_user_create = $bunpoRepository->createUserBunpo($data_create);

    // 		if ($bunpo_user_create) {
    //           return response()->json([
    //           'resultCode' 		=> 0,
    //           'message' 			=> 'Created success',
    //           'data' 				=> $data_create
    //           ]);
    //   }
    //   else{
    //   		return response()->json([
    //           'resultCode' 		=> -1,
    //           'message' 			=> 'Created failed',
    //           'data' 				=> null
    //           ]);
    //   }
    //     }
    // }

