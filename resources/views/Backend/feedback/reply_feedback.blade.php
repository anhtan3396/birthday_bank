<?php
use App\Models\MSetting;
use App\Models\MUser;
use App\Repositories\UserRepository;
use App\Repositories\SettingRepository;
use App\Models\MFeedback;
use App\Http\Controllers\ContactController;
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
    <h4>Chi tiết câu hỏi</h4>
@endsection
@section('content')   
        <div class="bg-form">
            <!-- Form danh sách câu hỏi -->
            <form class="form-horizontal" method="POST">
            {{ csrf_field() }}
                <fieldset>
                    <!-- Người nhận -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="to">Người nhận</label>
                        <div class="col-md-6">
                            <input type="text" name="to" class="form-control" value="{{ MUser::find((int) $feedbacks->user_id)->email }}" placeholder="Email">
                        </div>
                    </div>
                    <hr>
                    <!-- /End Người nhận -->
                    <!-- Chủ đề -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Chủ đề</label>
                        <div class="col-md-6">
                            <input name="topic" type="text" class="form-control" value="{{ old('topic') }}" placeholder="Tiêu đề ...">
               @if ($errors->has('topic'))
               <span class="help-block">
               <strong style="color: red;">{{ $errors->first('topic') }}</strong>
               </span>
               @endif
                        </div>
                    </div>
                    <hr>
                    <!-- /End Chủ đề -->
                    <!-- Nội dung tin nhắn -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Nội dung tin nhắn</label>
                        <div class="col-md-6">
                            <textarea id="textarea" name="content_reply" rows="15"  placeholder="Nội dung tin nhắn..." class="form-control" value="{{ old('content_reply') }}"></textarea>
                            @if ($errors->has('content_reply'))
                           <span class="help-block">
                           <strong style="color: red;">{{ $errors->first('content_reply') }}</strong>
                           </span>
                           @endif
                        </div>
                    </div>
                    <hr>  
                    <!-- /End Nội dung tin nhắn -->
                </fieldset>

                <!-- Button -->
                <div class="sidebar-footer hidden-small">
                    <div class="form-group">
                        <!-- Button -->
                        <div class="control-button">
                            <a href="{{asset('feedbacks')}}" class="btn btn-primary">
                                <span class="glyphicon glyphicon-arrow-left"></span>Quay lại
                            </a>
                            <button id="submitButton" name="submitButton" class="btn btn-success">
                            <span class="glyphicon glyphicon-envelope"></span>Gửi tin nhắn</button>
                        </div>
                        <!-- /End Button -->
                    </div>
                </div>   
                <!-- /End Button -->
                
            </form>
            <!--/End Form danh sách câu hỏi -->
        </div>
   @endsection