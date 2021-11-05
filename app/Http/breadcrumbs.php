<?php

use App\Models\MUser;
use App\Models\MQuiz;
use App\Models\MTest;
use App\Models\MVideo;
use App\Models\MBunpo;
use App\Models\MFeedback;
use App\Models\TPurchase;
use App\Models\TRechargeHistory;
use App\Models\MSetting;
//Dashboard
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Trang chủ', route('home'));
});

//Dashboard > Users 
Breadcrumbs::register('users', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Người dùng', route('users'));
});

//Dashboard > Users > Add new
Breadcrumbs::register('add', function($breadcrumbs)
{
    $breadcrumbs->parent('users');
    $breadcrumbs->push('Tạo mới người dùng', route('add'));
});

//Dashboard > Users > Edit
Breadcrumbs::register('edit', function($breadcrumbs, $id)
{
    $user = MUser::find($id);
    $breadcrumbs->parent('users');
    $breadcrumbs->push('Chỉnh sửa người dùng '. $user->Username, route('edit', $user->id));
});

//Dashboard > Users > user
Breadcrumbs::register('profile', function($breadcrumbs, $id)
{
    $user = MUser::find($id);
    $breadcrumbs->parent('users');
    $breadcrumbs->push($user->Username."Thông tin chi tiết", route('profile', $user->id));
});

//Dashboard > quizs 
Breadcrumbs::register('quizs', function($breadcrumbs)
{   
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Danh sách câu hỏi', route('quizs'));
});

//Dashboard > quizs > add
Breadcrumbs::register('addQuiz', function($breadcrumbs)
{
    $breadcrumbs->parent('quizs');
    $breadcrumbs->push('Tạo mới câu hỏi', route('addQuiz'));
});

//Dashboard > quizs > edit
Breadcrumbs::register('editQuiz', function($breadcrumbs, $id)
{
    $quiz = MQuiz::find($id);
    $breadcrumbs->parent('quizs');
    $breadcrumbs->push('Chỉnh sửa câu hỏi thứ '. $quiz->quiz_id, route('editQuiz', $quiz->quiz_id));
});

//Dashboard > quizs > detail
Breadcrumbs::register('detailQuiz', function($breadcrumbs, $id)
{
    $quiz = MQuiz::find($id);
    $breadcrumbs->parent('quizs');
    $breadcrumbs->push('Chi tiết câu hỏi thứ '. $quiz->quiz_id, route('detailQuiz', $quiz->quiz_id));
});

//Dashboard > test
Breadcrumbs::register('tests', function($breadcrumbs)
{   
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Danh sách bài kiểm tra', route('tests'));
});

//Dashboard > test > add
Breadcrumbs::register('addTest', function($breadcrumbs)
{
    $breadcrumbs->parent('tests');
    $breadcrumbs->push('Tạo mới bài kiểm tra', route('addTest'));
});

//Dashboard > test > edit
Breadcrumbs::register('editTest', function($breadcrumbs, $id)
{
    $test = MTest::find($id);
    $breadcrumbs->parent('tests');
    $breadcrumbs->push('Chỉnh sửa bài kiểm tra'. $test->test, route('editTest', $test->test_id));
});

//Dashboard > test > detail
Breadcrumbs::register('detailTest', function($breadcrumbs, $id)
{
    $test = MTest::find($id);
    $breadcrumbs->parent('tests');
    $breadcrumbs->push('Chi tiết bài kiểm tra '. $test->test, route('detailTest', $test->test_id));
});
//Dashboard > bunpos 
Breadcrumbs::register('bunpos', function($breadcrumbs)
{   
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Danh sách từ vựng', route('bunpos'));
});

//Dashboard > bunpos > add
Breadcrumbs::register('addBunpo', function($breadcrumbs)
{
    $breadcrumbs->parent('bunpos');
    $breadcrumbs->push('Tạo mới từ vựng', route('addBunpo'));
});

//Dashboard > bunpos > edit
Breadcrumbs::register('editBunpo', function($breadcrumbs, $id)
{
    $bunpo = MBunpo::find($id);
    $breadcrumbs->parent('bunpos');
    $breadcrumbs->push('Chỉnh sửa từ vựng thứ '. $bunpo->bunpo_id, route('editBunpo', $bunpo->bunpo_id));
});

