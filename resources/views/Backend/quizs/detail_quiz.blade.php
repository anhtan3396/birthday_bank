<?php
    use App\Models\MSetting;
    use App\Repositories\SettingRepository;
    $setting = new MSetting();
    $settingRepository = new SettingRepository($setting);

    $levels = MSetting::where('s_key','LEVEL')->get();
    $types  = MSetting::where('s_key','QUIZ_TYPE')->get();
    $groups  = MSetting::where('s_key','QUIZ_KBN')->get();
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
    <h4>Chi tiết câu hỏi</h4>
@endsection
@section('content')

<div class="bg-form">
            <!-- Form danh sách câu hỏi -->
           <form class="form-horizontal">

                <fieldset>
                    <!-- Trình độ -->
                    <div class="form-group">
                        <label class="col-md-4 control-label"for="comparison">Trình độ:</label>
                        <label class="col-md-4 control-view" for="comparison">{{ $settingRepository->getName($quiz->level_id,'LEVEL') }}</label>
                    </div>

                    <hr>
                    <!-- /End Trình độ -->
                    <!-- Loại -->
                    <div class="form-group">
                        <label class="col-md-4 control-label"for="comparison">Loại:</label>
                        <label class="col-md-4 control-view " for="comparison">{{ $settingRepository->getName($quiz->quiz_type,'QUIZ_TYPE') }}</label>
                     </div>
                    <hr>
                    <!-- /End Loại -->
                    <!-- Nhóm -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="reqType">Nhóm:</label>
                        <label  class="col-md-4 control-view" for="comparison">{{ $settingRepository->getName($quiz->quiz_kbn,'QUIZ_KBN') }}</label>
                    </div>
                    <hr>
                    <!-- /End Nhóm -->
                    <!-- Câu hỏi -->
                    <div class="form-group">
                     <label class="col-md-4 control-label" for="textinput">Câu hỏi:</label>
                        <label  class="col-md-6 control-view" for="comparison">{{old('question',$quiz->content) }}</label>
                    </div>

                    <!-- /End Câu hỏi -->
                    <!-- Hình ảnh -->
                    @if($quiz->image != null)
                    <hr>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Hình ảnh:</label>
                                <div class="col-md-6">
                                    <div class="form-group text-center ">
                                        <img src="{{ URL::asset('upload/image/quiz/'. $quiz->image) }}" alt="image" width="100%">
                                    </div>
                                </div>
                        </div>
                    @endif

                    <!-- /End Hình ảnh -->
                    <!-- Âm thanh -->
                    @if($quiz->sound != null)
                    <hr>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Âm thanh:</label>
                                <div class="col-md-6">
                                    <div class="form-group text-center ">
                                        <audio controls style="width: 100%">
                                            <source src="{{ URL::asset('upload/audio/quiz/'. $quiz->sound) }}" type="audio/mp3">
                                        </audio>
                                    </div>
                                </div>
                        </div>
                    @endif
                    <hr>
                    <!-- /End Âm thanh -->
                    <!-- Câu lựa chọn -->
                  <div class="form-group">
                        <label class="col-md-4 col-sm-4 col-xs-12 control-label" for="reqType">Đáp án:</label>
                        <div class="col-md-4 col-sm-4 col-xs-8 question">
                            <label class="radio" for="radio4">
                            @if($quiz->right_ans == 1)
                                <label for="radio4"><strong style="color: red;">A: </strong></label>
                                <label><strong style="color: red;">{{ $quiz->ans1 }}</strong></label>
                            @else
                                <label for="radio4">A: </label>
                                <label>{{ $quiz->ans1 }}</label>
                            @endif
                            </label>
                            <label class="radio" for="radio4">
                            @if($quiz->right_ans == 2)
                                <label for="radio4"><strong style="color: red;">B: </strong></label>
                                <label><strong style="color: red;">{{ $quiz->ans2 }}</strong></label>
                            @else
                                <label for="radio4">B: </label>
                                <label>{{ $quiz->ans2 }}</label>
                            @endif
                            </label>
                            <label class="radio" for="radio4">
                            @if($quiz->right_ans == 3)
                                <label for="radio4"><strong style="color: red;">C: </strong></label>
                                <label><strong style="color: red;">{{ $quiz->ans3 }}</strong></label>
                            @else
                                <label for="radio4">C: </label>
                                <label>{{ $quiz->ans3 }}</label>
                            @endif
                            </label>
                            <label class="radio" for="radio4">
                            @if($quiz->right_ans == 4)
                                <label for="radio4"><strong style="color: red;">D: </strong></label>
                                <label><strong style="color: red;">{{ $quiz->ans4 }}</strong></label>
                            @else
                                <label for="radio4">D: </label>
                                <label>{{ $quiz->ans4 }}</label>
                            @endif
                            </label>
                        </div>

                    </div>
                    <!-- /End Câu lựa chọn -->
                    <hr>
                    <!-- Giải thích -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Giải thích câu trả lời:</label>
                            <label class="col-md-6 control-view" for="comparison">{{ $quiz->right_ans_exp }}</label>
                            @if ($errors->has('content'))
                                <span class="help-block">
                                        <strong style="color: red;">{{ $errors->first('content') }}</strong>
                                </span>
                            @endif
                    </div>
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
                            <a href="{{ asset ('admin/quizs/edit/'. $quiz->quiz_id) }}" class="btn btn-success">
                                <span class="glyphicon glyphicon-edit"></span>Chỉnh sửa câu hỏi
                            </a>
                        </div>
                        <!-- /End Button -->
                    </div>
                </div>
                <!-- /End Button -->
            </form>
            <!--/End Form danh sách câu hỏi -->
        </div>

@endsection
