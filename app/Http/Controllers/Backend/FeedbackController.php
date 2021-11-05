<?php

namespace App\Http\Controllers\Backend;
use App\Models\MFeedback;
use App\Models\MUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\FeedbackRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\Feedback;
use DateTime;
class FeedbackController extends Controller
{
	public function index(Request $request,FeedbackRepository $feedbackRepository )
	{
		$email = $request->input('email');  
		$user = MUser::where('email',$email)->first();
		$date_f = $request->get('date-f');
		$date_t = $request->get('date-t');
		$search_query = MFeedback::query();
		if($email == "" || $date_f  != "")
		{
			if($email) {
					$search_query->Where('user_id',$user->user_id);
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

					$dayBefore = (new DateTime($date_f.' 00:00:00'))->modify('+1 day')->format('Y-m-d H:i:s');

					$search_query->where('created_time', '>=', $dayAfter);   
					$search_query->where('created_time', '<=', $dayBefore);

				}

			}
			$feedbacks = $feedbackRepository->getAllFeedback($search_query);
			return view("Backend.feedback.index_feedback",[
				'feedbacks' => $feedbacks,
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
					$search_query->whereDate('created_time', '<=', $date_t);
					$search_query->whereDate('created_time', '>=', $date_f) ;
				}else
				{
					$dayAfter = (new DateTime($date_f.' 23:59:59'))->modify('-1 day')->format('Y-m-d H:i:s');

					$dayBefore = (new DateTime($date_f.' 00:00:00'))->modify('+1 day')->format('Y-m-d H:i:s');

					$search_query->where('created_time', '>=', $dayAfter);   
					$search_query->where('created_time', '<=', $dayBefore);

				}

				}

				$feedbacks = $feedbackRepository->getAllFeedback($search_query);
				return view("Backend.feedback.index_feedback",[
					'feedbacks' => $feedbacks,
					'email' => $email,
					'oldDate_f' => $date_f,
					'oldDate_t' => $date_t
					]);
			}
			else
			{	
				$feedbacks = MFeedback::where("deleted_flag",0)->paginate(20);
				return view("Backend.feedback.index_feedback",[
					'feedbacks' => $feedbacks,
					'email' => $email,
					'oldDate_f' => $date_f,
					'oldDate_t' => $date_t
					])->withErrors(['error' => "Xin lỗi, yêu cầu của bạn không tìm thấy. Vui lòng nhập đúng đối tượng cần tìm!"]);
			}
		}
		
	}
	public function detailFeedback($id, FeedbackRepository $feedbackRepository)
	{
		$validator = Validator::make(['feedback_id' => $id], [
			'feedback_id'   => 'exists:m_feedback,feedback_id'
			], [
			'feedback_id.require'   =>'Không tồn tại feedback',
			]);
		if ($validator->fails())
		{
			return redirect()->back();
		}
		else
		{
			$feedbacks = $feedbackRepository->find((int)$id);
			return view('Backend.feedback.detail_feedback', ['feedbacks' => $feedbacks]);  
		}
	}

	//destroy a mail
	public function destroyFeedback($id, FeedbackRepository $feedbackRepository)
	{
        //update delete_flag

		$feedbackRepository->update(
			[
			"deleted_flag"          => 1, 
			],
			$id,
			"feedback_id"
			);
		return redirect()->back();
	}

    //delete multi mail
	public function deleteallFeedback(Request $rq, FeedbackRepository $feedbackRepository) 
	{
        //get list quiz choosed 
		$list_id = $rq->get('list_id');
		foreach ($list_id as $id) {
            //update delete_flag
			$feedbackRepository->update(
				[
				"deleted_flag"          => 1,

				],
				$id,
				"feedback_id"
				);
		}
		return redirect()->back();
	}

	public function reply($id, FeedbackRepository $feedbackRepository){
		$validator = Validator::make(['feedback_id' => $id], [
			'feedbacks'   => 'exists:feedback_id'
			], [
			'feedback_id.required'      => 'Không tồn tại feedbacks',
			]);
		if ($validator->fails())
		{
			return redirect()->back();
		}
		else
		{
			$feedbacks = $feedbackRepository->find((int)$id);
			return view('Backend.feedback.reply_feedback', ['feedbacks' => $feedbacks]);  
		}
	}

	public function updateReply($id,Request $request, FeedbackRepository $feedbackRepository,UserRepository $userRepository){
		$user = $feedbackRepository->getUserId($id);
		$validator = Validator::make($request->all(), [
			'topic'       				=>'required|max:255',
			'content_reply'             =>'required|max:1000',   
			],
			[ 
			'topic.required'            => 'Vui lòng nhập tiêu đề.',
			'topic.max'             	=> 'Độ dài tiêu đề vượt quá số kí tự cho phép.',
			'content_reply.required'    => 'Vui lòng nhập nội dung phản hồi.',
			'content_reply.max'         => 'Độ dài phản hồi vượt quá số kí tự cho phép.',
			]);


		if ($validator->fails())
		{

			return redirect()->back()->withErrors($validator)->withInput();
		}
		else{

			$feedback  = $feedbackRepository->update(
				[
				"topic"                       			=> $request->get('topic'),
				"content_reply"                       	=> $request->get('content_reply'),
				"updated_time"                       	=> date('Y-m-d h:i:s')
				],$id,"feedback_id");
			
			$email = MUser::find((int) $user->user_id)->email;
			Mail::to($email)->send(new Feedback($email,$request->get('content_reply')));
			return redirect('feedbacks');
		}
		

	}

}
