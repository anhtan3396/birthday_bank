<?php
    use App\Models\MSetting;
    $setting = new MSetting();
    $videoPrice  = MSetting::where('s_key','DEFAULT_VID_PRICE')->first();
    
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Tạo video</h4>
@endsection
@section('content') 
<div class="bg-form">
   <!-- Form danh sách video -->
   <form class="form-horizontal"  enctype="multipart/form-data" method="post">
      {{ csrf_field() }}
      <fieldset>
         <!-- Hình ảnh -->
         <div class="form-group">
            <label class="col-md-4 control-label">Hình ảnh</label>
            <div class="col-md-6">
               <div class="form-group files">
                  <input type="file" onchange="loadFile(event)" name="video_image" class="form-control" multiple="">
                  <!-- hiển thị hình khi chọn-->
                  <script>
                     var loadFile = function(event) {
                       var output = document.getElementById('output');
                       output.src = URL.createObjectURL(event.target.files[0]);
                     };
                  </script> 
               </div>
               <p><img id="output" style="width:100px" class="img-responsive"/></p>
               @if ($errors->has('video_image'))
               <span class="help-block">
               <strong style="color: red;">{{ $errors->first('video_image') }}</strong>
               </span>
               @endif
            </div>
         </div>
         <hr>
         <!-- /End Hình ảnh -->
         <!-- title -->
         <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Tiêu đề</label>
            <div class="col-md-6">
               <input name="video_title" type="text" class="form-control" value="{{ old('video_title') }}">
               @if ($errors->has('video_title'))
               <span class="help-block">
               <strong style="color: red;">{{ $errors->first('video_title') }}</strong>
               </span>
               @endif
            </div>
         </div>
         <hr>
         <!-- /End title -->
         <!-- mô tả -->
         <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Mô tả</label>
            <div class="col-md-6">
               <input name="video_description" type="text" class="form-control" value="{{ old('video_description') }}">
               @if ($errors->has('video_description'))
               <span class="help-block">
               <strong style="color: red;">{{ $errors->first('video_description') }}</strong>
               </span>
               @endif
            </div>
         </div>
         <hr>
         <!-- /End mô tả -->
         <!-- giá -->
         <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Giá:</label>
            <div class="col-md-6">
               <input name="video_price" type="text" class="form-control" value="{{ old('video_price',$videoPrice->s_name) }}">
               @if ($errors->has('video_price'))
               <span class="help-block">
               <strong style="color: red;">{{ $errors->first('video_price') }}</strong>
               </span>
               @endif
            </div>
         </div>
         <hr>
         <!-- /End giá -->
         <!-- Url -->
         <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Đường dẫn</label>
            <div class="col-md-6">
               <input name="video_path" type="text" class="form-control" value="{{ old('video_path') }}">
               @if ($errors->has('video_path'))
               <span class="help-block">
               <strong style="color: red;">{{ $errors->first('video_path') }}</strong>
               </span>
               @endif
               <span class="help-block">
                 <strong style="color: red; ">{{ $errors->first('error') }}</strong>
               </span>
            </div>
         </div>
         <!-- /End url -->
      </fieldset>
      <!-- Button -->
      <div class="sidebar-footer hidden-small">
         <div class="form-group">
            <!-- Button -->
            <div class="control-button">
               <a href="{{ asset('videos') }}" class="btn btn-primary">
               <span class="glyphicon glyphicon-arrow-left"></span>Quay lại
               </a>
               <button id="submitButton" name="submitButton" class="btn btn-success">
               <span class="glyphicon glyphicon-floppy-disk"></span>Lưu video</button>
            </div>
            <!-- /End Button -->
         </div>
      </div>
      <!-- /End Button -->
   </form>
   <!--/End Form danh sách video --   >
</div>
@endsection