<?php

namespace App\Http\Controllers\Backend;

use App\Models\MQuiz;
use App\Repositories\QuizRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class QuizController extends Controller
{
    //view list_quiz and result search multi
    public function index(Request $request,QuizRepository $quizRepository )
    {
        $textQuiz = $request->input('textinput');
        $types = $request->input('types')  ? $request->input('types'): [];
        $search_query = MQuiz::query();

        if($textQuiz)
        {
            $search_query->Where('content', 'like', '%'.$textQuiz.'%');
        }
        
        if(count($types) > 0)
        {
            $search_query->WhereIn('level', $types);   
        }
        
        $types = array(['s_name' => "Câu hỏi thường", 's_value'=> 1],['s_name'=> "Câu hỏi đặc biệt", 's_value'=> 2]);
        $quizs = $quizRepository->getAllQuizs($search_query);
        return view("Backend.quizs.list_quizs",[
            'quizs'     => $quizs,
            'textInput' => $textQuiz, 
            'oldTypes'  => $types,
            'types'     => json_decode (json_encode ($types), FALSE)
            ]);
    }

    //view form create
    public function createNewQuizForm()
    {
        return view('Backend.quizs.create_quiz');
    }

    //create quiz
    public function createNewQuiz(Request $request, QuizRepository $quizRepository)
    {
        $validator = Validator::make(
            $request->all(), 
            [
                
                'level'    =>'required',
                'question'  =>'required|max:1000',
                'ansA'      =>'required|max:255',
                'ansB'      =>'required|max:255',
                'ansC'      =>'required|max:255',
                'ansD'      =>'sometimes|max:255',
                'rightAns'  =>'required',
                'content'   =>'sometimes|max:1000',
                // 'image'     =>'sometimes|image|max:4096',
            ]
        ,
        [
                'level.required'    => 'Vui lòng chọn loại cho câu hỏi.',
                'question.required' => 'Vui lòng nhập nội dung câu hỏi.',
                'question.max'      => 'Câu hỏi tối đa có 1000 ký tự.',
                'ansA.required'     => 'Vui lòng nhập nội dung câu trả lời.',
                'ansA.max'          => 'Câu hỏi tối đa có 255 ký tự.',
                'ansB.required'     => 'Vui lòng nhập nội dung câu trả lời.',
                'ansB.max'          => 'Câu hỏi tối đa có 255 ký tự.',
                'ansC.required'     => 'Vui lòng nhập nội dung câu trả lời.',
                'ansC.max'          => 'Câu hỏi tối đa có 255 ký tự.',
                'ansD.max'          => 'Câu hỏi tối đa có 255 ký tự.',
                'rightAns.required' => 'Vui lòng chọn câu trả lời đúng.',
                'content.max'       => 'Lời giải thích câu trả lời đúng tối đa có 1000 ký tự.',
                // 'image.max'         => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
                // 'image.image'       => 'Vui lòng chọn hình ảnh cho câu hỏi',
                // 'image.uploaded'    => 'Vì vấn đề nào đó mà quá trình upload bị lỗi.',
               
        ]
        );
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
          if(($request->get('ansD')== '' && $request->get('rightAns') == 4))
          {
              return redirect()->back()->withErrors(['quiz' => "Vui lòng chọn đúng đáp án cho câu hỏi."])->withInput();
          }
          $level = $request->input('level');
          $content  = $request->input('question');
          $imageURL = "";
          $ans1       = $request->input('ansA');
          $ans2       = $request->input('ansB');
          $ans3       = $request->input('ansC');
          $ans4       = $request->input('ansD');
          $right_ans  = $request->input('rightAns');
          $exp        = $request->input('content');

          $quiz = $quizRepository->create(
            [
              "level"         => $level,
              "content"       => $content,
              "image"         => $imageURL,
              "ans1"          => $ans1,
              "ans2"          => $ans2,
              "ans3"          => $ans3,
              "ans4"          => $ans4,
              "right_ans"     => $right_ans,
              "right_ans_exp" => $exp
            ]
          );

          if ($quiz->id > 0) {
            // if(Input::hasfile('image'))
            // {
            //   //image
            //   $nameImage = Input::file('image')->getClientOriginalExtension();
            //   $imageURL = $quiz->id . "." . date("H_i_s",time()). ".". $nameImage;
            //   Input::file('image')->move(public_path('upload/image/quiz/'), $imageURL);
            // }else
            // {
            //     $imageURL = "";
            // }
            // Update
            // $quizRepository->update([
            //     'image'     =>  $imageURL,
            // ], $quiz->id, "id");
            return redirect()->route('quizs')->with('notify', "Thêm thành công!");
          }
          else {
            return redirect()->back()->with('notify', "Thêm thất bại!");
          }
        }
        
    }
    
    //view update a quiz
    public function editQuizForm($id, QuizRepository $quizRepository)
    {
        $validator = Validator::make(['id' => $id], [
            'id'   => 'exists:quizs,id'
          ], [
              'id.required'      => 'Không tồn tại câu hỏi',
          ]);
        if ($validator->fails())
        {
          return redirect()->back();
        }
        else
        {
          $quiz = $quizRepository->find((int)$id);
          return view('Backend.quizs.edit_quiz', ['quiz' => $quiz]);  
        }
    }

    //update a quiz
    public function updateQuiz(Request $request, $id, QuizRepository $quizRepository)
    {
        $quiz = $quizRepository->find((int)$id);
        $validator = Validator::make($request->all(), [
            'level'    =>'required',
            'question'  =>'required|max:1000',
            'ansA'      =>'required|max:255',
            'ansB'      =>'required|max:255',
            'ansC'      =>'required|max:255',
            'ansD'      =>'sometimes|max:255',
            'rightAns'  =>'required',
            'content'   =>'sometimes|max:1000',
            // 'image'     =>'sometimes|image|max:4096',
        ],
        [
            'level.required'    => 'Vui lòng chọn loại cho câu hỏi.',
            'question.required' => 'Vui lòng nhập nội dung câu hỏi.',
            'question.max'      => 'Câu hỏi tối đa có 1000 ký tự.',
            'ansA.required'     => 'Vui lòng nhập nội dung câu trả lời.',
            'ansA.max'          => 'Câu hỏi tối đa có 255 ký tự.',
            'ansB.required'     => 'Vui lòng nhập nội dung câu trả lời.',
            'ansB.max'          => 'Câu hỏi tối đa có 255 ký tự.',   
            'ansC.required'     => 'Vui lòng nhập nội dung câu trả lời.',         
            'ansC.max'          => 'Câu hỏi tối đa có 255 ký tự.',
            'ansD.max'          => 'Câu hỏi tối đa có 255 ký tự.',
            'rightAns.required' => 'Vui lòng chọn câu trả lời đúng.',
            'content.max'       => 'Lời giải thích câu trả lời đúng tối đa có 1000 ký tự.',
            // 'image.max'         => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
            // 'image.image'       => 'Vui lòng chọn hình ảnh cho câu hỏi',
            // 'image.uploaded'    => 'Vui lòng chọn đúng kiểu hình ảnh.',


        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
          if(($request->get('ansD')== '' && $request->get('rightAns') == 4))
          {
              return redirect()->back()->withErrors(['quiz' => "Vui lòng chọn đúng đáp án cho câu hỏi."])->withInput();
          }
          //
          //update quiz
          $quizRepository->update(
              [
                  "level"             =>$request->get('level'),
                  "content"           =>$request->get('question'),
                  "ans1"              =>$request->get('ansA'),
                  "ans2"              =>$request->get('ansB'),
                  "ans3"              =>$request->get('ansC'),
                  "ans4"              =>$request->get('ansD'),
                  "right_ans"         =>$request->get('rightAns'),
                  "right_ans_exp"     =>$request->get('content')
              ],
              $id,
              "id"
          );
          return redirect()->route('quizs');
        }
    
    }

    //detail a quiz
    public function detailQuiz($id, QuizRepository $quizRepository)
    {
        $validator = Validator::make(['id' => $id], [
            'id'   => 'exists:quizs,id'
        ], [
            'id.require'   =>'Không tồn tại câu hỏi',
        ]);

        if ($validator->fails())
        {
          return redirect()->back();
        }
        else
        {
          $quiz = $quizRepository->find((int)$id);
          return view('Backend.quizs.detail_quiz', ['quiz' => $quiz]);  
        }
    }
    
    //destroy a quiz
    public function destroyQuiz($id, QuizRepository $quizRepository)
    {
      $validator = Validator::make(['id' => $id], [
      'id'   => 'exists:quizs,id'
      ], [
          'id.require'   =>'Không tồn tại câu hỏi',
      ]);

      if ($validator->fails())
      {
        return redirect()->back();
      }
      //update delete_flag
      $quizRepository->update(
        [
            "deleted_flag"          => 1, 
        ],
        $id,
        "id"
      );
      return redirect()->back();
    }

    //delete multi quiz
    public function deleteall(Request $rq, QuizRepository $quizRepository) 
    {
        //get list quiz choosed 
        $list_id = $rq->get('list_id');
        foreach ($list_id as $id) {
          //update delete_flag
          $quizRepository->update(
            [
                "deleted_flag"          => 1,
            ],
            $id,
            "id"
          );
        }
        return redirect()->back();
    }
}
