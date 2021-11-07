<?php
    use App\Models\MSetting;
    $setting = new MSetting();
    $levels = MSetting::where('s_key','LEVEL')->get();
    $types  = MSetting::where('s_key','QUIZ_TYPE')->get();
    $groups  = MSetting::where('s_key','QUIZ_KBN')->get();
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
    <h4>Tạo câu hỏi</h4>
@endsection
@section('content')

<div class="bg-form">
    <!-- Form danh sách câu hỏi -->
    <form class="form-horizontal"  enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <fieldset>
            <!-- Trình độ -->
            {{-- <div class="form-group">
                <label class="col-md-4 control-label" for="comparison">Trình độ</label>
                <div class="col-md-4">
                    <select id="comparison" name="levels" class="form-control">
                    @foreach($levels as $level)
                        <option value="{{ $level->s_value }}" @if (old('levels') == $level->s_value) selected @endif >
                            {{ $level->s_name }}
                        </option>
                    @endforeach
                    </select>
                    @if ($errors->has('levels'))
                        <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('levels') }}</strong>
                        </span>
                    @endif
                </div>
             </div>
            <hr> --}}
            <!-- /End Trình độ -->
            <!-- Loại -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="comparison">Loại</label>
                <div class="col-md-4">
                    <select id="comparison" name="types" class="form-control">
                    @foreach($types as $type)
                        <option value="{{ $type->s_value }}" @if (old('types') == $type->s_value) selected @endif>{{ $type->s_name }}</option>
                    @endforeach
                    </select>
                     @if ($errors->has('types'))
                        <span class="help-block">
                            <strong style="color: red;">{{ $errors->first('types') }}</strong>
                        </span>
                    @endif
                </div>
             </div>
            <hr>
            <!-- /End Loại -->
            <!-- Nhóm -->
            {{-- <div class="form-group">
                <label class="col-md-4 control-label" for="reqType">Nhóm</label>
                <div class="col-md-8">
                @foreach($groups as $group)
                      <input type="radio" name="group" id="{{ $group->s_value }}" value="{{ $group->s_value }}" checked><label for="{{ $group->s_value }}"><span></span>{{ $group->s_name }}</label>
                @endforeach
                 @if ($errors->has('group'))
                        <span class="help-block">
                            <strong style="color: red;">{{ $errors->first('group') }}</strong>
                        </span>
                @endif
                </div>
             </div>
            <hr> --}}
            <!-- /End Nhóm -->
            <!-- Câu hỏi -->
            <div class="form-group">
               <label class="col-md-4 control-label" for="textinput">Câu hỏi</label>
                  <div class="col-md-6">
                      <textarea id="textarea" name="question" placeholder="Nội dung câu hỏi" class="fullname form-control" rows="10" >{{ old('question') }}</textarea>
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
            <!-- Âm thanh -->
            {{-- <div class="form-group">
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
            <hr> --}}
            <!-- /End Âm thanh -->
            <!-- Câu lựa chọn -->
            <div class="form-group">
               <label class="col-md-4 col-sm-4 col-xs-12 control-label" for="reqType">Câu lựa chọn</label>
               <div class="col-md-4 col-sm-4 col-xs-8 question">
                  <label class="radio" for="radio4">
                     <label for="radio4">A </label>
                     <input id="A" name="ansA" type="text" class="form-control" value="{{ old('ansA') }}">
                      @if ($errors->has('ansA'))
                      <span class="help-block">
                          <strong style="color: red;">{{ $errors->first('ansA') }}</strong>
                      </span>
                      @endif
                  </label>
                  <label class="radio" for="radio5">
                     <label for="radio5">B </label>
                     <input id="A" name="ansB" type="text" class="form-control"  value="{{ old('ansB') }}">
                     @if ($errors->has('ansB'))
                      <span class="help-block">
                              <strong style="color: red;">{{ $errors->first('ansB') }}</strong>
                      </span>
                      @endif
                  </label>
                  <label class="radio" for="radio6">
                     <label for="radio6">C </label>
                     <input id="A" name="ansC" type="text" class="form-control"  value="{{ old('ansC') }}">
                     @if ($errors->has('ansC'))
                      <span class="help-block">
                              <strong style="color: red;">{{ $errors->first('ansC') }}</strong>
                      </span>
                      @endif
                  </label>
                  <label class="radio" for="radio7">
                     <label for="radio7">D </label>
                     <input id="A" name="ansD" type="text" class="form-control"  value="{{ old('ansD') }}">
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
                  <input type="radio" id="radio4" name="rightAns" value="1" checked="checked">
                  <label for="radio4"><span></span></label>
                  <input type="radio" id="radio5" name="rightAns" value="2"/>
                  <label for="radio5"><span></span></label>
                  <input type="radio" id="radio6" name="rightAns" value="3"/>
                  <label for="radio6"><span></span></label>
                  <input type="radio" id="radio7" name="rightAns" value="4"/>
                  <label for="radio7"><span></span></label>
               </div>
            </div>

            <hr>
            <!-- /End Câu lựa chọn -->
            <!-- Giải thích -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Giải thích câu trả lời</label>
                <div class="col-md-6">
                    <textarea id="textarea" name="content" placeholder="Nội dung câu giải thích. VD: Vì là động từ..." class="fullname form-control" rows="10">{{ old('content') }}</textarea>
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
                    <a href="{{ asset('quizs') }}" class="btn btn-primary">
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
