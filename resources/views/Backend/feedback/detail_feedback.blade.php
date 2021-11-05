<?php   
use App\Models\MSetting;
use App\Models\MUser;
use App\Models\MFeedback;
use App\Repositories\UserRepository;
use App\Repositories\SettingRepository;
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
    <h4>Chi tiết phản hồi</h4>
@endsection
@section('content')   

<div class="bg-form">
            <!-- Form danh sách câu hỏi -->
           <form class="form-horizontal">
                <fieldset>
                    <!-- Email -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="comparison">Email</label>
                        <label class="col-md-4 control-view" for="comparison">{{ MUser::find((int) $feedbacks->user_id)->email }}</label>
                    </div>  
                    <hr>
                    <!-- /End Email -->
                    <!-- Ngày phản hồi -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Ngày phản hồi</label>
                        <label class="col-md-6 control-view" for="comparison">{{ $feedbacks->created_time }}</label>
                    </div>
                    <hr>                 
                    <!-- /End Ngày phản hồi -->
                    <!-- Lời phản hồi -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Nội dung người dùng liên hệ</label>
                        <label class="col-md-6 control-view" for="comparison">
                            {{ $feedbacks->content }}
                        </label>
                    </div>
                    <hr>
                    <!-- /End Lời phản hồi -->
                    <!-- Ngày trả lời -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Ngày trả lời</label>
                        <label class="col-md-6 control-view" for="comparison">{{ $feedbacks->updated_time }}</label>
                    </div>
                    <hr>                 
                    <!-- /End Ngày trả lời -->
                    <!-- Nội dung phản hồi -->
                    {{--  <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Nội dung phản hồi</label>
                        <label class="col-md-6 control-view" for="comparison">
                            {{old('content_reply',$feedbacks->content_reply) }}
                        </label>
                    </div>       --}}
                    <!-- /End Nội dung phản hồi -->
                    
                </fieldset>
                <!-- Button -->
                <div class="sidebar-footer hidden-small">
                    <div class="form-group">
                        <!-- Button -->
                        <div class="control-button">
                            <a href="{{ asset('feedbacks') }}" class="btn btn-primary">
                                <span class="glyphicon glyphicon-arrow-left"></span>Quay lại
                            </a>
                            <!--tạm thời khóa chức năng gửi mail -->
                            <!--{{ asset ('feedbacks/reply/'. $feedbacks->feedback_id) }} -->
                            <a href="# " class="btn btn-success">
                                <span class="glyphicon glyphicon-edit"></span>Phản hồi 
                            </a>
                        </div>
                        <!-- /End Button -->
                    </div>
                </div>   
                <!-- /End Button -->
            </form>
            <!--/End Form Chi tiết phản hồi -->
    </div>
    
@endsection