<?php
namespace App\Http\Controllers\Backend;
use App\Models\MVideo;
use Illuminate\Http\Request;
use App\Repositories\VideoRepository;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Utils\SessionManager;
class VideoController extends Controller
{
/**
* Show the profile for the given user.
*
* @param  int  $id
* @return Response
*/
public function index(Request $request,VideoRepository $videoRepository)
{
    $video_path = $request->input('video_path');
    $video_title = $request->input('video_title');
    $video_description = $request->input('video_description');
    $deleted_flag = $request->input('deleted_flag');
    $search_query = MVideo::query();
    if($video_path)
    {
        $search_query->where('video_path', 'like', '%'.$video_path.'%');   
    }
    if($video_title)
    {
        $search_query->where('video_title', 'like', '%'.$video_title.'%');   
    }
    if($video_description)
    {   
        $search_query->where('video_description', 'like', '%'.$video_description.'%');
    }    
    $videos = $videoRepository->getAllVideo($search_query);
    return view("Backend.video.list_video",['videos' => $videos]);
}
    //view form create
public function createNewVideoForm()
{
    return view('Backend.video.create_video');
}
public function createNewVideo(Request $request, VideoRepository $videoRepository)
{
    $validator = Validator::make(
        $request->all(), 
        [
        'video_path'              =>'required|unique:m_video,video_path',
        'video_title'             =>'required|unique:m_video,video_title|max:100',
        'video_description'       =>'required|max:255',
        'video_image'             =>'required|image|max:4096', 
        'video_price'             =>'required|max:11',      
        ]
        ,
        [
        'video_image.required'            => 'Vui lòng chọn hình ảnh thích hợp.',
        'video_path.required'             => 'Vui lòng nhập nội dung đường dẫn.',
        'video_path.unique'               => 'Đường dẫn đã tồn tại, vui lòng nhập lại.',
        'video_title.required'            => 'Vui lòng nhập nội dung tiêu đề.',
        'video_title.unique'              => 'Tiêu đề đã tồn tại, vui lòng nhập lại.',
        'video_title.max'                 => 'Chiều dài tiêu đề vượt quá số kí tự cho phép.',
        'video_description.required'      => 'Vui lòng nhập nội dung mô tả.',
        'video_description.max'           => 'Chiều dài mô tả vượt quá số kí tự cho phép.',
        'video_image.max'                 => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
        'video_image.uploaded'            => 'Vui lòng chọn đúng kiểu hình ảnh.',
        'video_price.required'            => 'Vui lòng nhập số xu.',
        'video_price.max'                 => 'Số xu vượt quá số lượng cho phép.',
        ]
        );
    
    if ($validator->fails())
    {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    else{

        $url = $request->input('video_path');   
        preg_match('/(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=‌​(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+/', $url, $matches);
        //dd($matches);
        if($matches == null)
            {
                //return "ỳyuf";
                return redirect()->back()->withErrors(['error' => "Vui lòng nhập link youtube."])->withInput();
            }
        $imageURL                       = "";
        $title                          = $request->input('video_title');
        $description                    = $request->input('video_description');
        $deleted_flag                   = 0;
        $price                          = $request->input('video_price');
        $video = $videoRepository->create(
            [
            "video_image"                       => $imageURL,
            "video_title"                       => $title,
            "video_description"                 => $description,
            "video_path"                        => $url,
            "video_price"                       => $price
            ]
            );
        if ($video->video_id > 0) {
            if(Input::hasfile('video_image'))
            {
    //image
                $nameImage = Input::file('video_image')->getClientOriginalExtension();
                $imageURL = $video->video_id . "." . date("H_i_s",time()). ".". $nameImage;
                if(File::exists(public_path('upload/image/video/') . $imageURL))
                {
                    unlink(public_path('upload/image/video/') . $imageURL);   
                } 
                Input::file('video_image')->move(public_path('upload/image/video/'), $imageURL);
            }else
            {
                $imageURL = "";
            }
    // Update
            $videoRepository->update([
                'video_image'     =>  $imageURL,
                ], $video->video_id, "video_id");
            return redirect('videos')->with('notify', "Thêm thành công!");
        }
        else {
            return redirect('videos')->with('notify', "Thêm thất bại!");
        }
    }
}
    // view update a video
public function editVideoForm($id, VideoRepository $videoRepository)
{
    $validator = Validator::make(['video_id' => $id], [
        'videos'   => 'exists:video_id'
        ], [
        'video_id.required'      => 'Không tồn tại câu hỏi',
        ]);
    if ($validator->fails())
    {
        return redirect()->back();
    }
    else
    {
        $video = $videoRepository->find((int)$id);
        return view('Backend.video.edit_video', ['video' => $video]);  
    }
}
    //update a video
public function updateVideo(Request $request, $id, VideoRepository $videoRepository )
{
    $videoRepository->find($id);
    if($request->get('password') == '')
    {
        $validator = Validator::make($request->all(), [
            'video_path'              =>'required',
            'video_title'             =>'required|max:100',
            'video_description'       =>'required|max:255',
            'video_image'             =>'sometimes|image|max:4096',
            'video_price'             =>'required|max:11',            
            ],
            [
            'video_image.required'            =>  'Vui lòng chọn hình ảnh thích hợp.',
            'video_path.required'             => 'Vui lòng nhập nội dung đường dẫn.',
            'video_title.required'            => 'Vui lòng nhập nội dung tiêu đề.',
            'video_title.max'                 => 'Chiều dài tiêu đề vượt quá số kí tự cho phép.',
            'video_description.max'           => 'Chiều dài mô tả vượt quá số kí tự cho phép.',
            'video_description.required'      => 'Vui lòng nhập nội dung mô tả.',
            'video_image.max'                 => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
            'video_image.uploaded'            => 'Vui lòng chọn đúng kiểu hình ảnh.',
            'video_price.required'            => 'Vui lòng nhập số xu.',
            'video_price.max'                 => 'Số xu vượt quá số lượng cho phép.',
            ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            if (Input::hasfile('video_image'))
            {
                $nameImage = Input::file('video_image')->getClientOriginalExtension();
                $imageURL = $id . "." . date("H_i_s",time()). ".". $nameImage;
                if(File::exists(public_path('upload/image/video/') . $imageURL))
                {
                    unlink(public_path('upload/image/video/') . $imageURL);   
                } 
                Input::file('video_image')->move(public_path('upload/image/video/'), $imageURL);
                $videoRepository->update(
                    [
                    "video_image"          => $imageURL,
                    ],
                    $id,
                    "video_id"
                    );   
            }
            $url = $request->input('video_path');   
            preg_match('/(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=‌​(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+/', $url, $matches);
            //dd($matches);
            if($matches == null)
            {
                //return "ỳyuf";
                return redirect()->back()->withErrors(['error' => "Vui lòng nhập link youtube."])->withInput();
            }
            $videoRepository->update(
                [
                "video_title"       => $request->get('video_title'),
                "video_description" => $request->get('video_description'),
                "video_path"        => $request->get('video_path'),
                "video_price"       => $request->get('video_price')
                ], 
                $id,
                "video_id"
                );
            return redirect('videos');
        }
    }else
    {
        $validator = Validator::make($request->all(), [
            'video_path'               =>'required|unique:m_video,video_path',
            'video_title'             =>'required|unique:m_video,video_title|max:100',
            'video_description'       =>'required|max:255',
            'video_image'             =>'sometime|image|max:4096', 
            'video_price'             =>'required|max:11',          
            ],
            [ 
            'video_image.required'            =>  'Vui lòng chọn hình ảnh thích hợp.',
            'video_path.required'             => 'Vui lòng nhập nội dung đường dẫn.',
            'video_title.required'            => 'Vui lòng nhập nội dung tiêu đề.',
            'video_title.max'                 => 'Chiều dài tiêu đề vượt quá số kí tự cho phép.',
            'video_description.max'           => 'Chiều dài mô tả vượt quá số kí tự cho phép.',
            'video_description.required'      => 'Vui lòng nhập nội dung mô tả.',
            'video_image.max'                 => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
            'video_image.uploaded'            => 'Vui lòng chọn đúng kiểu hình ảnh.',
            'video_price.required'            => 'Vui lòng nhập số xu.',
            'video_price.max'                 => 'Số xu không được vượt quá 11 con số.',
            ]);
        if ($validator->fails())
        {   
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $url = $request->input('video_path');   
            preg_match('/(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=‌​(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+/', $url, $matches);
            //dd($matches);
            if($matches == null)
            {
                //return "ỳyuf";
                return redirect()->back()->withErrors(['error' => "Vui lòng nhập link youtube."])->withInput();
            }
            $videoRepository->update(
                [
                "video_title"           => $request->get('video_title'),
                "video_description"     => $request->get('video_description'),
                "video_path"            => $request->get('video_path'),
                "video_price"           => $request->get('video_price')
                ], 
                $id,
                "video_id"
                );
            return redirect('videos');
        }
    }
}
    //chi tiết video
public function detailVideo($id, VideoRepository $videoRepository)
{
    $validator = Validator::make(['video_id' => $id], [
        'video_id'   => 'exists:m_video,video_id'
        ], [
        'video_id.require'   =>'Không tồn tại video',
        ]);
    if ($validator->fails())
    {
        return redirect()->back();
    }
    else
    {
        $video = $videoRepository->find((int)$id);
        return view('Backend.video.detail_video', ['video' => $video]);  
    }
}
public function destroyVideo($id, VideoRepository $videoRepository)
{
    //update delete_flag
    $videoRepository->update(
        [
        "deleted_flag"          => 1, 
        ],
        $id,
        "video_id"
        );
    return redirect()->back();
}
public function deleteall(Request $rq, VideoRepository $videoRepository) 
{
    //get list video choosed 
    $list_id = $rq->get('list_id');
    foreach ($list_id as $id) {
    //update delete_flag
        $videoRepository->update(
            [
            "deleted_flag"          => 1,
            ],
            $id,
            "video_id"
            );
    }
    return redirect()->back();
}

public function showVideo( VideoRepository $videoRepository,UserRepository $user)
{
        // 0 là không có user id 
    if(!empty($_GET["user_id"]) && !empty($_GET["api_token"]) && !empty($_GET["video_id"]))
    {
        $video = $videoRepository->find($_GET["video_id"]);
        return view('Backend.video.showVideoApp', ['video' => $video]);
    }
    else
    {
      return 0;
  }
}

}