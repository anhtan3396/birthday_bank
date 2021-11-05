<?php
use App\Models\MSetting;
use App\Repositories\SettingRepository;
$setting = new MSetting();
$settingRepository = new SettingRepository($setting);
$user_role = MSetting::where('s_key','USER_ROLE')->get();
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Chỉnh sửa người dùng</h4>
@endsection
@section('content') 
<div class="bg-form">
    <!-- Form danh sách câu hỏi -->
    <form class="form-horizontal" enctype="multipart/form-data" method="post" >
      {{ csrf_field() }}
      <fieldset>
        <!-- Email -->
        <div class="form-group">
            <label class="col-md-4 control-label">Email</label>
            <div class="col-md-6">
                <input name="email" type="text" class="form-control" value="{{ old('email', $user->email) }}" disabled>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>                              
        </div>
        <hr>
        <!-- End Email -->
        <!-- Name -->
        <div class="form-group">
            <label class="col-md-4 control-label">Tên</label>
            <div class="col-md-6">
              <input name="nick_name" type="text" class="form-control" value="{{ old('nick_name', $user->nick_name) }}">
          <!-- </form> -->
          @if ($errors->has('nick_name'))
          <span class="help-block">
            <strong style="color: red;">{{ $errors->first('nick_name') }}</strong>
        </span>
        @endif
        </div>
    </div>
    <hr>
    <!-- End Name -->
    <!-- Phone -->
    <div class="form-group">
        <label class="col-md-4 control-label">Số Điện Thoại</label>
        <div class="col-md-6">
            <input name="phone_num" type="text" class="form-control" value="{{ old('phone_num', $user->phone_num) }}">
            @if ($errors->has('phone_num'))
            <span class="help-block">
                <strong style="color: red;">{{ $errors->first('phone_num') }}</strong>
            </span>
            @endif
        </div>                              
    </div>
    <hr>
    <!-- End Phone -->
    <!-- Pass -->
    <div class="form-group">
        <label class="col-md-4 control-label">Mật Khẩu</label>
        <div class="col-md-6">
            <input name="password" type="password" class="form-control">
            @if ($errors->has('password'))
            <span class="help-block">
                <strong style="color: red;">{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div> 
    </div>
    <hr>
    <!-- End Pass -->
    <!-- Confirm Pass -->
    <div class="form-group">
        <label class="col-md-4 control-label">Nhập Lại Mật Khẩu</label>
        <div class="col-md-6">
            <input name="password_confirmation" type="password" class="form-control" >
        </div>
    </div>
    <hr>
    <!-- End Confirm -->
    <!-- Remain_coin -->
    <div class="form-group">
        <label class="col-md-4 control-label">Số Xu</label>
        <div class="col-md-6">
            <input name="remain_coin" type="text" class="form-control" value="{{ old('remain_coin', $user->remain_coin) }}">
            @if ($errors->has('remain_coin'))
            <span class="help-block">
                <strong style="color: red;">{{ $errors->first('remain_coin') }}</strong>
            </span>
            @endif
        </div>                              
    </div>
    <hr>
    <!-- End Remain_coin -->
    <!-- User_role -->
    <div class="form-group">
        <label class="col-md-4 control-label">Quyền Đăng Nhập</label>
        <div class="col-md-6">
            <select id="comparison" name="user_role" class="form-control" disabled>
                @foreach($user_role as $role)
                <option value="{{$role->s_value}}" {{ $role->s_value==$user->user_role ? 'selected' : '' }} >{{ $role->s_name}}</option>
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
    <!-- End User_role -->
    <!-- Avatar -->
    <div class="form-group">
        <label class="col-md-4 control-label"></label>
        <div class="col-md-4">
            <div class="form-group">
                <!-- Hiển thị hình ảnh cũ/khi thay đổi hình ảnh -->
                <label id="change_img">Avatar hiện tại:</label>
                @if($user->avatar == "default_avt.png")
                <img src="{{ URL::asset('image/default_avt.png') }}" alt="..." width="100%">
                @else
                <img src="{{ URL::asset('upload/image/avatar/'.$user->avatar) }}" alt="..." width="100%">
                @endif
                <script>
                    var loadFile = function(event) {
                        var output = document.getElementById('output');
                        output.src = URL.createObjectURL(event.target.files[0]);
                        document.getElementById('change_img').innerHTML = "Hình ảnh sẽ thay thế:";
                        document.getElementById('delete_old_image').style.display = "none";
                    };
                </script>
            </div>
        </div>
    </div>
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
    <!-- End Avatar -->
    <!-- Action -->
</fieldset>
<!-- Button -->
<div class="sidebar-footer hidden-small">
    <div class="form-group">
        <!-- Button -->
        <div class="control-button">
            <a href="{{ asset('users') }}" class="btn btn-primary">
                <span class="glyphicon glyphicon-arrow-left"></span>Quay lại
            </a>
            <button id="submitButton" name="submitButton" class="btn btn-success">
                <span class="glyphicon glyphicon-floppy-disk"></span>Lưu sửa đổi</button>
            </div>
            <!-- /End Button -->
        </div>
    </div>   
</form>
</div>
@endsection



