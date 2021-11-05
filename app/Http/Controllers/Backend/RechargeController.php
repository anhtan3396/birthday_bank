<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\TRechargeHistory;
use App\Models\MUser;
use App\Http\Controllers\Controller;
use App\Repositories\RechargeHistoryRepositories;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Carbon\Carbon;
use App\Utils\SessionManager;
use App\Redirect;
use App\Repositories\UserRepository;
use App\Repositories\TransactionRepository ;
use GuzzleHttp\Client;
use App\Repositories\SettingRepository;
class RechargeController extends Controller
{
    public function recharge(Request $request,RechargeHistoryRepositories $rechargeHistoryRepositories)
    {
        $email = $request->input('email');
        $date_f = $request->get('date-f');
        $date_t = $request->get('date-t');
        $user = MUser::where('email',$email)->first();
		$search_query = TRechargeHistory::query();
		if($email == "" || $date_f  != "")
		{
			if($email) {
				$search_query->Where('user_id',$user->user_id);
			}
			if($date_f)
			{
				if($date_t)
				{
					$search_query->whereDate('recharge_time', '<=', $date_t);
					$search_query->whereDate('recharge_time', '>=', $date_f) ;
				}else
				{
					$dayAfter = (new DateTime($date_f.' 23:59:59'))->modify('-1 day')->format('Y-m-d H:i:s');

					$dayBefore = (new DateTime($date_f.' 00:00:00'))->modify('+1 day')->format('Y-m-d H:i:s');

					$search_query->where('recharge_time', '>=', $dayAfter);   
					$search_query->where('recharge_time', '<=', $dayBefore);

				}
			}
			$recharges = $rechargeHistoryRepositories->getAllRecharges($search_query);
			return view('Backend.histories.recharge',[
				'recharges' => $recharges,
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
						$search_query->whereDate('recharge_time', '<=', $date_t);
						$search_query->whereDate('recharge_time', '>=', $date_f) ;
					}else
					{
						$dayAfter = (new DateTime($date_f.' 23:59:59'))->modify('-1 day')->format('Y-m-d H:i:s');

						$dayBefore = (new DateTime($date_f.' 00:00:00'))->modify('+1 day')->format('Y-m-d H:i:s');

						$search_query->where('recharge_time', '>=', $dayAfter);   
						$search_query->where('recharge_time', '<=', $dayBefore);

					}

				}

				$recharges = $rechargeHistoryRepositories->getAllRecharges($search_query);
				return view('Backend.histories.recharge',[
					'recharges' => $recharges,
					'email' => $email,
					'oldDate_f' => $date_f,
					'oldDate_t' => $date_t
					]);	
			}
			else
			{	
				$recharges = TRechargeHistory::where("deleted_flag",0)->paginate(20);
				return view('Backend.histories.recharge',[
					'recharges' => $recharges,
					'email' => $email,
					'oldDate_f' => $date_f,
					'oldDate_t'	=> $date_t
					])->withErrors(['error' => "Xin lỗi, yêu cầu của bạn không tìm thấy. Vui lòng nhập đúng đối tượng cần tìm!"]);
			}
		}

    }

    //detail recharge
	public function detailRecharge($id, RechargeHistoryRepositories $rechargeHistoryRepositories)
	{
		$validator = Validator::make(['id' => $id], [
			'id'   => 'exists:t_recharge_history,id'
			], [
			'id.exists'   =>'Không tồn tại lịch sử nạp tiền',
			]);
		if ($validator->fails())
		{
			return redirect()->back();
		}
		else
		{
			$recharges = $rechargeHistoryRepositories->find((int)$id);
			return view('Backend.histories.detail_recharge', ['recharges' => $recharges]);  
		}
	}

    public function destroyRecharge($id, RechargeHistoryRepositories $rechargeHistoryRepositories)
    {
        $rechargeHistoryRepositories->update(
            [
                "deleted_flag"          => 1, 
            ],
            $id,
            "id"
        );
        return redirect()->back();

    }

	//delete multi
	public function deleteall(Request $rq, RechargeHistoryRepositories $rechargeHistoryRepositories) 
    {
        //get list quiz choosed 
        $list_id = $rq->get('list_id');
        foreach ($list_id as $id) {
            //update delete_flag
            $rechargeHistoryRepositories->update(
                [
                    "deleted_flag"          => 1,
                    
                ],
                $id,
                "id"
            );
        }
        return redirect()->back();
    }







    ///////////////////////////////////////////////////
    // son recharge card payment
    // các thao tác bên onepay không làm nữa nhưng không xóa
    public function payOnline (Request $request  , UserRepository $user ,SettingRepository $setting)
    {
    	// RECHARGE_FLAG 0 là ẩn recharge 
    	// RECHARGE_FLAG 1 là hiện recharge
    	if(strcmp($setting ->getSetting("RECHARGE_FLAG")["s_value"], 1)==0)
    	{
    		// 0 là không có user id 
	    	// 2 là user_id và api_token không phù hợp
	    	if(!empty($_GET["user_id"]) && !empty($_GET["api_token"]) && !empty($_GET["nick_name"]))
	    	{
	    		if(strcmp($user->check_API_token_Test($_GET["user_id"], $_GET["api_token"])["api_token"], $_GET["api_token"]) == 0)
		    	{	
		    		session(["r_user_id"=>$_GET["user_id"],"r_nick_name"=>$_GET["nick_name"],"r_api_token"=>$_GET["api_token"]]);
		    		return view('Backend.recharge.payOnline');
		    	}
		    	else
	    			return 2;
	    	}
	    	else
	    		return 0;	
    	}
    	else
    		return "Chi tiết vui lòng liên hệ email ngotranminhthao0302@gmail.com";	    	
    }
 //    public function rechargeCarpayment(Request $request , RechargeHistoryRepositories $recharge , UserRepository $user , TransactionRepository $transaction)
 //    {
 //    	// 0 là không có user id 
 //    	// 2 là user_id và api_token không phù hợp
 //    	if(!empty(session('r_user_id')) && !empty(session('r_api_token')))
 //    	{
 //    		if(count($user->getUser(session('r_user_id') ,session('r_api_token'))) > 0 )
	//     	{
	//     		$this->validate($request , [
	//     		"lstTelco" => "required",
	//     		"txtCode" => "required",
	//     		"txtSeri" => "required"
	// 	    	],[
	// 	    		"lstTelco.required" => "Bạn phải chọn nhà mạng",
	// 	    		"txtCode.required" => "Bạn phải nhập mã code ",
	// 	    		"txtSeri.required" => "Bạn phải nhập số serial",
	// 	    	]);
	// 	    	$result_recharge = $this->doRecharge();
	// 	    	$curent_time = Carbon::now();
	// 			$user_id =  $user->getUser(session('r_user_id') ,session('r_api_token'));
	// 			// $mount = $result_recharge["amount"];
	// 			$amount = "100000";
	// 			$recharge_type = "Thẻ cào";

	// 			//recharge_type  = 1 là thanh toán bằng thẻ cào
	// 			//recharge_type  = 2 là thanh toán bằng local bank
	// 			//recharge_type  = 3 là thanh toán bằng vtc

	// 			// trans_type 1 là Thẻ cào
	// 			// trans_type 2 la Local bank
	// 			// trans_type 3 là VTC
	// 			$data = array('recharge_type' => "1" , "order_id"=>$_POST["txtOrderID"],"trans_type"=>"1" ,'card_type'=>"NULL", 'money' => $amount , 'coin' => $amount/1000 , 'recharge_time' => $curent_time , 'user_id' => $user_id["user_id"]  , 'deleted_flag'=>0, "transId"=>$result_recharge["transId"], "status"=>$result_recharge["status"]);
	// 			if(strcmp($result_recharge["status"], "07") == 0)
	// 			{	
	// 				$user->updateCoin($data);
	// 				$transaction->insertTransaction($data);
	// 				$recharge->insertRechargeHistory($data);
	// 				return view("Backend.recharge.payConfirm",compact(["amount","user_id","recharge_type"]));	
	// 			}
	// 			else{
	// 				$transaction->insertTransaction($data);
	// 				return redirect()->back()->with(["flash_level"=>"danger", "flash_message"=>$result_recharge["description"]]);
	// 			}			
	//     	}
	//     	else
 //    			return 2;
 //    	}
 //    	else
 //    		return 0;
 //    }
 //    public function getGUID(){
	//     if (function_exists('com_create_guid')){
	//         return com_create_guid();
	//     }else{
	//         mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	//         $charid = strtoupper(md5(uniqid(rand(), true)));
	//         $uuid =
	//             substr($charid, 0, 8)
	//             .substr($charid, 8, 4)
	//             .substr($charid,12, 4)
	//             .substr($charid,16, 4)
	//             .substr($charid,20,12);
	//         return $uuid;
	//     }
	// }
 //    public function execPostRequest($url, $data)
	// {

	// 	 // open connection
	// 	 $ch = curl_init();
	// 	 // set the url, number of POST vars, POST data
	// 	 curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,0); 
	// 	 curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
	// 	 curl_setopt($ch, CURLOPT_URL, $url);
	// 	 curl_setopt($ch, CURLOPT_POST, 1);
	// 	 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	// 	 curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	// 	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// 	 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	// 	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// 	 // execute post
	// 	 $result = curl_exec($ch);

	// 	 // close connection
	// 	 curl_close($ch);
	// 	 	return $result;
	// }
	// public function doRecharge()
	// {
	// 	$transRef = $this->getGUID(); //merchant's transaction reference
	// 	$access_key = 'd81jac7jwusmsof5m50x'; //require your access key from 1pay
	// 	$secret = 'boz76sgx3sq028lcxq9zolfnkjqeo8ok'; //require your secret key from 1pay
	// 	$type = $_POST["lstTelco"]; 
	// 	$pin = $_POST["txtCode"];
	// 	$serial = $_POST["txtSeri"]; 
	// 	$data = "access_key=" . $access_key . "&pin=" . $pin . "&serial=" . $serial . "&transRef=" . $transRef . "&type=" . $type;
	// 	$signature = hash_hmac("sha256", $data, $secret);
	// 	$data.= "&signature=" . $signature;
	// 	//do some thing
	// 	 $json_cardCharging = $this->execPostRequest('https://api.1pay.vn/card-charging/v5/topup', $data);
	// 	 $decode_cardCharging=json_decode($json_cardCharging,true);  // decode json
	// 	 if (isset($decode_cardCharging)) {
	// 		 $description = $decode_cardCharging["description"];   // transaction description
	// 		 $status = $decode_cardCharging["status"];       
	// 		 $amount = $decode_cardCharging["amount"];       // card's amount
	// 		 $transId = $decode_cardCharging["transId"]; 
	// 		// x? l? d? li?u c?a merchant
	// 		return $decode_cardCharging;
	// 	}
	// 	else {
	// 		// run query API's endpoint
	// 	    $data_ep = "access_key=" . $access_key . "&pin=" . $pin . "&serial=" . $serial . "&transId=&transRef=" . $transRef . "&type=" . $type;
	// 	    $signature_ep = hash_hmac("sha256", $data_ep, $secret);
	// 	    $data_ep.= "&signature=" . $signature_ep;
	// 	    $query_api_ep = $this->execPostRequest('https://api.1pay.vn/card-charging/v5/query', $data_ep);
	// 	    $decode_cardCharging=json_decode($json_cardCharging,true);  // decode json
	// 	    $description_ep = $decode_cardCharging["description"];   // transaction description
	// 	    $status_ep = $decode_cardCharging["status"];    
	// 	    $amount_ep = $decode_cardCharging["amount"];       // card's amount
	// 		// Merchant handle SQL
	// 		return $decode_cardCharging;
	// 	}
	// }
	// // sử dụng local bank


	// public function payInfoBankCharging(Request $request   , UserRepository $user)
	// {
	// 	// 0 là không có user id 
 //    	// 2 là user_id và api_token không phù hợp
 //    	if(!empty(session('r_user_id')) && !empty(session('r_api_token')))
 //    	{
 //    		if(count($user->getUser(session('r_user_id') ,session('r_api_token'))) > 0 )
	//     	{
	// 			$this->validate($request , [
	// 				"amount" => "required",
	// 				"order_id" => "required",
	// 				"order_info" => "required"
	// 			],[
	// 				"amount.required" =>"Bạn phải nhập số tiền",
	// 				"order_id.required" =>  "Bạn chưa đăng nhập",
	// 				"order_info.required" => "Bạn phải nhập thông tin",
	// 			]);
	// 		   // $return_url = "http://vietlott.softworldvietnam.com/recharge/localbank/bank_result.php"; 
	// 		   $access_key = "d81jac7jwusmsof5m50x";           // require your access key from 1pay
	// 		   $secret = "boz76sgx3sq028lcxq9zolfnkjqeo8ok";               // require your secret key from 1pay
	// 		   $return_url = "http://jpn.softworldvietnam.com/recharge/payConfirmBankCharging"; 

	// 		   $command = 'request_transaction';
	// 		   $amount = $_POST['amount'];   // >10000
	// 		   $order_id = $_POST['order_id'];  
	// 		   $order_info = $_POST['order_info']; 
			   
	// 		   $data = "access_key=".$access_key."&amount=".$amount."&command=".$command."&order_id=".$order_id."&order_info=".$order_info."&return_url=".$return_url;
	// 		   $signature = hash_hmac("sha256", $data, $secret);
	// 		   $data.= "&signature=".$signature;
	// 		   $json_bankCharging = $this->execPostRequest('http://api.1pay.vn/bank-charging/service', $data);
	// 		   //Ex: {"pay_url":"http://api.1pay.vn/bank-charging/sml/nd/order?token=LuNIFOeClp9d8SI7XWNG7O%2BvM8GsLAO%2BAHWJVsaF0%3D", "status":"init", "trans_ref":"16aa72d82f1940144b533e788a6bcb6"}
	// 		   $decode_bankCharging=json_decode($json_bankCharging,true);  // decode json
	// 		   $pay_url = $decode_bankCharging["pay_url"];
	// 		   return redirect()->to($pay_url);
	//    		}
	//     	else
 //    			return 2;
 //    	}
 //    	else
 //    		return 0;
	// }
	// // sử dụng local bank
	// // hiện tại không còn sử dụng do Vtc đã làm được ngân hàng nội địa và nước ngoài  nhưng vẫn để 

	// public function payConfirmBankCharging(Request $request , RechargeHistoryRepositories $recharge  , UserRepository $user , TransactionRepository $transaction)
	// {
	//   $trans_ref = isset($_GET["trans_ref"]) ? $_GET["trans_ref"] : NULL;
	//   $response_code = isset($_GET["response_code"]) ? $_GET["response_code"] : NULL;
	  
	//   $access_key = "d81jac7jwusmsof5m50x";          
	//   $secret = "boz76sgx3sq028lcxq9zolfnkjqeo8ok";           
	//   $return_url = "http://jpn.softworldvietnam.com/recharge/payConfirmBankCharging"; 
	//   if($response_code == "00")
	//   {
	// 	   $command = "close_transaction";
	// 	   $data = "access_key=".$access_key."&command=".$command."&trans_ref=".$trans_ref;
	// 	   $signature = hash_hmac("sha256", $data, $secret);
	// 	   $data.= "&signature=" . $signature;
		   
	// 	   $json_bankCharging = $this->execPostRequest('http://api.1pay.vn/bank-charging/service', $data);

	// 	   $decode_bankCharging=json_decode($json_bankCharging,true);  // decode json
	// 	   // Ex: {"amount":10000,"trans_status":"close","response_time": "2014-12-31T00:52:12Z","response_message":"Giao d?ch thành công","response_code":"00","order_info":"test dich vu","order_id":"001","trans_ref":"44df289349c74a7d9690ad27ed217094", "request_time":"2014-12-31T00:50:11Z","order_type":"ND"}
		   
	// 	   $response_message = $decode_bankCharging["response_message"];
	// 	   $response_code = $decode_bankCharging["response_code"];
	// 	   $amount = $decode_bankCharging["amount"];

	// 	   if($response_code == "00")
	// 	   {
	// 	   		// 0 là không có user id 
	// 	    	// 2 là user_id và api_token không phù hợp
	// 	    	if(!empty(session('r_user_id')) && !empty(session('r_api_token')))
	// 	    	{
	// 	    		if(count($user->getUser(session('r_user_id') ,session('r_api_token'))) > 0 )
	// 		    	{
	// 			    	$curent_time = Carbon::now();
	// 					$user_id =  $user->getUser(session('r_user_id') ,session('r_api_token'));
	// 					$amount = $_GET["amount"];
	// 					$recharge_type = "Local bank";
	// 					//recharge_type  = 1 là thanh toán bằng thẻ cào
	// 					//recharge_type  = 2 là thanh toán bằng local bank
	// 					//recharge_type  = 3 là thanh toán bằng vtc
	// 					$card_type = $_GET["card_name"];
	// 					if(strcmp($_GET["card_name"], "") == 0 )
	// 						$card_type = "NULL";

	// 					// trans_type 1 là Thẻ cào
	// 					// trans_type 2 la Local bank
	// 					// trans_type 3 là VTC
	// 					$data = array('recharge_type' => "2", "order_id"=>$_GET["order_id"],"trans_type"=>"2" ,'card_type'=>$card_type , 'money' => $amount , 'coin' => $amount/1000 , 'recharge_time' => $curent_time , 'user_id' => $user_id["user_id"]  , 'deleted_flag'=>0, "transId"=>$_GET["trans_ref"], "status"=>$response_code);					
	// 					$user->updateCoin($data);
	// 					$transaction->insertTransaction($data);
	// 					$recharge->insertRechargeHistory($data);
	// 					return view("Backend.recharge.payConfirm",compact("amount","user_id" , "recharge_type"));	
	// 				}
	// 	    		else
	// 					return 2;
	// 	    	}
	// 	    	else
	// 	    		return 0;
	// 	   }
	// 	    else
	// 	    {
	// 	    	$transaction->insertTransaction($data);
	// 			return $response_message;
	// 	    }
	//   }
	//   else	  {
	// 	return $response_code ;
	//   }		   
	// }
	public function getPayInfoBankVtc()
	{
		return view("Backend.recharge.payInfoBankVtc");
	}
	public function postPayInfoBankVtc(Request $request ,TransactionRepository $transaction)
	{
		$this->validate($request , [
				"txtOrderID"=>"required",
				"txtTotalAmount"=>"required",
				"txtusername"=>"required"
			],[
				"txtOrderID.required" =>"Bạn phải đăng nhập",
				"txtTotalAmount.required" =>"Bạn phải nhập số tiền",
				"txtusername.required"=>"Bạn phải đăng nhập"
			]);
		if ($_POST) {       
			$destinationUrl="https://pay.vtc.vn/cong-thanh-toan/checkout.html";
			$plaintext = $_POST["txtWebsiteID"] . "-" . $_POST["txtCurency"] . "-" . $_POST["txtOrderID"] . "-" . $_POST["txtTotalAmount"] . "-" . $_POST["txtReceiveAccount"] . "-" . $_POST["txtParamExt"] . "-" . $_POST["txtSecret"]. "-" . $_POST["txtUrlReturn"];
			echo $plaintext."|||";
			$sign = strtoupper(hash('sha256', $plaintext));

			$data = "?website_id=" . $_POST["txtWebsiteID"] . "&payment_method=" . $_POST["txtCurency"] . "&order_code=" . $_POST["txtOrderID"] . "&amount=" . $_POST["txtTotalAmount"] . "&receiver_acc=" .  $_POST["txtReceiveAccount"]. "&urlreturn=" .  urlencode($_POST["txtUrlReturn"]);

			$customer_first_name = htmlentities($_POST["txtCustomerFirstName"]);
			$customer_last_name = htmlentities($_POST["txtCustomerLastName"]);
			$bill_to_address_line1 = htmlentities($_POST["txtBillAddress1"]);
			$bill_to_address_line2 = htmlentities($_POST["txtBillAddress2"]);
			$city_name = htmlentities($_POST["txtCity"]);
			$address_country = htmlentities($_POST["txtCountry"]);
			$customer_email = htmlentities($_POST["txtCustomerEmail"]);
			$order_des = htmlentities($_POST["txtDescription"]);
			$data = $data . "&customer_first_name=" . $customer_first_name. "&customer_last_name=" . $customer_last_name. "&customer_mobile=" . $_POST["txtCustomerMobile"]. "&bill_to_address_line1=" . $bill_to_address_line1. "&bill_to_address_line2=" . $bill_to_address_line2. "&city_name=" . $city_name. "&address_country=" . $address_country. "&customer_email=" . $customer_email . "&order_des=" . $order_des . "&param_extend=" . $_POST["txtParamExt"] . "&sign=" . $sign."&l = en";
			$destinationUrl = $destinationUrl . $data;
			if($transaction->checkExists($_POST["txtOrderID"]))
				return redirect()->back()->with(["flash_level"=>"danger", "flash_message"=>"Có lỗi xảy ra"]);
	    	else
	    		return redirect()->to($destinationUrl);		
		    	
		}		
	}
	public function getPayConfirmBankVtc(Request $request, RechargeHistoryRepositories $recharge  ,  UserRepository $user ,TransactionRepository $transaction , SettingRepository $setting)
	{
		if(!empty($_GET["website_id"]))
		{
			$secret_key= "ttnVmW554DMMkPpe";
			$websiteid = $_GET["website_id"];
			$status = "";
			$reference_number = "";
			$amount = "";
			$sign = "";
			$data = "";
			$mysign = "";
			
			// Dành cho test
			if($websiteid=="637")
			{
				$status = $_GET["status"];
				$reference_number=$_GET["reference_number"];
				$amount = $_GET["amount"];
				$sign = $_GET["signature"];
				$data = $status . "-" . $websiteid . "-" . $reference_number . "-" . $amount. "-" . $secret_key;
				$mysign = strtoupper(hash('sha256', $data));
			}
			else
			{
				$amount = $_GET["amount"];
				$message = $_GET["message"];
				$payment_type=$_GET["payment_type"];
				$reference_number=$_GET["reference_number"];
				$status = $_GET["status"];
				$trans_ref_no = $_GET["trans_ref_no"];
				$sign = $_GET["signature"];

				$data = $amount . "-" . $message . "-" . $payment_type . "-" . $reference_number. "-" . $status. "-" . $trans_ref_no. "-" . $websiteid;
				$plaintext = $amount . "|" . $message . "|" . $payment_type . "|" . $reference_number. "|" . $status. "|" . $trans_ref_no. "|" . $websiteid. "|" . $secret_key;
				$mysign = strtoupper(hash('sha256', $plaintext));
			}
			$curent_time = Carbon::now();
			$user_id =  "";
			$payment_type = "";
			if(strcmp($_GET["payment_type"], "") == 0 )
				$payment_type = "NULL";
			$recharge_type = "Ngân hàng";
			$amount = "";
			$data = "";
			// 0 là không có user id 
	    	// 2 là user_id và api_token không phù hợp
	    	if(!empty(session('r_user_id')) && !empty(session('r_api_token')))
	    	{
	    		if(count($user->getUser(session('r_user_id') ,session('r_api_token'))) > 0 )
		    	{
		    		//recharge_type  = 1 là thanh toán bằng thẻ cào
					//recharge_type  = 2 là thanh toán bằng local bank
					//recharge_type  = 3 là thanh toán bằng vtc
					// trans_type 1 là Thẻ cào
					// trans_type 2 la Local bank
					// trans_type 3 là VTC
			        $curent_time = Carbon::now();
					$user_id =  $user->getUser(session('r_user_id') ,session('r_api_token'));
					$payment_type = $_GET["payment_type"];
					if(strcmp($_GET["payment_type"], "") == 0 )
						$payment_type = "NULL";
					$recharge_type = "Ngân hàng";
					$amount = $_GET["amount"];
					$recharge_convert_rate = $setting->getSetting("RECHARGE_CONVERT_RATE");
					$data = array('recharge_type' => "3", "order_id"=>$_GET["reference_number"],"trans_type"=>"3",'card_type'=>$payment_type , 'money' => $amount , 'coin' => $amount/$recharge_convert_rate["s_value"],'recharge_time' => $curent_time , 'user_id' => $user_id["user_id"]  , 'deleted_flag'=>0, "transId"=>$_GET["trans_ref_no"], "status"=>$status);
				}
		    	else
	    			return 2;
	    	}
	    	else
	    		return 0;
			if($mysign != $sign){
	            return -1;
	        }
			else
			{
				if($status == 1)
	            {		
					$user->updateCoin($data);
					$transaction->insertTransaction($data);
					$recharge->insertRechargeHistory($data);
					return view("Backend.recharge.payConfirm",compact("amount","user_id" , "recharge_type"));	
	            }
	            else{
		    		//$user->updateCoin($data);
					$transaction->insertTransaction($data);
					//$recharge->insertRechargeHistory($data);
					//return view("Backend.recharge.payConfirm",compact("amount","user_id" , "recharge_type"));	
					if(strcmp($_GET["message"], "") ==0)
				   		return redirect()->back()->with(["flash_level"=>"danger","flash_message"=>"Nạp tiền không thành công"]);
			        else
						return redirect()->back()->with(["flash_level"=>"danger","flash_message"=>$_GET["message"]]);
	            }
			}	
		}
		
	}
	public function getPayInfoCardVtc()
	{
		return view("Backend.recharge.payInfo");
	}	
	public function postPayConfirmCardVtc(Request $request , RechargeHistoryRepositories $recharge , UserRepository $user , TransactionRepository $transaction , SettingRepository $setting)
    {
    	$this->validate($request , [
    		"lstTelco" => "required",
    		"txtCode" => "required",
    		"txtSeri" => "required",
    		"txtUserName"=>"required"
    	],[
    		"lstTelco.required" => "Bạn phải chọn nhà mạng",
    		"txtCode.required" => "Bạn phải nhập mã code ",
    		"txtSeri.required" => "Bạn phải nhập số serial",
    		"txtUserName.required" => "Bạn phải đăng nhập",
    	]);
    	// 0 là không có user id 
    	// 2 là user_id và api_token không phù hợp
    	if(!empty(session('r_user_id')) && !empty(session('r_api_token')))
    	{
    		if(count($user->getUser(session('r_user_id') ,session('r_api_token'))) > 0 )
	    	{
		    	$curent_time = Carbon::now();
				$user_id =  $user->getUser(session('r_user_id') ,session('r_api_token'));
				 $client = new Client();
				$params =  [
		            	'FunctionName' => "UseCard",
		                'CardSerial' => $_POST["txtSeri"],
		                'CardCode' => $this->Encrypt($_POST["txtCode"] , "4b13a81dd5bd8d4799ea334cb0b2061a"),
		                'PartnerCode'=>"665480",
		                "CardType"=>$_POST["lstTelco"],
		                "TransID"=>$_POST["txtOrderID"],
		                "AccountName"=>$_POST["txtUserName"],
		                "ExtentionData"=>"",
	          	    	"Amount"=>$_POST["cboamount"],
			    		'timeout' => 5,
						'connect_timeout' => 5		            
			   ];
			   if($transaction->checkExists($_POST["txtOrderID"]))
			   		return redirect()->back()->with(["flash_level"=>"danger", "flash_message"=>"Có lỗi xảy ra"]);
			    else
			    	$res = $client->post('http://api.vtcebank.vn:8888/VTCCardAPI/Card', [
			            'json' => $params
			        ]);
		        $result_recharge = json_decode($res->getBody(),true);
		        $ret_amount  = $this->Decrypt($result_recharge["DataInfo"],"4b13a81dd5bd8d4799ea334cb0b2061a");
				$amount = $ret_amount;
				//$amount = "100000";
				$recharge_type = "Thẻ cào";

				//recharge_type  = 1 là thanh toán bằng thẻ cào
				//recharge_type  = 2 là thanh toán bằng local bank
				//recharge_type  = 3 là thanh toán bằng vtc
				// trans_type 1 là Thẻ cào
				// trans_type 2 la Local bank
				// trans_type 3 là VTC
				$recharge_convert_rate = $setting->getSetting("RECHARGE_CONVERT_RATE");
				$data = array('recharge_type' => "1" , "order_id"=>$_POST["txtOrderID"],"trans_type"=>"1" ,'card_type'=>$_POST["lstTelco"], 'money' => $amount , 'coin' => $amount/$recharge_convert_rate["s_value"] , 'recharge_time' => $curent_time , 'user_id' => $user_id["user_id"]  , 'deleted_flag'=>0, "transId"=>$_POST["txtOrderID"], "status"=>$result_recharge["Status"]);
				if(strcmp($result_recharge["Status"], "1") == 0)
				{	
					$user->updateCoin($data);
					$transaction->insertTransaction($data);
					$recharge->insertRechargeHistory($data);
					return view("Backend.recharge.payConfirm",compact(["amount","user_id","recharge_type"]));	
				}
				else{
					$transaction->insertTransaction($data);
					return redirect()->back()->with(["flash_level"=>"danger", "flash_message"=>$result_recharge["Description"]]);
				}			
	    	}
	    	else
    			return 2;
    	}
    	else
    		return 0;
    }
    public function Encrypt($input, $key_seed)
	{
	    $input   = trim($input);
	    $block   = mcrypt_get_block_size('tripledes', 'ecb');
	    $len     = strlen($input);
	    $padding = $block - ($len % $block);
	    $input .= str_repeat(chr($padding), $padding);
	    // generate a 24 byte key from the md5 of the seed  
	    $key            = substr(md5($key_seed), 0, 24);
	    $iv_size        = mcrypt_get_iv_size(MCRYPT_TRIPLEDES, MCRYPT_MODE_ECB);
	    $iv             = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    // encrypt  
	    $encrypted_data = mcrypt_encrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, $iv);
	    // clean up output and return base64 encoded  
	    return base64_encode($encrypted_data);
	} //end function Encrypt() 
	public function Decrypt($input, $key_seed)
	{
	    $input   = base64_decode($input);
	    $key     = substr(md5($key_seed), 0, 24);
	    $text    = mcrypt_decrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, '12345678');
	    $block   = mcrypt_get_block_size('tripledes', 'ecb');
	    $packing = ord($text{strlen($text) - 1});
	    if ($packing and ($packing < $block)) {
	        for ($P = strlen($text) - 1; $P >= strlen($text) - $packing; $P--) {
	            if (ord($text{$P}) != $packing) {
	                $packing = 0;
	            }
	        }
	    }
	    $text = substr($text, 0, strlen($text) - $packing);
	    return $text+"";
	}
	public function payCancel(Request $request)
	{
		
	}
}
