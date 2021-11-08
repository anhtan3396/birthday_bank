@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Chỉnh sửa câu hỏi</h4>
@endsection
@section('content')

<div class="bg-form">
  <!-- Form danh sách câu hỏi -->
  <form class="form-horizontal" enctype="multipart/form-data" method="post">
    {{ csrf_field() }}
    <fieldset>
      <!-- Trình độ -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="comparison">Trình độ</label>
        <div class="col-md-4">
          <select id="comparison" name="level" class="form-control">
            <option value="1" @if ($quiz->level==1) selected @endif>
              Câu hỏi thường
            </option>
            <option value="2" @if ($quiz->level==2) selected @endif>
              Câu hỏi đặc biệt
            </option>
          </select>
          @if ($errors->has('level'))
          <span class="help-block">
            <strong style="color: red;">{{ $errors->first('level') }}</strong>
          </span>
          @endif
        </div>
      </div>
      <hr>
      <!-- /End Trình độ -->
      <!-- Câu hỏi -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="textinput">Câu hỏi</label>
        <div class="col-md-6">
          <textarea id="textarea" name="question" placeholder="Nội dung câu hỏi" class="fullname form-control"
            rows="10">{{ old('question',$quiz->content) }}</textarea>
          @if ($errors->has('question'))
          <span class="help-block">
            <strong style="color: red;">{{ $errors->first('question') }}</strong>
          </span>
          @endif
        </div>
      </div>
      <hr>
      <!-- /End Câu hỏi -->
      <!-- Hình ảnh -->
      <!-- @if($quiz->image != null)
      <div class="form-group">
        <label class="col-md-4 control-label"></label>
        <div class="col-md-4">
          <div class="form-group">
            <label id="change_img">Hình ảnh hiện tại:</label>
            <img id="output" src="{{ URL::asset('upload/image/quiz/'. $quiz->image) }}" alt="image" width="100%">
            <script>
              var loadFile = function (event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                document.getElementById('change_img').innerHTML = "Hình ảnh sẽ thay thế:";
                document.getElementById('delete_old_image').style.display = "none";
              };
            </script>
          </div>
        </div>
        <div class="ckbox col-md-4" id="delete_old_image">
          <input type="checkbox" id="checkbox_image" name="delete_image">
          <label for="checkbox_image">Xóa hình hiện tại</label>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 control-label">Hình ảnh</label>
        <div class="col-md-6">
          <div class="form-group files">
            <input type="file" onchange="loadFile(event)" name="image" class="form-control" multiple="">
          </div>
          @if ($errors->has('image'))
          <span class="help-block">
            <strong style="color: red;">{{ $errors->first('image') }}</strong>
          </span>
          @endif
        </div>
      </div>
      @else
      <div class="form-group">
        <label class="col-md-4 control-label">Hình ảnh</label>
        <div class="col-md-6">
          <div class="form-group files">
            <p><img id="output" style="width:100%" class="img-responsive" /></p>
            <script>
              var loadFile = function (event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
              };
            </script>
            <input type="file" onchange="loadFile(event)" name="image" class="form-control" multiple="">

          </div>
          @if ($errors->has('image'))
          <span class="help-block">
            <strong style="color: red;">{{ $errors->first('image') }}</strong>
          </span>
          @endif
        </div>
      </div>
      @endif
      <hr> -->
      <!-- /End Hình ảnh -->
      <!-- Câu lựa chọn -->
      <div class="form-group">
        <label class="col-md-4 col-sm-4 col-xs-12 control-label" for="reqType">Câu lựa chọn</label>
        <div class="col-md-4 col-sm-4 col-xs-8 question">
          <label class="radio" for="radio4">
            <label for="radio4">A </label>
            <input id="A" name="ansA" value="{{ old('ansA',$quiz->ans1) }}" type="text" class="form-control">
            @if ($errors->has('ansA'))
            <span class="help-block">
              <strong style="color: red;">{{ $errors->first('ansA') }}</strong>
            </span>
            @endif
          </label>
          <label class="radio" for="radio5">
            <label for="radio5">B </label>
            <input id="A" name="ansB" value="{{ old('ansB',$quiz->ans2) }}" type="text" class="form-control">
            @if ($errors->has('ansB'))
            <span class="help-block">
              <strong style="color: red;">{{ $errors->first('ansB') }}</strong>
            </span>
            @endif
          </label>
          <label class="radio" for="radio6">
            <label for="radio6">C </label>
            <input id="A" name="ansC" value="{{ old('ansC',$quiz->ans3) }}" type="text" class="form-control">
            @if ($errors->has('ansC'))
            <span class="help-block">
              <strong style="color: red;">{{ $errors->first('ansC') }}</strong>
            </span>
            @endif
          </label>
          <label class="radio" for="radio7">
            <label for="radio7">D </label>
            <input id="A" name="ansD" value="{{ old('ansD',$quiz->ans4) }}" type="text" class="form-control">
            @if ($errors->has('ansD'))
            <span class="help-block">
              <strong style="color: red;">{{ $errors->first('ansD') }}</strong>
            </span>
            @endif
          </label>
          <span class="help-block">
            <strong style="color: red;">{{ $errors->first('quiz') }}</strong>
          </span>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4 answer">
          <input type="radio" id="radio4" name="rightAns" value="1" {{ $quiz->right_ans == 1 ? 'checked' : '' }}>
          <label for="radio4"><span></span></label>
          <input type="radio" id="radio5" name="rightAns" value="2" {{ $quiz->right_ans == 2 ? 'checked' : '' }}>
          <label for="radio5"><span></span></label>
          <input type="radio" id="radio6" name="rightAns" value="3" {{ $quiz->right_ans == 3 ? 'checked' : '' }}>
          <label for="radio6"><span></span></label>
          <input type="radio" id="radio7" name="rightAns" value="4" {{ $quiz->right_ans == 4 ? 'checked' : '' }}>
          <label for="radio7"><span></span></label>
        </div>
      </div>
      <hr>
      <!-- /End Câu lựa chọn -->
      <!-- Giải thích -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="textinput">Giải thích câu trả lời</label>
        <div class="col-md-6">
          <textarea id="textarea" name="content" placeholder="Nội dung câu giải thích. VD: Vì là..."
            class="fullname form-control" rows="10"> {{ $quiz->right_ans_exp }}</textarea>
          @if ($errors->has('content'))
          <span class="help-block">
            <strong style="color: red;">{{ $errors->first('content') }}</strong>
          </span>
          @endif
        </div>
      </div>
      <hr>
      <!-- /End Giải thích -->
    </fieldset>
    <!-- Button -->
    <div class="sidebar-footer hidden-small">
      <div class="form-group">
        <!-- Button -->
        <div class="control-button">
          <a href="{{ asset('admin/quizs') }}" class="btn btn-primary">
            <span class="glyphicon glyphicon-arrow-left"></span>Quay lại
          </a>
          <button id="submitButton" name="submitButton" class="btn btn-success">
            <span class="glyphicon glyphicon-floppy-disk"></span>Lưu câu hỏi</button>
        </div>
        <!-- /End Button -->
      </div>
    </div>
    <!-- /End Button -->
  </form>
  <!--/End Form danh sách câu hỏi -->
</div>

@endsection