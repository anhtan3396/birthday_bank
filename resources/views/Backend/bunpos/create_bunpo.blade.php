<?php
use App\Models\MSetting;
$setting = new MSetting();

?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Tạo từ vựng</h4>
@endsection
@section('content') 

<div class="bg-form">
  <!-- Form danh sách từ vựng -->
  <form class="form-horizontal"  enctype="multipart/form-data" method="post">
    {{ csrf_field() }}
    <fieldset>
      <!-- Form danh sách từ vựng -->
      <!-- Phân loại -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="appendUrlParams">Loại</label>
        <div class="col-md-5" name="types">
          <div class="ckbox">
            <input type="checkbox"
            name="is_type_practice" 
            id="is_type_practice" 
            value="1" 
            @if (old('is_type_practice') == 1) checked @endif
            >
            <label for="is_type_practice">
              Luyện tập
            </label>
          </div>
          
          <div class="ckbox">
            <input type="checkbox"
            name="is_type_test" 
            id="is_type_test" 
            value="1" 
            @if (old('is_type_test') == 1) checked @endif
            >
            <label for="is_type_test">
              Bài thi
            </label>
          </div>
        </div>
        
      </div>
      <span class="help-block" style="text-align: center;">
        <strong style="color: red; ">{{ $errors->first('errorType') }}</strong>
      </span>
      <hr>
      <!-- End phân loại -->
      <!-- Cấp độ -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="appendUrlParams">Cấp độ</label>
        <div class="col-md-5">
          <div class="ckbox">
            <input type="checkbox"
            name="is_n1" 
            id="is_n1"
            value="1"
            @if (old('is_n1') == 1) checked @endif 
            >
            <label for="is_n1">
              N1
            </label>
          </div>
          
          <div class="ckbox">
            <input type="checkbox"
            name="is_n2" 
            id="is_n2" 
            value="1"
            @if (old('is_n2') == 1) checked @endif 
            >
            <label for="is_n2">
              N2
            </label>
          </div>
          
          
          <div class="ckbox">
            <input type="checkbox"
            name="is_n3" 
            id="is_n3" 
            value="1"
            @if (old('is_n3') == 1) checked @endif 
            >
            <label for="is_n3">
              N3
            </label>
          </div>
          
          
          <div class="ckbox">
            <input type="checkbox"
            name="is_n4" 
            id="is_n4" 
            value="1"
            @if (old('is_n4') == 1) checked @endif 
            >
            <label for="is_n4">
              N4
            </label>
          </div>


          <div class="ckbox">
            <input type="checkbox"
            name="is_n5" 
            id="is_n5" 
            value="1"
            @if (old('is_n5') == 1) checked @endif 
            >
            <label for="is_n5">
              N5
            </label>
          </div>
        </div>

      </div>
      <span class="help-block" style="text-align: center;">
        <strong style="color: red; ">{{ $errors->first('error') }}</strong>
      </span> 
      <span class="help-block" style="text-align: center;">
        <strong style="color: red; ">{{ $errors->first('errorLevel') }}</strong>
      </span> 
      <hr>
      <!-- End cấp độ -->
      <!-- Hình ảnh -->
      <div class="form-group">
       <label class="col-md-4 control-label">Hình ảnh</label>
       <div class="col-md-6">
        <div class="form-group files">
          <input type="file" onchange="loadFile(event)" name="image" class="form-control" multiple="">
          <!-- hiển thị hình khi chọn-->
          <script>
            var loadFile = function(event) {
              var output = document.getElementById('output');
              output.src = URL.createObjectURL(event.target.files[0]);
            };
          </script> 
        </div>
        <p><img id="output" style="width:100px" class="img-responsive"/></p>
        @if ($errors->has('image'))
        <span class="help-block">
          <strong style="color: red;">{{ $errors->first('image') }}</strong>
        </span>
        @endif
      </div>   
    </div>
    <hr>               
    <!-- /End Hình ảnh -->
    <!-- Hiragana -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="comparison">Hiragana</label>
      <div class="col-md-6">
        <input name="hiragana" type="text" class="form-control" value="{{ old('hiragana') }}" @if (old('hiragana') == 1) checked @endif>
        @if ($errors->has('hiragana'))
        <span class="help-block">
          <strong style="color: red;">{{ $errors->first('hiragana') }}</strong>
        </span>
        @endif
      </div>
    </div>
    <hr>
    <!-- /End Hiragana -->
    <!-- Katakana -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="comparison">Katakana</label>
      <div class="col-md-6">
        <input name="katakana" type="text" class="form-control" value="{{ old('katakana') }}" @if (old('katakana') == 1) checked @endif>
        @if ($errors->has('katakana'))
        <span class="help-block">
          <strong style="color: red;">{{ $errors->first('katakana') }}</strong>
        </span>
        @endif
      </div>
    </div>
    <hr>
    <!-- /End Katakana -->
    <!-- Kanji -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="comparison">Kanji</label>
      <div class="col-md-6">
        <input name="kanji" type="text" class="form-control" value="{{ old('kanji') }}" @if (old('kanji') == 1) checked @endif>
        @if ($errors->has('kanji'))
        <span class="help-block">
          <strong style="color: red;">{{ $errors->first('kanji') }}</strong>
        </span>
        @endif
      </div>
    </div>
    <hr>
    <!-- /End Kanji -->
    <!-- Nghĩa của từ -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="comparison">Nghĩa của từ</label>
      <div class="col-md-6">
        <input name="meaning" type="text" class="form-control" value="{{ old('meaning') }}" @if (old('meaning') == 1) checked @endif>
        @if ($errors->has('meaning'))
        <span class="help-block">
          <strong style="color: red;">{{ $errors->first('meaning') }}</strong>
        </span>
        @endif
      </div>
    </div>
    <hr>
    <!-- /End Nghĩa của từ -->
    <!-- Âm thanh -->
    <div class="form-group">
     <label class="col-md-4 control-label">Âm thanh</label>
     <div class="col-md-6">
      <script>
        function fileSelected(filelist){
          document.getElementById("audiosource").src = URL.createObjectURL(filelist.files[0]);
          document.getElementById('audiosource').style.display = "block";
        }
      </script>
      <div class="form-group files">
        <input type="file" name="sound" accept="audio/*" onchange="fileSelected(this)" class="form-control" multiple="">
      </div>
      <!-- load audio when choose -->
      <audio controls id="audiosource" style="display:none">
        <source type="audio/mp3"  />
      </audio> 
      @if ($errors->has('sound'))
      <span class="help-block">
        <strong style="color: red;">{{ $errors->first('sound') }}</strong>
      </span>
      @endif  
    </div>
  </div>
  <hr>
  <!-- /End Âm thanh -->

</fieldset>

<!-- Button -->
<div class="sidebar-footer hidden-small">
  <div class="form-group">
    <!-- Button -->
    <div class="control-button">
      <a href="{{ asset('bunpos') }}" class="btn btn-primary">
        <span class="glyphicon glyphicon-arrow-left"></span>Quay lại
      </a>
      <button id="submitButton" name="submitButton" class="btn btn-success">
        <span class="glyphicon glyphicon-floppy-disk"></span>Lưu từ vựng</button>
      </div>
      <!-- /End Button -->
    </div>
  </div>   
  <!-- /End Button -->       
</form>
<!--/End Form danh sách từ vựng -->
</div>
@endsection