//Dashboard > bunpos > detail
Breadcrumbs::register('detailBunpo', function($breadcrumbs, $id)
{
    $bunpo = MBunpo::find($id);
    $breadcrumbs->parent('bunpos');
    $breadcrumbs->push('Chi tiết từ vựng thứ '. $bunpo->bunpo_id, route('detailBunpo', $bunpo->bunpo_id));
});

//Dashboard > video 
Breadcrumbs::register('videos', function($breadcrumbs)
{   
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Danh sách video', route('videos'));
});

//Dashboard > video > add
Breadcrumbs::register('addVideo', function($breadcrumbs)
{
    $breadcrumbs->parent('videos');
    $breadcrumbs->push('Tạo mới video', route('addVideo'));
});
//Dashboard > video > edit
Breadcrumbs::register('editVideo', function($breadcrumbs, $id)
{
    $video = MVideo::find($id);
    $breadcrumbs->parent('videos');
    $breadcrumbs->push('Chỉnh sửa video thứ '. $video->video_id, route('editVideo', $video->video_id));
});

//Dashboard > video > detail
Breadcrumbs::register('detailVideo', function($breadcrumbs, $id)
{
    $video = MVideo::find($id);
    $breadcrumbs->parent('videos');
    $breadcrumbs->push('Chi tiết video thứ '. $video->video_id, route('detailVideo', $video->video_id));
});
//Dasgboard >mail
Breadcrumbs::register('feedbacks', function($breadcrumbs)
{   
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Danh sách phản hồi người dùng', route('feedbacks'));
});
//Dashboard > mail > detail
Breadcrumbs::register('detailFeedback', function($breadcrumbs, $id)
{
    $feedback = MFeedback::find($id);
    $breadcrumbs->parent('feedbacks');
    $breadcrumbs->push('Chi tiết phản hồi thứ '. $feedback->feedback_id, route('detailFeedback', $feedback->feedback_id));
});
//Dashboard > mail > reply
Breadcrumbs::register('reply', function($breadcrumbs, $id)
{
    $feedback = MFeedback::find($id);
    $breadcrumbs->parent('feedbacks');
    $breadcrumbs->push('Phản hồi thứ '. $feedback->feedback_id, route('reply', $feedback->feedback_id));
});

//Dashboard > top of month
Breadcrumbs::register('topOfMonth', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Bảng xếp hạng theo tháng', route('topOfMonth'));
});

//Dashboard > top Of Quarter Of The Year
Breadcrumbs::register('topOfQuarterOfTheYear', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Bảng xếp hạng theo quý', route('topOfQuarterOfTheYear'));
});

//Dashboard > top Of Year
Breadcrumbs::register('topOfYear', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Bảng xếp hạng theo năm', route('topOfYear'));
});

//Dashboard > purchase
Breadcrumbs::register('purchase', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Lịch sử mua', route('purchase'));
});
//Dashboard > purchase > detail
Breadcrumbs::register('detailPurchase', function($breadcrumbs, $id)
{
    $purchase = TPurchase::find($id);
    $breadcrumbs->parent('purchase');
    $breadcrumbs->push('Chi tiết mua thứ '. $purchase->id, route('detailPurchase', $purchase->id));
});

//Dashboard > recharge
Breadcrumbs::register('recharge', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Lịch sử nạp tiền', route('recharge'));
});
//Dashboard > recharge > detail
Breadcrumbs::register('detailRecharge', function($breadcrumbs, $id)
{
    $recharge = TRechargeHistory::find($id);
    $breadcrumbs->parent('recharge');
    $breadcrumbs->push('Chi tiết nạp tiền lần thứ '. $recharge->id, route('detailRecharge', $recharge->id));
});

//setting
Breadcrumbs::register('list_settings', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cài đặt', route('list_settings'));
});
//setting > add
Breadcrumbs::register('add_settings', function($breadcrumbs)
{
    $breadcrumbs->parent('list_settings');
    $breadcrumbs->push('Thêm dữ liệu', route('add_settings'));
});

//setting > edit
Breadcrumbs::register('edit_settings', function($breadcrumbs, $id)
{
    $setting = MSetting::find($id);
    $breadcrumbs->parent('list_settings');
    $breadcrumbs->push('Chỉnh sửa dữ liệu', route('edit_settings', $setting->id));
});