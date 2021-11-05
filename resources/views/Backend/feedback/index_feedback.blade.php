<?php
use App\Models\MSetting;
use App\Models\MUser;
use App\Repositories\UserRepository;
use App\Repositories\SettingRepository;
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Danh sách phản hồi từ người dùng</h4>
@endsection
@section('content')<!-- Main content -->

<div class="bg-form">  
  <span class="help-block" style=" text-align: center;">
    <strong style="color: red;">{{ $errors->first('error') }}</strong>
  </span>
 <form class="form-horizontal" method="GET" action="">
  <fieldset>
    <!-- EMAIL -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="textinput">Email</label>
      <div class="col-md-6">
        <input class="form-control" name="email" type="text" value="{{ $email}}">
      </div>
    </div>
    <!-- /End EMAIL -->
    <!-- Ngày phản hồi -->
    <div class="form-group">
    <label class="col-md-4 control-label" for="date-f">Từ Ngày</label>
      <div class="col-md-6">
        <input id="date-f" name="date-f" value="{{ $oldDate_f }}" type="date" class="form-control">
      </div>
    </div>
    <!-- /End Ngày đăng từ -->
    <!-- Ngày đăng đến -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="date-t">Đến ngày</label>
        <div class="col-md-6">
          <input id="date-t" name="date-t" value="{{ $oldDate_t }}" type="date" class="form-control">
        </div>
      </div>
      <!-- /End Ngày đăng đến -->
   
   
    <!-- Button -->
    <div class="form-group">
      <!-- Button -->
      <div class="col-md-10 control-button">
        <button id="searchButton" name="searchButton" class="btn btn-search">
          <span class="glyphicon glyphicon-search"></span>Tìm kiếm
        </button>
        <a href="{{ asset('feedbacks') }}" class="btn btn-primary">
          <span class="glyphicon glyphicon-refresh"></span>Reset
        </a>
      </div>
      <!-- /End Button -->
    </div>
    
    <!-- /End Button -->
    <hr>
  </fieldset>
</form>
<!--/End Form danh sách phản hồi của người dùng -->
</div>
<!-- Bảng hiển thị danh sách câu hỏi -->

<div class="container-fluid">
  <div class="table-responsive">
    <table class="table table-striped custab">
      <thead>
        <tr>
          <th class="text-center">
            <div class="ckbox">
              <input type="checkbox" id="checkbox1" onClick="toggle(this)">
              <label for="checkbox1"></label>
            </div>
          </th>
          <th>STT</th>
          <th>Email</th>
          <th>Nội dung liên hệ</th>
          <th>Ngày phản hồi</th>
          <th class="text-center">Hành động</th>
        </tr>
      </thead>
      @foreach($feedbacks as $feedback)
      <tr feedback-id="{{ $feedback->feedback_id }}" id="feedback_{{ $feedback->feedback_id }}">
        <td class="text-center">
          <div class="ckbox">
            <input id="{{ $feedback->feedback_id }}" class="check-box" name="ckb" type="checkbox">  
            <label for="{{ $feedback->feedback_id }}"></label>  
          </div>
        </td> 
        <td>{{ $feedback->feedback_id }}</td> 
        <td>{{ MUser::find((int) $feedback->user_id)->email }}</td>
        <td>{{ $feedback->contents }}</td>
        <td>{{ $feedback->created_time }}</td>

        <td class="text-center">
          <div class="btn-detail-feedback btn btn-success btn-xs glyphicon glyphicon-eye-open"></div>
          <!--tạm thời khóa chức năng gửi mail -->
          <!--<div class="btn-reply-feedback  btn btn-primary btn-xs glyphicon glyphicon-share-alt"></div> -->
          <div class="btn-delete-feedback btn btn-danger btn-xs glyphicon glyphicon-remove"></div>
        </td>
      </tr>
      @endforeach
    </table>
    <!-- Button -->
    <div class="btn-remove">
     <button name="btn_delete_all" url="{{ asset('feedbacks/deleteall') }}" class="btn btn-danger" id="delete_all_feedback" content="{{ csrf_token() }}">Xóa lựa chọn
     </button>
     <input type="hidden" id="_token" value="{{ csrf_token() }}" />  
   </div>
   <!-- /End Button -->
   <!-- Phân trang -->
   {{ $feedbacks->links() }}
 </div>
 <!-- /End Phân trang -->
</div>
<!-- /End Bảng hiển thị danh sách câu hỏi -->


@endsection