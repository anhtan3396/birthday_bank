<?php

namespace App\Repositories;
use App\Models\TRechargeHistory;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Schema;
use App\Models\Muser;
use App\Models\TTransaction;

class RechargeHistoryRepositories extends BaseRepository
{
    /**
     * Create a new QuizRepository instance.
     *
     * @param  App\Models\MTestMQuizQuiz $mBunpo
     * @return void
     */
    public function __construct(
        TRechargeHistory $tRechargeHistory
    ) 
    {
        $this->model = $tRechargeHistory;

    }
    //đổ dl vào backend
    public function getAllRecharges($search_query)
    {
        $recharge = $search_query->where("deleted_flag",0)->paginate(20);
        return $recharge;
    }
    public function insertRechargeHistory($data)
    {
        $recharge = new TRechargeHistory();
        $recharge -> user_id = $data["user_id"];
        $recharge -> recharge_type = $data["recharge_type"];
        $recharge -> money = $data["money"];
        $recharge -> coin = $data["coin"];
        $recharge -> recharge_time = $data["recharge_time"];
        $recharge -> deleted_flag = $data["deleted_flag"];
        if(!empty($data["card_type"]))
            $recharge -> card_type = $data["card_type"];
        $recharge->save();
    }
}