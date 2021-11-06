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
        $levels = $request->input('levels') ? $request->input('levels'): [];
        $types = $request->input('types')  ? $request->input('types'): [];
        $groups = $request->input('groups') ? $request->input('groups'): [];
        $search_query = MQuiz::query();

        if($textQuiz)
        {
            $search_query->Where('content', 'like', '%'.$textQuiz.'%');
        }
        
    
        if(count($levels) > 0)
        {
            $search_query->WhereIn('level_id', $levels);   
        }

        if(count($types) > 0)
        {
            $search_query->WhereIn('quiz_type', $types);   
        }
        
        if(count($groups) > 0)
        {   
            $search_query->WhereIn('quiz_kbn', $groups); 
        }    
        

        $quizs = $quizRepository->getAllQuizs($search_query);
        return view("Backend.quizs.list_quizs",[
            'quizs'     => $quizs,
            'textInput' => $textQuiz, 
            'oldLevels' => $levels,
            'oldTypes'  => $types,
            'oldGroups' => $groups
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
                
                'levels'    =>'required',
                'types'     =>'required',
                'group'     =>'required',
                'question'  =>'required|max:1000',
                'ansA'      =>'required|max:255',
                'ansB'      =>'required|max:255',
                'ansC'      =>'sometimes|max:255',
                'ansD'      =>'sometimes|max:255',
                'rightAns'  =>'required',
                'content'   =>'sometimes|max:1000',
                'image'     =>'sometimes|image|max:4096',
                'sound'     =>'sometimes|max:4096',
            ]
        ,
        [
                'levels.required'   => 'Vui lòng chọn trình độ cho câu hỏi.',
                'types.required'    => 'Vui lòng chọn loại cho câu hỏi.',
                'group.required'    => 'Vui lòng chọn nhóm cho câu hỏi.',
                'question.required' => 'Vui lòng nhập nội dung câu hỏi.',
                'question.max'      => 'Câu hỏi tối đa có 1000 ký tự.',
                'ansA.required'     => 'Vui lòng nhập nội dung câu trả lời.',
                'ansA.max'          => 'Câu hỏi tối đa có 255 ký tự.',
                'ansB.required'     => 'Vui lòng nhập nội dung câu trả lời.',
                'ansB.max'          => 'Câu hỏi tối đa có 255 ký tự.',
                'ansC.max'          => 'Câu hỏi tối đa có 255 ký tự.',
                'ansD.max'          => 'Câu hỏi tối đa có 255 ký tự.',
                'rightAns.required' => 'Vui lòng chọn câu trả lời đúng.',
                'content.max'       => 'Lời giải thích câu trả lời đúng tối đa có 1000 ký tự.',
                'image.max'         => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
                'image.image'       => 'Vui lòng chọn hình ảnh cho câu hỏi',
                'image.uploaded'    => 'Vì vấn đề nào đó mà quá trình upload bị lỗi.',
                'sound.max'         => 'Âm thanh chọn phải nhỏ hơn 4MB',
                'sound.uploaded'    => 'Vì vấn đề nào đó mà quá trình upload bị lỗi.',
               
        ]
        );
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $level_id = $request->input('levels');
            $quiz_type = $request->input('types');
            $quiz_kbn = $request->input('group');
            $content  = $request->input('question');
            $imageURL = "";
            $soundURL = "";
            
            $ans1       = $request->input('ansA');
            $ans2       = $request->input('ansB');
            $ans3       = $request->input('ansC');
            $ans4       = $request->input('ansD');
            $ans5       = "";
            $ans6       = "";
            $right_ans  = $request->input('rightAns');
            $exp        = $request->input('content');

            //
            if(($ans3 == '' && $right_ans == 3) || ($ans4 == '' && $right_ans == 4))
            {
                return redirect()->back()->withErrors(['quiz' => "Vui lòng chọn đúng đáp án cho câu hỏi."])->withInput();
            }
            //

            $quiz = $quizRepository->create(
                [
                    "level_id"      => $level_id,
                    "quiz_type"     => $quiz_type,
                    "quiz_kbn"      => $quiz_kbn,
                    "content"       => $content,
                    "image"         => $imageURL,
                    "sound"         => $soundURL,
                    "ans1"          => $ans1,
                    "ans2"          => $ans2,
                    "ans3"          => $ans3,
                    "ans4"          => $ans4,
                    "ans5"          => $ans5,
                    "ans6"          => $ans6,
                    "right_ans"     => $right_ans,
                    "right_ans_exp" => $exp
                ]
            );

            if ($quiz->quiz_id > 0) {
                // Edit image/sound here.

                if(Input::hasfile('image'))
                {
                    //image
                    $nameImage = Input::file('image')->getClientOriginalExtension();
                    $imageURL = $quiz->quiz_id . "." . date("H_i_s",time()). ".". $nameImage;
                    Input::file('image')->move(public_path('upload/image/quiz/'), $imageURL);
                }else
                {
                    $imageURL = "";
                }
                if(Input::hasfile('sound'))
                {
                    //sound
                    $nameSound = Input::file('sound')->getClientOriginalExtension();
                    if($nameSound == 'mp3')
                    {
                        $soundURL = $quiz->quiz_id . "." . date("H_i_s",time()). "." . $nameSound;
                        Input::file('sound')->move(public_path('upload/audio/quiz/'), $soundURL);
                    }
                    else
                    {
                        return redirect()->back()->withErrors(['sound' => "Vui lòng chọn đúng kiểu âm thanh"])->withInput();
                    }
                }else
                {
                    $soundURL = "";
                }

                // Update
                $quizRepository->update([
                    'image'     =>  $imageURL,
                    'sound'     =>  $soundURL
                ], $quiz->quiz_id, "quiz_id");

                return redirect('quizs')->with('notify', "Thêm thành công!");
            }
            else {
                return redirect('quizs')->with('notify', "Thêm thất bại!");
            }
        }
        
    }
    
    //view update a quiz
    public function editQuizForm($id, QuizRepository $quizRepository)
    {
        $validator = Validator::make(['quiz_id' => $id], [
                'quiz_id'   => 'exists:m_quiz,quiz_id'
            ], [
                'quiz_id.required'      => 'Không tồn tại câu hỏi',
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
            'levels'    =>'required',
            'types'     =>'required',
            'group'     =>'required',
            'question'  =>'required|max:1000',
            'ansA'      =>'required|max:255',
            'ansB'      =>'required|max:255',
            'ansC'      =>'sometimes|max:255',
            'ansD'      =>'sometimes|max:255',
            'rightAns'  =>'required',
            'content'   =>'sometimes|max:1000',
            'image'     =>'sometimes|image|max:4096',
            'sound'     =>'sometimes|max:4096',
        ],
        [
            'levels.required'   => 'Vui lòng chọn trình độ cho câu hỏi.',
            'types.required'    => 'Vui lòng chọn loại cho câu hỏi.',
            'group.required'    => 'Vui lòng chọn nhóm cho câu hỏi.',
            'question.required' => 'Vui lòng nhập nội dung câu hỏi.',
            'question.max'      => 'Câu hỏi tối đa có 1000 ký tự.',
            'ansA.required'     => 'Vui lòng nhập nội dung câu trả lời.',
            'ansA.max'          => 'Câu hỏi tối đa có 255 ký tự.',
            'ansB.required'     => 'Vui lòng nhập nội dung câu trả lời.',
            'ansB.max'          => 'Câu hỏi tối đa có 255 ký tự.',            
            'ansC.max'          => 'Câu hỏi tối đa có 255 ký tự.',
            'ansD.max'          => 'Câu hỏi tối đa có 255 ký tự.',
            'rightAns.required' => 'Vui lòng chọn câu trả lời đúng.',
            'content.max'       => 'Lời giải thích câu trả lời đúng tối đa có 1000 ký tự.',
            'image.max'         => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
            'image.image'       => 'Vui lòng chọn hình ảnh cho câu hỏi',
            'image.uploaded'    => 'Vui lòng chọn đúng kiểu hình ảnh.',
            'sound.uploaded'    => 'Vui lòng chọn đúng kiểu âm thanh.',
            'sound.max'         => 'Âm thanh chọn phải nhỏ hơn 4MB',
            'sound.mimes'       => 'Vui lòng chọn đúng kiểu âm thanh.',


        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {   
            //if check delete image 
            if($request->input('delete_image'))
            {
                // find quiz by id
                $imageURL = $quiz->image;
                //unlink image in folder image
                if(File::exists(public_path('upload/image/quiz/') . $imageURL))
                {
                    unlink(public_path('upload/image/quiz/') . $imageURL);   
                } 
                // update url of image in database 
                $quizRepository->update(
                    [
                        "image"          => "",
                    ],
                    $id,
                    "quiz_id"
                ); 
            }

            // if check detele sound
            if($request->input('delete_sound'))
            {
                //find quiz by id
                $soundURL = $quiz->sound;
                //unlink sound in folder auido
                if(File::exists(public_path('upload/audio/quiz/') . $soundURL))
                {
                    unlink(public_path('upload/audio/quiz/').$soundURL);   
                }
                //update usl of sound in db
                $quizRepository->update(
                    [
                        "sound"          => "",
                    ],
                    $id,
                    "quiz_id"
                ); 
            }
            //if choose new image for quiz
            if (Input::hasfile('image'))
            {
                $nameImage = Input::file('image')->getClientOriginalExtension();
                $imageURL = $id . "." . date("H_i_s",time()). ".". $nameImage;
                $oldImage = $quiz->image;
                if($oldImage != '')
                {
                    if(File::exists(public_path('upload/image/quiz/') . $oldImage))
                    {
                        unlink(public_path('upload/image/quiz/') . $oldImage);   
                    } 
                }
                Input::file('image')->move(public_path('upload/image/quiz/'), $imageURL);
                
                $quizRepository->update(
                    [
                        "image"          => $imageURL,
                    ],
                    $id,
                    "quiz_id"
                );   
            }
            //if choose new sound for quiz 
            if(Input::hasfile('sound'))
            {
                //sound
                $nameSound = Input::file('sound')->getClientOriginalExtension();
                $oldSound = $quiz->sound;
                if($nameSound == 'mp3')
                {
                    $soundURL = $id . "." . date("H_i_s",time()). ".". $nameSound;
                    if($oldSound != '')
                    {
                        if(File::exists(public_path('upload/audio/quiz/') . $oldSound))
                        {
                            unlink(public_path('upload/audio/quiz/').$oldSound);   
                        }
                    }
                    Input::file('sound')->move(public_path('upload/audio/quiz/'), $soundURL);
                    $quizRepository->update(
                        [
                            "sound"          =>$soundURL,
                        ],
                        $id,
                        "quiz_id"
                    );
                }else
                {
                    return redirect()->back()->withErrors("Vui lòng chọn đúng kiểu âm thanh")->withInput();                    
                }
                
                
            }
            //
            if(($request->get('ansC') == '' && $request->get('rightAns') == 3) || ($request->get('ansD')== '' && $request->get('rightAns') == 4))
            {
                return redirect()->back()->withErrors(['quiz' => "Vui lòng chọn đúng đáp án cho câu hỏi."])->withInput();
            }
            //
            //update quiz
            $quizRepository->update(
                [
                    "level_id"          =>$request->get('levels'),
                    "quiz_type"         =>$request->get('types'),
                    "quiz_kbn"          =>$request->get('group'),
                    "content"           =>$request->get('question'),
                    "ans1"              =>$request->get('ansA'),
                    "ans2"              =>$request->get('ansB'),
                    "ans3"              =>$request->get('ansC'),
                    "ans4"              =>$request->get('ansD'),
                    "right_ans"         =>$request->get('rightAns'),
                    "right_ans_exp"     =>$request->get('content')
                ],
                $id,
                "quiz_id"
            );
            return redirect('quizs');
        }
    
    }

    //detail a quiz
    public function detailQuiz($id, QuizRepository $quizRepository)
    {
        $validator = Validator::make(['quiz_id' => $id], [
                'quiz_id'   => 'exists:m_quiz,quiz_id'
            ], [
                'quiz_id.require'   =>'Không tồn tại câu hỏi',
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
        //update delete_flag
        $quizRepository->update(
            [
                "deleted_flag"          => 1, 
            ],
            $id,
            "quiz_id"
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
                "quiz_id"
            );
        }
        return redirect()->back();
    }
}
