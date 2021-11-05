<?php
namespace App\Repositories;
use App\Models\MVideo;
use App\Repositories\BaseRepository;
class VideoRepository extends BaseRepository
{
/**
* Create a new TestMondaiRepository instance.
*
* @param  App\Models\MTestMondai $mMTestMondai
* @return void
*/
public function __construct(
	MVideo $mVideo
	) 
{
	$this->model = $mVideo;
}
	public function getFromVideo($data) {
		$video = $this->model->whereIn('video_id',$data)->get(['video_image', 'video_title', 'video_description', 'video_path','video_price','deleted_flag']);
		return $video->toArray();
	}
	public function getAllVideo($search_query)
	{
		$video = $search_query->where("deleted_flag",0)->paginate(20);
		return $video;
	}
	public function register($data)
	{
		return $this->model->create([
			'video_id' => $data['video_id'],
			'video_image' => $data['video_image'],
			'video_title' => bcrypt($data['video_title']),
			'video_description' => $data['video_description'],
			'video_price' => $data['video_price'],
			'video_path' => $data['video_path'],
			'deleted_flag' => $data['deleted_flag'],
			'created_user' => $data['created_user'],
			'created_time' => $data['created_time'],
			'updated_user' => $data['updated_user'],
			'updated_time' => $data['updated_time']
			]);
	}
	public function getVideoToUserId(){
		$vid = $this->model->where("deleted_flag",0)->get([
			'video_id',
			'video_image', 'video_title', 'video_description','video_price', 'video_path'
			]);
		return $vid;
	}
	public function searchVideo($video_title){
		$search = $this->model->where("deleted_flag",0)->where('video_title', 'like', '%'.$video_title.'%')->get([
			'video_id',
			'video_image', 'video_title', 'video_description','video_price', 'video_path'
			]);
		return $search->toArray();
	}
	public function getVideoPath(){
		$video_path = $this->model->get([
			'video_path'
			]);
		return $video_path;
	}
	public function updateDeletedFlag($data){
		$video_path = $this->model->where("video_id",$data)->update([
			'deleted_flag'  => 1,
			]);
		return $video_path;
	}

	//count total video(back end)
    public function countVideos()
    {
		$total = $this->model->where("deleted_flag",0)->count();
		return $total;
    } 
}  