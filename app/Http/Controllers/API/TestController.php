<?php

namespace App\Http\Controllers\API;

use App\Models\MUser;
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

class TestController extends Controller
{
    public function getTestQuestions(Request $request, TestRepository $testRepository, QuizRepository $quizRepository, UserRepository $userRepository)
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
            $quiz_group = $request->quiz_group;
            $test_id = $request->test_id;
            $testQuiz = $testRepository->getFromTestQuiz($test_id, $quiz_group); //lấy dữ liệu dữa theo test_id,quiz_group
            if (count($testQuiz) !=0 ) {
                foreach ($testQuiz as $row) {
                        $array_Quiz_id[] = $row->quiz_id;// mảng chứa quiz_id
                }
                $testData = $testRepository->getTestData($test_id);//lấy mảng dữ liệu bài test
                if (count($testData) == 0) {
                return response()->json(
	                ['resultCode' => -1, //Trả về dữ liệu kết quả
	                    'Message' => 'Test not found',
	                    'data' => null
	                ]);
	            }else{
			           	$quizData = $quizRepository->getFromQuiz($array_Quiz_id);//lấy mảng dữ liệu dựa vào mảng quiz_id
		                foreach ($quizData as $key) {
		                    if (!empty($key['image'])) {
		                        if(File::exists(public_path('upload/image/quiz/') . $key['image']))
		                            {
		                                $file_image_url = url('/').'/upload/image/quiz/'.$key['image'];
		                                $key['file_image_url'] = $file_image_url;
		                            }else{
		                                $key['file_image_url'] = '';
		                        }
		                    }else{
		                                $key['file_image_url'] = '';
		                    }
		                    if (!empty($key['sound'])) {
		                        if(File::exists(public_path('upload/audio/quiz/') . $key['sound']))
		                            {
		                                $file_sound_url = url('/').'/upload/audio/quiz/' . $key['sound'];
		                                $key['file_sound_url'] = $file_sound_url;
		                            }else{
		                                $key['file_sound_url'] = '';
		                        }
		                    }else{
		                                $key['file_sound_url'] = '';
		                    }
		                    
		                    $lastQuizData[] = $key;
		                }
		                foreach ($testData as $key) {
		                    $key['ListQuestion'] = $lastQuizData;  //Chèn mảng dữ liệu của các câu hỏi vào bài test
		                }
		                $data = ['resultCode' => 0, //Trả về dữ liệu kết quả
		                    'Message' => 'Test infomation',
		                    'data' => $key
		                ];
		                return response()->json($data);
		            }

	            }
	            	return response()->json(
		                ['resultCode' => -1, //Trả về dữ liệu kết quả
		                    'Message' => 'Test not found',
		                    'data' => null
		                ]);
        }
    }
    public function getListTest(Request $request, TestRepository $testRepository, UserRepository $userRepository)
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
            $user_id = $request->user_id;
            $test_type_id = $request->test_type_id;
            $test_level_id = $request->test_level_id;
            if ($user_id && $test_type_id && $test_level_id) {
                $listTest = $testRepository->getAllTests($test_type_id, $test_level_id);//lay danh sach bai test
                foreach ($listTest as &$test) {
                    $ans = $testRepository->getPointToAnswers($test['test_id'], $user_id);//lấy số đáp án lớn nhất theo test_id

                    $total_right_answer = 0;
                    $goi_tested = false;
                    $dokkai_tested = false;
                    $choikai_tested = false;
                              
                    foreach ($ans as $row) {

                    
                        
                        $total_right_answer += $row['total_right_answers_goi'] + $row['total_right_answers_dokkai'] + $row['total_right_answers_choikai'];
                        if ($row['total_question_goi'] > 0) {
                            $goi_tested = true;
                        }
                        if ($row['total_question_dokkai'] > 0) {
                            $dokkai_tested = true;
                        }
                        if ($row['total_question_choikai'] > 0) {
                            $choikai_tested = true;
                        }
                    
                }

                    //hiển thị tested: nếu đã làm tested = true, ngược lại là false
                    $test['goi_tested'] = $goi_tested;
                    $test['dokkai_tested'] = $dokkai_tested;
                    $test['choikai_tested'] = $choikai_tested;

                    $test['test_total_right_answer'] = $total_right_answer;//theo cấu trúc đưa sẵn, hiển thị ra số câu trả lời cao nhất

                    //kiểm tra bài test đã làm chưa
                    count($ans) > 0 ? $tested = true : $tested = false;
                    $test["tested"] = $tested;//hiển thị tested: nếu đã làm tested = true, ngược lại là false

                    //lay tong so cau hoi
                    $allTestQuiz = $testRepository->getAllTestQuiz($test['test_id']);
                    $test["test_total_quiz"] = count($allTestQuiz);//đếm số câu hỏi query
                }
                $data = [
                    'resultCode' => 0,
                    'Message' => 'Thành công!',
                    'data' => $listTest
                ];
            } else {
                $data = [
                    'resultCode' => -1,
                    'Message' => 'Thất bại!',
                    'data' => null
                ];

            }
            return response()->json($data);
        }
    }

    /* public function getListTest(Request $request, TestRepository $testRepository, UserRepository $userRepository)
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
             $user_id = $request->user_id;
             $test_type_id = $request->test_type_id;
             $test_level_id = $request->test_level_id;
            
             if ($user_id && $test_type_id && $test_level_id) {
                 $listTest = $testRepository->getAllTests($test_type_id, $test_level_id);//lay danh sach bai test

                 foreach ($listTest as &$test) {
                     $ans = $testRepository->getPointToAnswers($test['test_id'], $user_id);//lấy số đáp án lớn nhất theo test_id

                     $total_right_answer = 0;
                     $max_total = 0;
                     $goi_tested = false;
                     $dokkai_tested = false;
                     $choikai_tested = false;
                     $complete_flag = true;
                     foreach ($ans as $row) {
                         if($row['complete_flag'] != 1) {
                             if ($row['total_question_goi'] > 0) {
                                 $goi_tested = true;
                             }
                             if ($row['total_question_dokkai'] > 0) {
                                 $dokkai_tested = true;
                             }
                             if ($row['total_question_choikai'] > 0) {
                                 $choikai_tested = true;
                             }
                             $max_total += $row['total_right_answers_goi'] + $row['total_right_answers_dokkai'] + $row['total_right_answers_choikai'];
                            
                         }else{
                             $total_right_answer += $row['total_right_answers_goi'] + $row['total_right_answers_dokkai'] + $row['total_right_answers_choikai'];
                             if($max_total < $total_right_answer){
                                 $max_total = $total_right_answer;
                                 $complete_flag = false;
                             }
                            
                         }
                     }

                     //hiển thị tested: nếu đã làm tested = true, ngược lại là false
                     $test['goi_tested'] = $goi_tested;
                     $test['dokkai_tested'] = $dokkai_tested;
                     $test['choikai_tested'] = $choikai_tested;

                     $test['test_total_right_answer'] = $max_total;//theo cấu trúc đưa sẵn, hiển thị ra số câu trả lời cao nhất

                     //kiểm tra bài test đã làm chưa
                     count($ans) > 0 ? $tested = true : $tested = false;
                     $test["tested"] = $tested;//hiển thị tested: nếu đã làm tested = true, ngược lại là false
                     //hiển thị bài đã làm hết chưa
                     $test["complete_flag"] = $complete_flag;
                     //lay tong so cau hoi
                     $allTestQuiz = $testRepository->getAllTestQuiz($test['test_id']);
                     $test["test_total_quiz"] = count($allTestQuiz);//đếm số câu hỏi query
                 }
            

             $data = [
             'resultCode' => 0,
             'Message' => 'Thành công!',
             'data' => $listTest
             ];
         } else {
             $data = [
             'resultCode' => -1,
             'Message' => 'Thất bại!',
             'data' => null
             ];

             }
         return response()->json($data);
         }
     }*/

    public function getScore(Request $request, TestRepository $testRepository, QuizRepository $quizRepository, UserRepository $userRepository)
    {
        $user_id = $request->user_id;
        $api_token = $request->api_token;
        $check_api_token = $userRepository->check_API_token_Test($user_id);
        // var_dump($check_api_token);die();
        if ($check_api_token == null || $check_api_token->api_token != $api_token) {
            return response()->json([
                'resultCode' => -1,
                'message' => 'Lỗi đăng nhập',
                'data' => null
            ]);
        } else {
            $test_id = $request->test_id; //lấy $test_id từ $request
            $quiz_group = $request->quiz_group; //lấy $test_id từ $request
            $total_question = $request->total_question; //lấy $test_id từ $request
            $user_do = $request->userDo;  //lấy $user_do từ $request
            $check_test_id = $testRepository->checkTestId(); //lấy mảng test_id từ database
            foreach ($check_test_id as $checked) {
                foreach ($checked as $value_id) {
                    $array_check_id[] = $value_id;
                }
            }
            $array_check_id = array_values(array_unique($array_check_id));
            if (in_array($test_id, $array_check_id, true)) //kiểm tra xem test_id có tồn tại ở database hay không
            {
                if ($user_do) {
                    $result_Quiz_id = $testRepository->getArrayQuizId($test_id, $quiz_group);  //lấy mảng quiz_id trong cùng một bài test
                    foreach ($result_Quiz_id as $quiz) {
                        foreach ($quiz as $key => $value) {
                            $array_Quiz_id[] = $value;
                        }
                    }
                    $resutl_answer = $quizRepository->getIdRightAns($array_Quiz_id); //lấy đáp án từ database

                    $array_AnswerRight = array();
                    foreach ($user_do as $Quiz_user) {
                        foreach ($resutl_answer as $Quiz_data) {
                            if ($Quiz_user['quiz_id'] == $Quiz_data['quiz_id'] && $Quiz_user['answer'] == $Quiz_data['right_ans']) {
                                $array_AnswerRight[] = $Quiz_data['quiz_id']; //mảng chứa quiz_id của các câu có đáp án đúng
                            }
                        }
                    }
                    $total_Answer_Right = count($array_AnswerRight); //đếm số lượng đáp án đúng
                    $user_test_score_data = array(
                        'user_id' => $user_id,
                        'test_id' => $test_id,
                        'test_date' => date('Y-m-d h:i:s'),
                        'total_play_time' => 30,
                        'deleted_flag' => 0,
                        'created_user' => 1,
                        'created_time' => date('Y-m-d h:i:s'),
                        'updated_user' => 1,
                        'updated_time' => date('Y-m-d h:i:s'),
                    );
                    $user_completed = $testRepository->userCompleteTest($user_id,$test_id);
                    if (count($user_completed)!= 0) {
                        unset($user_test_score_data['created_user'],$user_test_score_data['created_time']);
                        $user_update = $testRepository->userTestScoreUpdate($quiz_group,$test_id, $user_test_score_data, $total_Answer_Right, $total_question,$user_id);
                    }else{
                        $user_create = $testRepository->userTestScoreCreate($quiz_group, $user_test_score_data, $total_Answer_Right, $total_question);
                    }
                    $data = [
                        'ketqua' => 0,
                        'Message' => 'Chấm điểm thành công',
                        'data' => [
                            'totalRightAnswer' => $total_Answer_Right,
                            'rightAnswerID' => $array_AnswerRight
                        ]
                    ];
                    return response()->json($data); //trả về dữ liệu
                } else { //nếu test_id không tồn tại thì trả về dữ liệu = null
                    $data = [
                        'ketqua' => -1,
                        'Message' => 'Test not found',
                        'data' => null
                    ];
                    return response()->json($data);
                }
            } else {
                $data = [
                    'ketqua' => -1,
                    'Message' => 'Test not found',
                    'data' => null
                ];
                return response()->json($data);
            }
        }
    }

    public function refreshTest(Request $request, TestRepository $testRepository, UserRepository $userRepository)
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
            $test_id = $request->test_id;
            $status = $testRepository->refeshTestOfUser($user_id, $test_id);

            if($status == 1) {
                return response()->json([
                    'resultCode' => 0,
                    'message' => 'Cập nhật điểm thành công',
                    'data' => null
                ]);
            } else {
                return response()->json([
                    'resultCode' => -1,
                    'message' => 'Cập  nhật điểm thất bại',
                    'data' => null
                ]);
            }
        }
    }
}

