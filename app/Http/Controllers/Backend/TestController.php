<?php
namespace App\Http\Controllers\Backend;

use App\Models\MTest;
use Illuminate\Http\Request;
use App\Repositories\TestRepository;
use App\Repositories\QuizRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use DateTime;

class TestController extends Controller
{
    public function index(Request $request, TestRepository $testRepository)
    {
        $textSerachTest = $request->input('textinput');
        $levels = $request->input('levels');
        $types = $request->input('types');
        $date_f = $request->get('date-f');
        $date_t = $request->get('date-t');
       

        $search_query = MTest::query();
        if($textSerachTest)
        {
            $search_query->Where('test_name', 'like', '%'.$textSerachTest.'%');
        }
            
        if(count($levels) > 0)
        {
            $search_query->WhereIn('test_level_id', $levels);   
        }

        if(count($types) > 0 )
        {
            $search_query->WhereIn('test_type_id', $types);   
        }

        if($date_f)
        {
            if($date_t)
            {
                $search_query->whereDate('created_time', '<=', $date_t);
                $search_query->whereDate('created_time', '>=', $date_f) ;
            }else
            {
                $dayAfter = (new DateTime($date_f.' 23:59:59'))->modify('-1 day')->format('Y-m-d H:i:s');
                // echo $dayAfter; die();
                $dayBefore = (new DateTime($date_f.' 00:00:00'))->modify('+1 day')->format('Y-m-d H:i:s');
    
                $search_query->where('created_time', '>=', $dayAfter);   
                $search_query->where('created_time', '<=', $dayBefore);
            }
        }

        
        $tests = $testRepository->getAllTestsInDB($search_query);
        return view("Backend.test.list",
        [
            'tests' => $tests,
            'textInput' => $textSerachTest, 
            'oldLevels' => $levels,
            'oldTypes'  => $types,
            'oldDate_t' => $date_t,
            'oldDate_f' => $date_f
            
        ]);
    }

    public function create(Request $request)
    {
        return view('Backend.test.input');
    }

    public function edit(Request $request, TestRepository $testRepository)
    {
        return view('Backend.test.input');
    }

    //destroy a test
    public function destroyTest($id, TestRepository $testRepository)
    {
        //update delete_flag
        $testRepository->update(
            [
                "deleted_flag"          => 1, 
            ],
            $id,
            "test_id"
        );
        return redirect()->back();
    }

    //delete multi test
    public function deleteall(Request $rq, TestRepository $testRepository) 
    {
        //get list quiz choosed 
        $list_id = $rq->get('list_id');
        foreach ($list_id as $id) {
            //update delete_flag
            $testRepository->update(
                [
                    "deleted_flag"          => 1,
                    
                ],
                $id,
                "test_id"
            );
        }
        return redirect()->back();
    }

    public function checkValidationMondai(Request $request) {
        $validator = Validator::make(
            [
                'mondaiName'              => $request->input('name'),
                'mondaiDescription'       => $request->input('description')
            ]
            ,
            [
                'mondaiName'              => 'required|max:5',
                'mondaiDescription'       => 'max:500'
            ]
            , [
                'mondaiName.required'     => "Vui lòng nhập tên mondai.",
                'mondaiName.max'          => "Tên mondai chỉ cho phép nhập tối đa :max ký tự.",
                'mondaiDescription.max'   => "Mô tả chỉ cho phép nhập tối đa :max ký tự.",
            ]
        );
        if($validator->fails()) {
            return response()->json(
                [
                    'resultCode'    => -1,
                    'messages'      => $validator->errors()->get("*")
                ]
            );     
        }
        return response()->json(
            [
                'resultCode'    => 0
            ]
        );  
    }
    
