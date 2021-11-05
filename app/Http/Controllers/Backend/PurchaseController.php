<?php

namespace App\Http\Controllers\Backend;
use App\Models\TPurchase;
use App\Models\MUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PurchaseRepository;
use Illuminate\Support\Facades\Validator;
use DateTime;
class PurchaseController extends Controller
{
	public function purchase(Request $request,PurchaseRepository $purchaseRepository )
	{
		$email = $request->input('email');  
		$user = MUser::where('email',$email)->first();
		$date_f = $request->get('date-f');
		$date_t = $request->get('date-t');
		$search_query = TPurchase::query();
		if($email == "" || $date_f  != "")
		{
			if($email) {
				$search_query->Where('user_id',$user->user_id);
			}
			if($date_f)
			{
				if($date_t)
				{
					$search_query->whereDate('purchase_time', '<=', $date_t);
					$search_query->whereDate('purchase_time', '>=', $date_f) ;
				}else
				{
					$dayAfter = (new DateTime($date_f.' 23:59:59'))->modify('-1 day')->format('Y-m-d H:i:s');

					$dayBefore = (new DateTime($date_f.' 00:00:00'))->modify('+1 day')->format('Y-m-d H:i:s');

					$search_query->where('purchase_time', '>=', $dayAfter);   
					$search_query->where('purchase_time', '<=', $dayBefore);

				}
			}
			$purchases = $purchaseRepository->getAllPurchase($search_query);
			return view('Backend.histories.purchase',[
				'purchases' => $purchases,
				'email' => $email,
				'oldDate_f' => $date_f,
				'oldDate_t' => $date_t
				]);	
		}
		else
		{
			if($user)
			{
				if($email) {
					$search_query->Where('user_id',$user->user_id);
				}
				if($date_f)
				{
					if($date_t)
					{
						$search_query->whereDate('purchase_time', '<=', $date_t);
						$search_query->whereDate('purchase_time', '>=', $date_f) ;
					}else
					{
						$dayAfter = (new DateTime($date_f.' 23:59:59'))->modify('-1 day')->format('Y-m-d H:i:s');

						$dayBefore = (new DateTime($date_f.' 00:00:00'))->modify('+1 day')->format('Y-m-d H:i:s');

						$search_query->where('purchase_time', '>=', $dayAfter);   
						$search_query->where('purchase_time', '<=', $dayBefore);

					}

				}

				$purchases = $purchaseRepository->getAllPurchase($search_query);
				return view('Backend.histories.purchase',[
					'purchases' => $purchases,
					'email' => $email,
					'oldDate_f' => $date_f,
					'oldDate_t' => $date_t
					]);
			}
			else
			{	
				$purchases = TPurchase::where("deleted_flag",0)->paginate(20);
				return view('Backend.histories.purchase',[
					'purchases' => $purchases,
					'email' => $email,
					'oldDate_f' => $date_f,
					'oldDate_t'	=> $date_t
					])->withErrors(['error' => "Xin lỗi, yêu cầu của bạn không tìm thấy. Vui lòng nhập đúng đối tượng cần tìm!"]);
			}
		}
	}
	
	//detail purchase
	public function detailPurchase($id, PurchaseRepository $purchaseRepository)
	{
		$validator = Validator::make(['id' => $id], [
			'id'   => 'exists:t_purchase,id'
			], [
			'id.exists'   =>'Không tồn tại lịch sử mua hàng',
			]);
		if ($validator->fails())
		{
			return redirect()->back();
		}
		else
		{
			$purchases = $purchaseRepository->find((int)$id);
			return view('Backend.histories.detail_purchase', ['purchases' => $purchases]);  
		}
	}
	
	//destroy a purchase
	public function destroyPurchase($id, PurchaseRepository $purchaseRepository)
	{
        //update delete_flag

		$purchaseRepository->update(
			[
			"deleted_flag"          => 1, 
			],
			$id,
			"id"
			);
		return redirect()->back();
	}

    //delete multi purchase
	public function deleteallPurchase(Request $rq, PurchaseRepository $purchaseRepository) 
	{
        //get list quiz choosed 
		$list_id = $rq->get('list_id');
		foreach ($list_id as $id) {
            //update delete_flag
			$purchaseRepository->update(
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
