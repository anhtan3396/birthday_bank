<?php
   use App\Models\MSetting;
   use App\Models\MUser;
   use App\Repositories\UserRepository;
   use App\Repositories\SettingRepository;
   $setting = new MSetting();
   $settingRepository = new SettingRepository($setting);
   $user_role = MSetting::where('s_key','USER_ROLE')->get();
   $user = MUser::find((int) $video->created_user);



  $url = $video->video_path;
   parse_str(parse_url($url, PHP_URL_QUERY), $youtube);
   ////
  $url =$video->video_path;
  preg_match('/(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=‌​(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+/', $url, $matches);
 
//   if (!empty($matches)) {
//     echo $matches[0];
//   }
// die();   
   ?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Chi tiết video</h4>
@endsection  
@section('content') 
<div class="bg-form">
   <!-- Form chi tiết video -->
   <form class="form-horizontal">
      {{ csrf_field() }}
      <fieldset>
         <!-- Tiêu đề -->
         <div class="form-group">
            <label class="col-md-4 control-label" for="comparison">Tiêu đề:</label>
            <label class="col-md-4 control-view" for="comparison">{{ $video->video_title }}</label>
         </div>
         <hr>
         <!-- /End tiêu đề -->
         <!-- Mô tả -->
         <div class="form-group">
            <label class="col-md-4 control-label" for="comparison">Mô tả:</label>
            <label class="col-md-4 control-view" for="comparison">{{ $video->video_description }}</label>
         </div>
         <hr>
         <!-- /End Mô tả -->
         <!-- Giá -->
         <div class="form-group">
            <label class="col-md-4 control-label" for="comparison">Giá:</label>
            <label class="col-md-4 control-view" for="comparison">{{ $video->video_price }} xu</label>
         </div>
         <hr>
         <!-- /End Giá -->
         <!-- video -->
         <div class="form-group">
            <label class="col-md-4 control-label" for="comparison">Play Video:</label>
            <iframe class="col-md-6 control-view" width="560" height="315" src="{{ 'https://www.youtube.com/embed/'.$matches[0] }}" frameborder="0" allowfullscreen>
            </iframe>
         </div>
         <hr>
         <!-- /End video -->     
         <!-- Người tạo -->
         <div class="form-group">
            <label class="col-md-4 control-label" for="comparison">Người tạo:</label>
            <label class="col-md-4 control-view" for="comparison">{{ $user->nick_name }}</label>
         </div>
         <hr>
         <!-- /End Người tạo -->
         <!-- Ngày tạo -->
         <div class="form-group">  
            <label class="col-md-4 control-label" for="comparison">Ngày tạo:</label>
            <label class="col-md-4 control-view" for="comparison">{{ $video->created_time }}</label>
         </div>
         <hr>
         <!-- /End Ngày tạo -->     
         <!-- Hình ảnh -->
         @if($video->video_image != null)
         <div class="form-group">
            <label class="col-md-4 control-label">Hình ảnh:</label>
            <div class="col-md-6">
               <div class="form-group text-center "> 
                  <img src="{{ URL::asset('upload/image/video/'. $video->video_image) }}" alt="image" width="100%">
               </div>
            </div>
         </div>
         @endif                 
         <!-- /End Hình ảnh -->
      </fieldset>
      <!-- Button -->
      <div class="sidebar-footer hidden-small">
         <div class="form-group">
            <!-- Button -->
            <div class="control-button">
               <a href="{{ asset('videos') }}" class="btn btn-primary">
               <span class="glyphicon glyphicon-arrow-left"></span>Quay lại
               </a>
               <a href="{{ asset ('videos/edit/'. $video->video_id) }}" class="btn btn-success">
               <span class="glyphicon glyphicon-edit"></span>Chỉnh sửa video
               </a>
            </div>
            <!-- /End Button -->
         </div>
      </div>
      <!-- /End Button -->
   </form>
   <!--/End Form chi tiết video -->
</div>
@endsection