    private function checkValidationTestData($data) {
        $validator = Validator::make(
            [
                'testName'              => $data['name'],
                'testDescription'       => $data['description'],
                'testPrice'            => $data['price'],
            ]
            ,
            [
                'testName'              => 'required|max:254',
                'testDescription'       => 'max:255',
                'testPrice'            => 'required|numeric',
            ]
            , [
                'testName.required'         => "Vui lòng nhập tên bài Test.",
                'testName.required'         => "Vui lòng nhập tên bài Test.",
                'testImageIcon.required'    => "Vui lòng chọn hình ảnh cho bài kiểm tra.",
                'imageData.max'             => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
                'testDescription.max'       => "Mô tả chỉ cho phép nhập tối đa :max ký tự.",
                'testPrice.required'       => "Vui lòng nhập số xu cho bài Test.",
                'testPrice.numeric'        => "Vui lòng nhập số cho trường này.",
            ]
        );
        $messageErrors =  [];
        if(!isset($data["testImageIconFileName"]) || empty($data["testImageIconFileName"])) {
            $messageErrors["testImageIcon"] = "Vui lòng chọn hình ảnh cho bài kiểm tra.";
        } else {
            // TODO: check file size
        }
        foreach($data["groups"] as $group)
        {
            $mondais    = $group["mondais"];
            if(isset($mondais) && count($mondais) > 0) {
                foreach ($mondais as $mondai)
                {
                    if(isset($mondai["quests"]) && count($mondai["quests"]) <= 0) {
                        $messageErrors['mondai_'.$group["id"].'_'.$mondai["id"]] = "Vui lòng thêm câu hỏi vào mondai.";
                    }
                }
            } else {
                $messageErrors['group_'.$group["id"]] = "Vui lòng tạo mondai cho nhóm";
            }
        }
        if($validator->fails()) {
            $messageErrors  = array_merge($messageErrors, $validator->errors()->get("*"));
        }
        return $messageErrors;
    }
    
    private function saveTestImageIcon($data) {
        if(isset($data["imageData"])) {
            $rootPathImageTest = public_path("upload/image/test/");
            if (!is_dir($rootPathImageTest)) {
                mkdir($rootPathImageTest);
            }
            if(isset($data["originalImageName"]) && File::exists($rootPathImageTest . $data["id"] . "_" . $data["originalImageName"])) {
                unlink($rootPathImageTest . $data["id"] . "_" . $data["originalImageName"]);   
            }
            $fileName = $data["id"] . "_" . $data["testImageIconFileName"];
            file_put_contents($rootPathImageTest . $fileName, $data["imageData"]);
        }
    }

    private function repaireImageData(&$data) {
        if(isset($data["testImageIconBase64"])) {
            $imgData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data["testImageIconBase64"]));
            $data["imageData"] = $imgData;
        }
    }

    public function save(Request $request, TestRepository $testRepository)
    {
        if ($request->isMethod('post')){
            $jsonData           = $request->input("jsonData");
            $data               = json_decode($jsonData, true);
            $this->repaireImageData($data);
            $messageErrors = $this->checkValidationTestData($data);
            if(count($messageErrors) <= 0) {
                try {
                    $testRepository->saveTest(
                        $data
                        , function($data) {
                            $this->saveTestImageIcon($data);
                        }
                    );
                } catch (Exception $e) {
                    Log::error($e);
                    $messageErrors["system_error"] = "Đã xảy ra lỗi trong quá trình lưu bài Test, vui lòng thử lại lần nữa!";
                }
            }
            return response()->json(
                [
                    'resultCode'=> count($messageErrors) > 0 ? -1 : 0,
                    'messages' => $messageErrors
                ]
            );            
        }
    }


    public function loadQuizs(Request $request, QuizRepository $quizRepository)
    {
        if ($request->isMethod('post')){
            $data = $request->all();
            $quizs = $quizRepository->searchQuiz($data);
            $quizs->withPath(asset('/test/loadQuizs'));
            return response()->json(
                [
                    'resultCode'=> 0,
                    'data' => $quizs->toArray(),
                    "pagination" => $quizs->links()->toHtml()
                ]
            ); 
        }
    }
    
    public function loadTest(Request $request, TestRepository $testRepository)
    {
        if ($request->isMethod('post')){
            $data = $request->all();
            $test = $testRepository->loadTest($data);
            return response()->json(
                [
                    'resultCode'=> 0,
                    'data' => $test
                ]
            ); 
        }
        
    }

    
}
