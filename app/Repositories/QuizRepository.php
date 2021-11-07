<?php

namespace App\Repositories;
use App\Models\MQuiz;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Schema;

class QuizRepository extends BaseRepository
{

    /**
     * Create a new QuizRepository instance.
     *
     * @param  App\Models\MTestMQuizQuiz $mQuiz
     * @return void
     */
    public function __construct(
        MQuiz $mQuiz
    ) 
    {
        $this->model = $mQuiz;
    }
    
      public function getFromQuiz($data) {
        $quiz = $this->model->whereIn('quiz_id',$data)->where('deleted_flag',0)->get(['quiz_id','content', 'image', 'sound', 'ans1', 'ans2', 'ans3', 'ans4', 'right_ans', 'right_ans_exp']);
        return $quiz->toArray();
    }


    public function getIdRightAns($array_Quiz_id) {
        $quiz = $this->model->whereIn('quiz_id',$array_Quiz_id)->where('deleted_flag',0)->get(['quiz_id','right_ans']);
        return $quiz->toArray();
    }
//////

    public function getAllQuizs($search_query)
    {
        $quizs = $search_query->where("deleted_flag",0)->paginate(20);
        return $quizs;
    }
    public function searchQuiz($conditions) {

        $quizModel = $this->model;
        if(isset($conditions["groupId"]) && !empty($conditions["groupId"])) {
            $quizModel = $quizModel->whereIn('quiz_kbn', explode(',', $conditions["groupId"]));
        }
        if(isset($conditions["searchQuizLevel"]) && !empty($conditions["searchQuizLevel"])) {
            $quizModel = $quizModel->whereIn('level_id', explode(',', $conditions["searchQuizLevel"]));
        }
        if(isset($conditions["searchQuizType"]) && !empty($conditions["searchQuizType"])) {
            $quizModel = $quizModel->whereIn('quiz_type', explode(',', $conditions["searchQuizType"]));
        }
        if(isset($conditions["searchQuizContent"]) && !empty($conditions["searchQuizContent"])) {
			$quizModel = $quizModel->where('content', 'like','%'.$conditions["searchQuizContent"].'%');
        }
        if(isset($conditions["searchQuizFromDate"]) && !empty($conditions["searchQuizFromDate"])) {
			$quizModel = $quizModel->where('created_time', '>=', $conditions["searchQuizFromDate"]);
        }
        if(isset($conditions["searchQuizToDate"]) && !empty($conditions["searchQuizToDate"])) {
			$quizModel = $quizModel->where('created_time', '<=', $conditions["searchQuizToDate"]);
        }
        if(isset($conditions["existQuizIds"]) && !empty($conditions["existQuizIds"])) {
            $quizModel = $quizModel->whereNotIn('id', explode(',', $conditions["existQuizIds"]));
        }
		$quizModel = $quizModel->where('deleted_flag', 0);
        return $quizModel->with(["type","level","group"])->select([
            "id",
            "level",
            "content",
            "image",
            "ans1",
            "ans2",
            "ans3",
            "ans4",
            "right_ans",
            "right_ans_exp"
        ])->paginate(15);
    }
	
    
}