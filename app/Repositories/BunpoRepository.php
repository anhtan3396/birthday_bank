<?php

namespace App\Repositories;
use App\Models\MBunpo;
use App\Models\MUserBunpo;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Schema;

class BunpoRepository extends BaseRepository
{

    /**
     * Create a new QuizRepository instance.
     *
     * @param  App\Models\MTestMQuizQuiz $mBunpo
     * @return void
     */
    public function __construct(
        MBunpo $mBunpo,
        MUserBunpo $mUserBunpo
    )
    {
        $this->model = $mBunpo;
        $this->mUserBunpo = $mUserBunpo;
    }

    public function getFromBunpo($data) {
        $bunpo = $this->model->whereIn('bunpo_id',$data)->get(['image', 'hiragana', 'katakana', 'kanji', 'meaning', 'sound', 'is_n1', 'is_n2', 'is_n3', 'is_n4', 'is_n5', 'is_type_practice', 'is_type_test']);
        return $bunpo->toArray();
    }

    public function getAllBunpo($search_query)
    {
        $bunpos = $search_query->where("deleted_flag",0)->paginate(20);
        return $bunpos;
    }

//////////////////////////////Tân
        public function getListBunpo($level,$type) {
        $result = $this->model->where([["$level",1],["$type",1],['deleted_flag','!=',1]])->get(['bunpo_id','image', 'hiragana', 'katakana', 'kanji', 'meaning', 'sound']);
        return $result->toArray();
    }
        public function searchBunpo($level,$type,$bunbo_key) {
                $result = $this->model->where([["$level",1],["$type",1],['deleted_flag','!=',1],['hiragana', 'like', '%'.$bunbo_key.'%']])
                                      ->orWhere([["$level",1],["$type",1],['deleted_flag','!=',1],['katakana', 'like', '%'.$bunbo_key.'%']])
                                      ->orWhere([["$level",1],["$type",1],['deleted_flag','!=',1],['kanji', 'like', '%'.$bunbo_key.'%']])
                                      ->get(['bunpo_id','image', 'hiragana', 'katakana', 'kanji', 'meaning', 'sound']);
        return $result->toArray();
    }

    //count total bunpou(back end)
    public function countBunpous()
    {
		$total = $this->model->where("deleted_flag",0)->count();
		return $total;
    } 
}