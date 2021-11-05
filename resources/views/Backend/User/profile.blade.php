<?php
use App\Models\MSetting;
use App\Models\MUser;
use App\Repositories\UserRepository;
use App\Repositories\SettingRepository;
$setting = new MSetting();
$settingRepository = new SettingRepository($setting);
$user_role = MSetting::where('s_key','USER_ROLE')->get();
$created_user = MUser::find((int) $user->created_user);


?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Chi tiết người dùng</h4>
@endsection
@section('content') 

<div class="bg-form">
  <!-- Form danh sách câu hỏi -->
  <form class="form-horizontal" enctype="multipart/form-data" method="post" >
    {{ csrf_field() }}
    <fieldset>
      <div class="box-body box-profile">
      @if($user->avatar == "")
      <img src="{{ URL::asset('upload/image/avatar/default_avt.png') }}" alt="..." class="profile-user-img img-responsive img-circle" >
      @else
      <img src="{{ URL::asset('upload/image/avatar/'.$user->avatar) }}" alt="..." class="profile-user-img img-responsive img-circle" >
      @endif
        <h3 class="profile-username text-center">{{ $user->nick_name }}</h3>

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>Email</b> <p class="pull-right">{{$user->email}}</p>
          </li>
          <li class="list-group-item">
            <b>Số điện thoại</b> <p class="pull-right">{{$user->phone_num}}</p>
          </li>
          <li class="list-group-item">
            @if($created_user == null)
            <b>Người Tạo</b> <p class="pull-right">{{ MUser::find(1)->nick_name }}</p>
            @else
            <b>Người Tạo</b> <p class="pull-right">{{ $created_user->nick_name }}</p>
            @endif
            
          </li>
          <li class="list-group-item">
            <b>Ngày tạo</b> <p class="pull-right">{{$user->created_time}}</p>
          </li>
          <li class="list-group-item">
            <b>Số xu hiện có</b> <p class="pull-right">{{$user->remain_coin}}</p>
          </li>
          <li class="list-group-item">
            <b>Chức vụ</b> <p class="pull-right">{{ $settingRepository->getName($user->user_role,"USER_ROLE") }}</p>
          </li>
        </ul>
      </div>

    </fieldset>
    <!-- Button -->
    <div class="sidebar-footer hidden-small">
      <div class="form-group">
        <!-- Button -->
        <div class="control-button">
          <a href="{{ asset('users')}}" class="btn btn-primary">
            <span class="glyphicon glyphicon-arrow-left"></span>Quay lại
          </a>
          <a href="{{ asset ('users/edit/'. $user->user_id) }}" class="btn btn-success">
            <span class="glyphicon glyphicon-edit"></span>Chỉnh sửa người dùng
          </a>
        </div>
        <!-- /End Button -->
      </div>
    </div>
    <!-- /End Button -->
  </form>
  @endsection