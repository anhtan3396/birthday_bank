<?php
use App\Models\MSetting;
$setting = new MSetting();
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Danh sách người dùng</h4>
@endsection
@section('content')     
<div class="bg-form">
    <!-- Form danh sách bài test -->
    <form class="form-horizontal">
        <fieldset>
            <!-- ID -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Số điện thoại</label>
                <div class="col-md-6">
                    <input class="form-control" name="phone_num" value="<?= isset ($_GET['phone_num']) ? $_GET['phone_num'] : '' ?>">
                </div>
            </div>
            <!-- /End ID -->

            <!-- EMAIL -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Email</label>
                <div class="col-md-6">
                    <input class="form-control" name="email" type="text" value="<?= isset ($_GET['email']) ? $_GET['email'] : '' ?>">
                </div>
            </div>
            <!-- /End EMAIL -->

            <!-- TÊN NGƯỜI DÙNG -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Tên người dùng</label>
                <div class="col-md-6">
                    <input class="form-control" name="nick_name" type="text" value="<?= isset ($_GET['nick_name']) ? $_GET['nick_name'] : '' ?>">
                </div>
            </div>
            <!-- /End TÊN NGƯỜI DÙNG -->
            
            <div class="form-group">
                <!-- Button -->
                <div class="col-md-10 control-button">
                    <button id="searchButton" name="searchButton" class="btn btn-search pull-right">
                        <span class="glyphicon glyphicon-search" ></span>Tìm kiếm
                    </button>
                    <a href="{{ asset('users') }}" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>Reset</a>
                </div>
                <!-- /End Button -->
            </div>
            <!-- /End Nhóm -->
            <hr>
        </fieldset>
    </form>
    <!--/End Form danh sách câu hỏi -->
</div>
<!-- /End Info search -->
<!-- Button -->
<div class="col-md-4 btn-create">
    <a href="{{ asset ('users/add') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>Tạo người dùng mới</a>
</div>
<!-- /End Button -->
<!-- Bảng hiển thị danh sách bài test -->
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-striped custab">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Họ và tên</th>
                    <th>Số xu</th>
                    <th>Ngày tạo</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <span class="help-block">
                <strong style="color: red;">{{ $errors->first('users') }}</strong>
                </span>
                @foreach($users as $user)
                <tr user-id="{{ $user->user_id }}">
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->email }}</td>
                    <th>{{ $user->phone_num  }}</th>
                    <th><a href="{{asset('profile/'. $user->user_id) }}">{{ $user->nick_name  }}</a></th>
                    <th>{{ $user->remain_coin  }}</th>
                    <th>{{ $user->created_time  }}</th>
                    <td>
                        <div class="btn-edit btn btn-info btn-xs glyphicon glyphicon-edit"></div>
                        <div class="btn-delete btn btn-danger btn-xs glyphicon glyphicon-remove"></div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            
        </table>
        <!-- Phân trang -->
        {{ $users->links() }}
        <!-- /End Phân trang -->
    </div>
</div>
<!-- /End Bảng hiển thị danh sách bài test -->
@endsection