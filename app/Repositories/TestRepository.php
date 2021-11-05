<?php

namespace App\Repositories;
use App\Models\MTest;
use App\Models\MQuiz;
use App\Models\MTestQuiz;
use App\Models\MTestMondai;
use App\Repositories\BaseRepository;
use App\Models\TUserTestScore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class TestRepository extends BaseRepository
{
    /**
     * The Tag instance.
     *
     * @var App\Models\MTestQuiz
     */
    protected $mTestQuiz;

    /**
     * The Tag instance.
     *
     * @var App\Models\MQuiz
     */
    protected $mQuiz;

   
    /**
     * The Tag instance.
     *
     * @var App\Models\TUserTestScore
     */
    protected $tUserTestScore;

    /**
     * The Tag instance.
     *
     * @var App\Models\MTestMondai
     */
    protected $mTestMondai;

    /**
     * Create a new TestRepository instance.
     *
     * @param  App\Models\MTest $mTest
     * @param  App\Models\MTestQuiz $mTestQuiz
     * @return void
     */
    public function __construct(
        MTest $mTest,
        MTestQuiz $mTestQuiz,
        MQuiz $mQuiz,
        MTestMondai $mTestMondai,
        TUserTestScore $tUserTestScore
    )
    {
        $this->model = $mTest;
        $this->mTestQuiz = $mTestQuiz;
        $this->mQuiz = $mQuiz;
        $this->mTestMondai = $mTestMondai;
        $this->tUserTestScore = $tUserTestScore;
    }
    /*************************************************************************************************/

//lấy số câu đúng nhiều nhất trong các lần test ở cột right_answers trong bảng t_user_test_score
    public function getPointToAnswers($test_id, $user_id){
        $point = $this->tUserTestScore->where([
            ["test_id", "=", $test_id],
            ["user_id", "=", $user_id],
        ])
            ->get([
                'total_right_answers_goi',
                'total_question_goi',
                'total_right_answers_dokkai',
                'total_question_dokkai',
                'total_right_answers_choikai',
                'total_question_choikai',
            ]);
        return $point;
    }

//l?y t?t c? câu h?i query trong b?ng m_test_quiz
    public function getAllTestQuiz($test_id){
        $getAll = $this->mTestQuiz
            ->where("test_id", $test_id)
            ->get([
                'test_id',
            ]);
        return $getAll->toArray();
    }

    public function getDeletedFlag($test_id,$user_id){
        return $this->tUserTestScore
            ->where([
                ["test_id",$test_id] ,
                ["user_id",$user_id]
            ])
            ->first([
                'deleted_flag',
            ]);
        //return $deleted_flag->toArray();
    }
    public function insertDeleted($data,$test_id,$user_id)
    {
        return $this->tUserTestScore->where([
            ["test_id",$test_id] ,
            ["user_id",$user_id]
        ])->update([
            'deleted_flag'  => $data['deleted_flag'],
            'created_user'  => $data['created_user'],
            'created_time'  => $data['created_time'],
            'updated_user'   => $data['updated_user'],
            'updated_time'   => $data['updated_time']
        ]);
    }

//l?y t?t c? d? li?u danh sách bài test trong b?ng m_test
    public function getAllTests($test_type_id,$test_level_id){
        $Test = $this->model
            ->where([
                ["test_type_id","=",$test_type_id] ,
                ["test_level_id","=",$test_level_id],
                ["deleted_flag",0],
                ["public_status",1],
                ["public_date","<=", date("Y-m-d H:i:s",time())]
            ])->get(['test_id', 'test_name', 'test_description', 'test_limit_time_goi', 'test_limit_time_choukai', 'test_limit_time_gokai']);


        return $Test->toArray();
    }

        /*Refesh Test Of User*/

        public function refeshTestOfUser($user_id, $test_id)
        {
            $data= array();
            $data['total_right_answers_goi'] = 0;
            $data['total_question_goi'] = 0;
            $data['total_right_answers_dokkai'] = 0;
            $data['total_question_dokkai'] = 0;
            $data['total_right_answers_choikai'] = 0;
            $data['total_question_choikai'] = 0;
            return $this->tUserTestScore->where([
                ['deleted_flag','!=',1],
                ['user_id','=',$user_id],
                ['test_id','=',$test_id]
            ])
                ->update($data);
        }
    

    /*************************************************************************************************/
    /////////////Tân


    //////////////////login
            public function getPointUser($user_id) {
    $sql = "SELECT  test_id,test_score_id, sum( total_right_answers_goi
                                    + total_right_answers_dokkai
                                    + total_right_answers_choikai
                                ) as sum_total_right_answers FROM 
                                    t_user_test_scores WHERE  total_question_goi is not null and total_question_goi != 0
                                        and total_question_dokkai is not null and total_question_dokkai != 0
                                        and total_question_choikai is not null and total_question_choikai != 0
                                        and deleted_flag != 1 AND user_id = ".$user_id." 
                                        GROUP BY test_score_id , test_id
                                        ORDER BY sum_total_right_answers DESC ";
    return  DB::select($sql);
     }
     ////////////////////////getlistest

    public function getFromTestQuiz($test_id, $quiz_group) {
        $result = $this->mTestQuiz
            ->where([['test_id', '=', $test_id],['quiz_group','=',$quiz_group],['deleted_flag','!=',1]])
            ->get(['quiz_id']);
        return $result;
    }
        public function getTestData($test_id) {
        $result = $this->model
            ->where([['test_id', '=', $test_id],['deleted_flag','!=',1]])
            ->get([
                'test_name',
                'test_type_id',
                'test_limit_time_goi',
                'test_limit_time_choukai',
                'test_limit_time_gokai',
                'public_status',
                'public_date'
            ]);
        return $result->toArray();
    }

    ////////////////////getscore
    public function userCompleteTest($user_id,$test_id) {
            return $this->tUserTestScore->where([['deleted_flag','!=',1],['user_id','=',$user_id],['test_id','=',$test_id]])->get(['test_score_id']);
    }
    public function checkTestId() {
        $result = $this->mTestQuiz->where('deleted_flag','!=',1)->get(['test_id']);
        return $result->toArray(); 
    }
    public function getArrayQuizId($test_id, $quiz_group) {
        $result = $this->mTestQuiz->where([['test_id', $test_id],['quiz_group', $quiz_group]])->get(['quiz_id']);
        return $result->toArray();
    }
    public function userTestScoreUpdate($quiz_group,$test_id, $data, $total_right_answers, $total_question,$user_id) {

        if($quiz_group == 1) {
            $data['total_right_answers_goi'] = $total_right_answers;
            $data['total_question_goi'] = $total_question;
            return $this->tUserTestScore->where([['deleted_flag','!=',1],['user_id','=',$user_id],['test_id','=',$test_id]])
            ->update($data);
        } elseif ($quiz_group == 2) {
            $data['total_right_answers_dokkai'] = $total_right_answers;
            $data['total_question_dokkai'] = $total_question;
            return $this->tUserTestScore->where([['deleted_flag','!=',1],['user_id','=',$user_id],['test_id','=',$test_id]])
            ->update($data);
        } elseif ($quiz_group == 3) {
            $data['total_right_answers_choikai'] = $total_right_answers;
            $data['total_question_choikai'] = $total_question;
            return $this->tUserTestScore->where([['deleted_flag','!=',1],['user_id','=',$user_id],['test_id','=',$test_id]])
            ->update($data);
        }
    }
        public function userTestScoreCreate($quiz_group, $data, $total_right_answers, $total_question) {

        if($quiz_group == 1) {
            $data['total_right_answers_goi'] = $total_right_answers;
            $data['total_question_goi'] = $total_question;
            $data['total_right_answers_dokkai'] = 0;
            $data['total_question_dokkai'] = 0;
            $data['total_right_answers_choikai'] = 0;
            $data['total_question_choikai'] = 0;
        } elseif ($quiz_group == 2) {
            $data['total_right_answers_goi'] = 0;
            $data['total_question_goi'] = 0;
            $data['total_right_answers_dokkai'] = $total_right_answers;
            $data['total_question_dokkai'] = $total_question;
            $data['total_right_answers_choikai'] = 0;
            $data['total_question_choikai'] = 0;
        } elseif ($quiz_group == 3) {
            $data['total_right_answers_goi'] = 0;
            $data['total_question_goi'] = 0;
            $data['total_right_answers_dokkai'] = 0;
            $data['total_question_dokkai'] = 0;
            $data['total_right_answers_choikai'] = $total_right_answers;
            $data['total_question_choikai'] = $total_question;
        }

        return $this->tUserTestScore->insert($data);
    }

    ////////////////
    public function checkUserTested($user_id, $test_id) {
        return $this->tUserTestScore
            ->where('user_id', '=', $user_id)
            ->where('test_id','=',$test_id)
            ->get(['test_score_id'])->toArray();
    }



    public function updateUserTestScore($user_id, $test_id, $quiz_group, $total_right_answers, $total_question) {

        $data = array();
        if($quiz_group == 1) {
            $data['total_right_answers_goi'] = $total_right_answers;
            $data['total_question_goi'] = $total_question;
        } elseif ($quiz_group == 2) {
            $data['total_right_answers_dokkai'] = $total_right_answers;
            $data['total_question_dokkai'] = $total_question;
        } elseif ($quiz_group == 3) {
            $data['total_right_answers_choikai'] = $total_right_answers;
            $data['total_question_choikai'] = $total_question;
        }

        $result = $this->tUserTestScore->where([
            ['user_id','=',$user_id],
            ['test_id', '=', $test_id]
        ])->update($data);
        return $result;
    }


    public function getPointAnswers($type){
            $whereClause = "";
        // top score of month
        if($type == "m") {
            $whereClause = " between date_format(now() ,'%Y-%m-01') and now() ";
        } 
        // top score of quarter
        else if($type == "q") {
            $startMondth = ""; 
            $month = date("m");
            // quarter 1
            if(1 <= $month && $month <= 3) {
                $startMondth = "01";
            } 
            // quarter 2
            else if(4 <= $month && $month<= 6) {
                $startMondth = "04";                
            } 
            // quarter 3
            else if(7 <= $month && $month<= 9) {
                $startMondth = "07";                
            } 
            // quarter 4
            else {
                $startMondth = "10";                
            }
            $whereClause = "  between date_format(now() ,'%Y-" . $startMondth . "-01') and now() ";
        }  
        // top score of year
        else if($type == "y") {
            $whereClause = "  between date_format(now() ,'%Y-01-01') and now() "; 
        }

            $sql = "SELECT u.user_id,u.nick_name,u.avatar,sum_total_right_answers,max_test_date
            FROM (
            SELECT ts.user_id  , SUM(ts.total_right_answers_goi + ts.total_right_answers_dokkai + ts.total_right_answers_choikai ) as sum_total_right_answers  , MAX(ts.test_date) as max_test_date
            FROM t_user_test_scores ts
            WHERE ts.total_question_goi IS NOT NULL AND ts.total_question_dokkai IS NOT NULL AND ts.total_question_choikai IS NOT NULL 
            AND  ts.total_question_goi >0  AND ts.total_question_dokkai > 0 AND ts.total_question_choikai > 0 AND ts.test_date " .  $whereClause  . " 
            GROUP BY ts.user_id
            )ts_sum JOIN m_user u ON ts_sum.`user_id` = u.`user_id`
            ORDER BY ts_sum.sum_total_right_answers DESC , ts_sum.`max_test_date` DESC
            LIMIT 50";
        $point = DB::select($sql);
        return $point;
    }


    public function getRightAns($data) {
        $quiz = $this->model
            ->whereIn('quiz_id',$data)
            ->get(['right_ans']);
        return $quiz->toArray();
    }




    // public function getPointAnswers($type){
    //     $whereClause = "";
    //     // top score of month
    //     if($type == "m") {
    //         $whereClause = " utc.test_date between date_format(now() ,'%Y-%m-01') and now() ";
    //     } 
    //     // top score of quarter
    //     else if($type == "q") {
    //         $startMondth = ""; 
    //         $month = date("m");
    //         // quarter 1
    //         if(1 <= $month && $month <= 3) {
    //             $startMondth = "01";
    //         } 
    //         // quarter 2
    //         else if(4 <= $month && $month<= 6) {
    //             $startMondth = "04";                
    //         } 
    //         // quarter 3
    //         else if(7 <= $month && $month<= 9) {
    //             $startMondth = "07";                
    //         } 
    //         // quarter 4
    //         else {
    //             $startMondth = "10";                
    //         }
    //         $whereClause = " utc.test_date between date_format(now() ,'%Y-" . $startMondth . "-01') and now() ";
    //     }  
    //     // top score of year
    //     else if($type == "y") {
    //         $whereClause = " utc.test_date between date_format(now() ,'%Y-01-01') and now() "; 
    //     }  
    //     $sql = "
    //             SELECT
    //                     u.nick_name,
    //                     u.avatar,
    //                     utc_sum.sum_total_right_answers,
    //                     max_test_date
    //                 FROM
    //                     m_user u
    //                     INNER JOIN
    //                     (
    //                         SELECT
    //                             utc.user_id,
    //                             max(utc.test_date) as max_test_date,
    //                             sum(
    //                                 utc.total_right_answers_goi
    //                                 + utc.total_right_answers_dokkai
    //                                 + utc.total_right_answers_choikai
    //                             ) as sum_total_right_answers
    //                         FROM
    //                         (
    //                             SELECT 
    //                                 u.user_id,
    //                                 utc.test_id,
    //                                 utc.test_score_id,
    //                                 @rank:= 
    //                                     case 
    //                                         when @test_id != utc.test_id OR @user_id != utc.user_id
    //                                             then 1 
    //                                         else 
    //                                             @rank + 1 
    //                                     end 
    //                                 AS rank,
                //                     @test_id:=utc.test_id,
                //                     @user_id:=utc.user_id
    //                             FROM 
    //                                 t_user_test_scores utc
    //                                 INNER JOIN m_user u
    //                                 ON 
    //                                     utc.user_id  = u.user_id
    //                                     and utc.total_question_goi is not null and utc.total_question_goi != 0
    //                                     and utc.total_question_dokkai is not null and utc.total_question_dokkai != 0
    //                                     and utc.total_question_choikai is not null and utc.total_question_choikai != 0
    //                             WHERE " . $whereClause . "
    //                             ORDER BY
    //                                 utc.user_id,
    //                                 utc.test_id,
    //                                 (
    //                                     utc.total_right_answers_goi
    //                                     + utc.total_right_answers_dokkai
    //                                     + utc.total_right_answers_choikai
    //                                 ) DESC,
    //                                 utc.test_date ASC
    //                         ) utc_rank
    //                         INNER JOIN t_user_test_scores utc
    //                         ON
    //                             utc_rank.test_score_id = utc.test_score_id
    //                         WHERE 
    //                             utc_rank.rank = 1
    //                         GROUP BY
    //                             utc.user_id
    //                     ) utc_sum
    //                     ON
    //                         u.user_id = utc_sum.user_id
    //                 ORDER BY
    //                     utc_sum.sum_total_right_answers DESC,
    //                     utc_sum.max_test_date ASC
    //                 LIMIT 50";
    //     $point = DB::select($sql);
    //     return $point;
    // }
    
    public function saveTest($data, $callBackSaveTestImageIcon) {
        try {
            DB::beginTransaction();
            $testId = null;
            // save data to m_test
            $data["publicDate"] = isset($data["publicDate"]) && !empty($data["publicDate"]) ? $data["publicDate"] : null;
            if(isset($data["id"]) && !empty($data["id"])) {
                $modelTest = $this->model
                    ->where("test_id", $data["id"])
                    ->update([
                        "test_name" => $data["name"],
                        "test_image_icon" => $data["testImageIconFileName"],
                        "test_price"        =>$data["price"],
                        "test_description" => $data["description"],
                        "test_type_id" => $data["type"],
                        "test_level_id" => $data["levelId"],
                        "test_limit_time_goi" => $data["limitTimeGoi"],
                        "test_limit_time_choukai" => $data["limitTimeChoukai"],
                        "test_limit_time_gokai" => $data["limitTimeGokai"],
                        "public_status" => $data["publicStatus"],
                        "public_date" => $data["publicDate"]
                    ]);
                $testId = $data["id"];
            } else {
                $modelTest = $this->model->create([
                    "test_name" => $data["name"],
                    "test_image_icon" => $data["testImageIconFileName"],
                    "test_price"        =>$data["price"],
                    "test_description" => $data["description"],
                    "test_type_id" => $data["type"],
                    "test_level_id" => $data["levelId"],
                    "test_limit_time_goi" => $data["limitTimeGoi"],
                    "test_limit_time_choukai" => $data["limitTimeChoukai"],
                    "test_limit_time_gokai" => $data["limitTimeGokai"],
                    "public_status" => $data["publicStatus"],
                    "public_date" => $data["publicDate"]
                ]);
                $testId = $modelTest->test_id;
            }

            // we will delete the all quiz of current test
            $this->mTestQuiz
                ->where("test_id", "=", $testId)
                ->delete();

            foreach ($data["groups"] as $group) {
                $mondais = $group["mondais"];
                foreach ($mondais as $mondai) {
                    $quests = $mondai["quests"];
                    // save data to m_mondai
                    $modelMondai = null;
                    $mondaiId = null;
                    if(isset($mondai["originalId"]) && !empty($mondai["originalId"])) {
                        $modelMondai = $this->mTestMondai
                            ->where("mondai_id", $mondai["originalId"])
                            ->update([
                                "mondai_id" => $mondai["id"],
                                "mondai_name" => $mondai["name"],
                                "mondai_description" => $mondai["description"]
                            ]);
                        $mondaiId = $mondai["originalId"];
                    } else {
                        $modelMondai = $this->mTestMondai->create([
                            "test_id" => $testId,
                            "mondai_name" => $mondai["name"],
                            "mondai_description" => $mondai["description"]
                        ]);
                        $mondaiId = $modelMondai->mondai_id;
                    }
                    foreach ($quests as $quest) {
                        if(isset($quest["importFlag"])) {
                            $questAdded = $this->mQuiz->create(
                                [
                                    "level_id"      => $quest["level_id"],
                                    "quiz_type"     => $quest["quiz_type"],
                                    "quiz_kbn"      => $quest["quiz_group"],
                                    "content"       => $quest["content"],
                                    "image"         => null,
                                    "sound"         => null,
                                    "ans1"          => $quest["ans1"],
                                    "ans2"          => $quest["ans2"],
                                    "ans3"          => $quest["ans3"],
                                    "ans4"          => $quest["ans4"],
                                    "right_ans"     => $quest["right_ans"],
                                    "right_ans_exp" => $quest["right_ans_exp"]
                                ]
                            );
                            $quest["id"] = $questAdded->quiz_id;
                        }
                        // save data to m_test_quiz
                        $this->mTestQuiz->create([
                            "test_id" => $testId,
                            "mondai_grp" => $mondaiId,
                            "quiz_id" => $quest["id"],
                            "quiz_group" => $group["id"],
                            "sort_order" => $quest["sortOrder"]
                        ]);
                    }

                }
            }
            $data["id"] = $testId;
            $callBackSaveTestImageIcon($data);
            DB::commit();
        } finally {
            DB::rollBack();
        }

    }

    public function loadTest($data) {
        try {
            DB::beginTransaction();
            $id = $data["id"];
            $testData = $this->model->find($id,
                [
                    "test_id",
                    "test_name",
                    "test_image_icon",
                    "test_price",
                    "test_description",
                    "test_type_id",
                    "test_level_id",
                    "test_limit_time_goi",
                    "test_limit_time_choukai",
                    "test_limit_time_gokai",
                    "public_status",
                    "public_date"
                ]
            )->toArray();
            if(isset($testData["public_date"])) {
                $testData["public_date"] = date_format(date_create($testData["public_date"]),"Y-m-d");
            }
            $testQuizs = $this->mTestQuiz
                ->where("test_id", $id)
                ->orderBy("quiz_group")
                ->orderBy("mondai_grp")
                ->orderBy("sort_order")
                ->get([
                    "test_id",
                    "quiz_id",
                    "quiz_group",
                    "mondai_grp",
                    "sort_order"
                ]);
            $testData["groups"] = [];
            $currentGroup = null;
            $currentMondai = null;
            foreach ($testQuizs as $testQuiz) {
                $groupId = $testQuiz->quiz_group;
                if($currentGroup == null || $currentGroup["id"] != $groupId) {
                    unset($currentGroup);
                    unset($currentMondai);
                    $currentMondai = null;
                    $currentGroup = [
                        "id" => $groupId,
                        "mondais" => []
                    ];
                    $testData["groups"][] = &$currentGroup;
                }
                if($currentMondai == null || $testQuiz->mondai_grp != $currentMondai["id"]) {
                    $modai = $testQuiz->mondai;
                    unset($currentMondai);
                    $currentMondai = [
                        "id" => $modai->mondai_id,
                        "name" => $modai->mondai_name,
                        "description" => $modai->mondai_description,
                        "quests" => []
                    ];
                    $currentGroup["mondais"][] = &$currentMondai;
                }
                if($testQuiz->quiz) {
                    $quiz = $testQuiz->quiz->toArray();
                    $quiz["sortOrder"] = $testQuiz->sort_order;
                    $currentMondai["quests"][] = $quiz;
                }
            }
            return $testData;
        } finally {
            DB::rollBack();
        }

    }

    //lấy tất cả bài test đổ vào view list(Back_end)
    public function getAllTestsInDB($search_query)
    {
        $tests = $search_query->where("deleted_flag",0)->paginate(20);
        return $tests;
    }

    //count total test(back end)
    public function countTests()
    {
		$total = $this->model->where("deleted_flag",0)->count();
		return $total;
    } 
}