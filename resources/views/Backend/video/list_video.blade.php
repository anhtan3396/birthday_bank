@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Danh sách video</h4>
@endsection
@section('content')    
<!-- Form danh video -->
<div class="bg-form">
   <form class="form-horizontal" method="GET" action="">
      <fieldset>
         <!-- đường dẫn -->
         <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Đường dẫn</label>
            <div class="col-md-6">
               <input class="form-control" name="video_path" type="text" value="<?= isset ($_GET['video_path']) ? $_GET['video_path'] : '' ?>">
            </div>
         </div>
         <!-- /End đường dẫn -->
         <!-- tiêu đề -->
         <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Tiêu đề</label>
            <div class="col-md-6">
               <input class="form-control" name="video_title" type="text" value="<?= isset ($_GET['video_title']) ? $_GET['video_title'] : '' ?>">
            </div>   
         </div>
         <!-- /End tiêu đề -->
         <!-- mô tả -->
         <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Mô tả</label>
            <div class="col-md-6">
               <input class="form-control" name="video_description" type="text" value="<?= isset ($_GET['video_description']) ? $_GET['video_description'] : '' ?>">
            </div>
         </div>
         <!-- /End mô tả -->
         <!-- Button -->
         <div class="form-group">
            <!-- Button -->
            <div class="col-md-10 control-button">
               <button id="searchButton" name="searchButton" class="btn btn-search pull-right">
               <span class="glyphicon glyphicon-search" ></span>Tìm kiếm
               </button>
               <a href="{{ asset('videos') }}" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>Reset</a>
            </div>
            <!-- /End Button -->
         </div>
         <!-- /End Button -->
         <hr>
      </fieldset>
   </form>
   <!--/End Form danh sách video -->
</div>
<!-- /End Info search -->
<!-- Button -->
<div class="col-md-4 btn-create">
   <a href="{{ asset ('videos/add') }}" class="btn btn-success">
   <span class="glyphicon glyphicon-plus"></span>Tạo video mới</a>
</div>
<!-- /End Button -->
<!-- Bảng hiển thị danh sách video -->
<div class="container-fluid">
<div class="table-responsive">
      <table class="table table-striped custab">
         <thead>
            <tr>
               <th class="text-center">
                  <div class="ckbox">
                     <input id="cb_All" name="btSelectAll" type="checkbox">  
                     <label for="cb_All"></label>  
                  </div>
               </th>
               <th>ID</th>
               <th>Hình Ảnh</th>
               <th>Tiêu đề</th>
               <th>Mô tả</th>
               <th>Giá</th>
               <th>Đường dẫn</th>
               <th>Ngày Tạo</th>
               <th class="text-center">Hành động</th>
            </tr>
         </thead>
         @foreach($videos as $video) 
         <tr video-id="{{ $video->video_id }}" id="video_{{ $video->video_id }}">
            <td class="text-center">
               <div class="ckbox">
                  <input id="{{ $video->video_id }}" class="check-box" name="ckb" type="checkbox">  
                  <label for="{{ $video->video_id }}"></label>  
               </div>
            </td>
            <td>{{ $video->video_id }}</td>
            <td><img src="{{ URL::asset('upload/image/video/'. $video->video_image ) }}" class="img-reponsive" style="height: 100px;width: 200px;"></td>
            <td><a href="{{asset('/videos/detail/'. $video->video_id)}}">{{ $video->video_title }}</td>
            <td>{{ $video->video_description }}</td>
            <td>{{ $video->video_price }} xu</td>
            <td>{{ $video->video_path }}</td>
            <td>{{ $video->created_time }}</td>
            <td class="text-center">
               <div class="btn-edit-video btn btn-info btn-xs glyphicon glyphicon-edit"></div>
               <div class="btn-delete-video btn btn-danger btn-xs glyphicon glyphicon-remove"></div>
            </td>
         </tr>
         @endforeach
      </table>
      <!-- Button -->
      <div class="btn-remove">
         <button name="btn_delete_all" url="{{ asset('videos/deleteall') }}" class="btn btn-danger" id="delete_all_video" content="{{ csrf_token() }}">Xóa lựa chọn
         </button>
         <input type="hidden" id="_token" value="{{ csrf_token() }}" />  
      </div>
      <!-- /End Button -->
      <!-- Phân trang -->
      {{ $videos->links() }}
      <!-- /End Phân trang -->
   </div>
</div>
<!-- /End Bảng hiển thị danh sách video -->
@endsection