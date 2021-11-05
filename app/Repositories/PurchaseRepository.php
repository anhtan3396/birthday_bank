<?php

namespace App\Repositories;
use App\Models\TPurchase;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Schema;

class PurchaseRepository extends BaseRepository
{
    public function __construct(TPurchase $mPurchase)
    {
        $this->model = $mPurchase;
    }

    public function getAllPurchase($search_query)
    {
        $purchase = $search_query->where("deleted_flag", 0)->paginate(20);
        return $purchase;
    }

    public function getAll()
    {
        $pur = $this->model->all();
        return $pur->toArray();
    }

    public function insertPurchase($data)
    {
        return $this->model->insert([
            'user_id' => $data['user_id'],
            'purchase_item_type' => $data['purchase_item_type'],
            'purchase_item_id' => $data['purchase_item_id'],
            'purchase_coin' => $data['purchase_coin'],
            'purchase_time' => $data['purchase_time'],
            'deleted_flag' => $data['deleted_flag'],
            'created_user' => $data['created_user'],
            'created_time' => $data['created_time'],
            'updated_user' => $data['updated_user'],
            'updated_time' => $data['updated_time']
        ]);
    }

    public function getId($id)
    {
        $purchase = $this->model->where("id", $id)->first();
        return $purchase;
    }

    public static function findPurchase($id)
    {
        $userField = 'id';
        return TPurchase::where($userField, $id)->get();
    }

    public function createPurchase($data)
    {
        return $this->model->insert($data);
    }
}