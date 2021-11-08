@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Chỉnh sửa người dùng</h4>
@endsection
@section('content')
<div class="bg-form">
  <!-- Form danh sách câu hỏi -->
  <form class="form-horizontal" enctype="multipart/form-data" method="post">
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
        <label class="col-md-4 control-label">Team</label>
        <div class="col-md-6">
          <input type="text" class="form-control" value="{{ $user->group_id ? $user->group->name : '~' }}" disabled
            autocomplete="off">
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
      <!-- <div class="form-group">
        <label class="col-md-4 control-label">Nhập Lại Mật Khẩu</label>
        <div class="col-md-6">
            <input name="password_confirmation" type="password" class="form-control" >
        </div>
    </div>
    <hr> -->
      <!-- End Confirm -->
      <!-- User_role -->
      <div class="form-group">
        <label class="col-md-4 control-label">Quyền Đăng Nhập</label>
        <div class="col-md-6">
          <select id="comparison" name="user_role" class="form-control" @if($disableRole) disabled @endif>
            <option value="1" {{ $user->user_role ? 'selected' : '' }}>Quản trị viên</option>
            <option value="0" {{ !$user->user_role ? 'selected' : '' }}>Người dùng</option>
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
      <!-- Action -->
    </fieldset>
    <!-- Button -->
    <div class="sidebar-footer hidden-small">
      <div class="form-group">
        <!-- Button -->
        <div class="control-button">
          <a href="{{ asset('admin/users') }}" class="btn btn-primary">
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