<?php
use App\Models\MSetting;
use App\Repositories\SettingRepository;
$setting = new MSetting();
$settingRepository = new SettingRepository($setting);
$user_role = MSetting::where('s_key','USER_ROLE')->get();
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Tạo mới người dùng</h4>
@endsection
@section('content') 
<div class="bg-form">
    <!-- Form danh sách người dùng -->
    <form class="form-horizontal"  enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <fieldset>
        
        <!-- EMAIL -->
        <div class="form-group">
            <label class="col-md-4 control-label">Email</label>
            <div class="col-md-6">
                <input name="email" type="text" class="form-control" value="{{ old('email') }}" @if (old('email') == 1) checked @endif>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>                              
        </div>
        <hr>
        <!-- END ÉMAIL -->

        <!-- PHONE -->
        <div class="form-group">
            <label class="col-md-4 control-label">Số Điện Thoại</label>
            <div class="col-md-6">
                <input name="phone_num" type="text" class="form-control" value="{{ old('phone_num') }}" @if (old('phone_num') == 1) checked @endif>
                @if ($errors->has('phone_num'))
                <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('phone_num') }}</strong>
                </span>
                @endif
            </div>                              
        </div>
        <hr>
        <!-- END PHONE -->

        <!-- NAME -->
        <div class="form-group">
            <label class="col-md-4 control-label">Họ Và Tên</label>
            <div class="col-md-6">
              <input name="nick_name" type="text" class="form-control" value="{{ old('nick_name') }}" @if (old('nick_name') == 1) checked @endif>
              @if ($errors->has('nick_name'))
              <span class="help-block">
                <strong style="color: red;">{{ $errors->first('nick_name') }}</strong>
            </span>
            @endif
            </div>
        </div>
        <hr>
        <!-- END NAME -->

        <!-- PASS -->
        <div class="form-group">
            <label class="col-md-4 control-label">Mật Khẩu</label>
            <div class="col-md-6">
                <input name="password" type="password" class="form-control" @if (old('password') == 1) checked @endif>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <hr>
        <!-- END PASS -->

        <!-- CONFIRM PASS -->
        <div class="form-group">
            <label class="col-md-4 control-label">Nhập Lại Mật Khẩu</label>
            <div class="col-md-6">
                <input name="password_confirmation" type="password" class="form-control">
            </div>
        </div>
        <hr>
        <!-- END CONFIRM -->

        <!-- REMAIN_COIN -->
        <div class="form-group">
            <label class="col-md-4 control-label">Số Xu</label>
            <div class="col-md-6">
                <input name="remain_coin" type="text" class="form-control" value="{{ old('remain_coin',0) }}" @if (old('remain_coin') == 1) checked @endif>
                @if ($errors->has('remain_coin'))
                <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('remain_coin') }}</strong>
                </span>
                @endif
            </div>                              
        </div>
        <hr>
        <!-- END REMAIN_COIN -->

        <!-- USER_ROLE -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="comparison">Quyền Đăng Nhập</label>
            <div class="col-md-6">
                <select id="comparison" name="user_role" class="form-control">
                    @foreach($user_role as $type)
                    <option value="{{ $type->s_value }}" @if (old('user_role') == $type->s_value) selected @endif >{{ $type->s_name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('user_role'))
                <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('user_role') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <hr>
        <!-- END USER_ROLE -->

        <!-- AVATAR -->
        <div class="form-group">
           <label class="col-md-4 control-label">Hình ảnh</label>
           <div class="col-md-6">
            <div class="form-group files">
                <input type="file" onchange="loadFile(event)" name="avatar" class="form-control" multiple="">
                <!-- hiển thị hình khi chọn-->
                <script>
                    var loadFile = function(event) {
                        var output = document.getElementById('output');
                        output.src = URL.createObjectURL(event.target.files[0]);
                    };
                </script> 
            </div>
            <p><img id="output" style="width:100px" class="img-responsive"/></p>        
        </div>
        @if ($errors->has('avatar'))
        <span class="help-block">
            <strong style="color: red;">{{ $errors->first('avatar') }}</strong>
        </span>
        @endif
    </div>
    <hr>
    <!-- END AVATAR -->
        </fieldset>
    <!-- /.box-body -->
        <div class="sidebar-footer hidden-small">
            <div class="form-group">
                <!-- Button -->
                <div class="control-button">
                    <a href="{{ asset('users') }}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-arrow-left"></span>Quay lại
                    </a>
                    <button id="submitButton" name="submitButton" class="btn btn-success">
                        <span class="glyphicon glyphicon-floppy-disk"></span>Lưu người dùng</button>
                    </div>
                    <!-- /End Button -->
                </div>
        </div>   
    <!-- End button  -->
</form>
<!-- End danh sách tạo người dùng -->
</div>
@endsection
