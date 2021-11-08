@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Danh sách người dùng</h4>
@endsection
@section('content')
<div class="bg-form">
  <!-- Form danh sách bài test -->
  <form class="form-horizontal">
    <fieldset>

      <!-- EMAIL -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="textinput">Email</label>
        <div class="col-md-6">
          <input class="form-control" name="email" type="text"
            value="<?= isset ($_GET['email']) ? $_GET['email'] : '' ?>">
        </div>
      </div>
      <!-- /End EMAIL -->

      <!-- TÊN NGƯỜI DÙNG -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="textinput">Tên người dùng</label>
        <div class="col-md-6">
          <input class="form-control" name="nick_name" type="text"
            value="<?= isset ($_GET['nick_name']) ? $_GET['nick_name'] : '' ?>">
        </div>
      </div>
      <!-- /End TÊN NGƯỜI DÙNG -->

      <div class="form-group">
        <!-- Button -->
        <div class="col-md-10 control-button">
          <button id="searchButton" name="searchButton" class="btn btn-search pull-right">
            <span class="glyphicon glyphicon-search"></span>Tìm kiếm
          </button>
          <a href="{{ asset('admin/users') }}" class="btn btn-primary"><span
              class="glyphicon glyphicon-refresh"></span>Reset</a>
        </div>
        <!-- /End Button -->
      </div>
      <!-- /End Nhóm -->
    </fieldset>
  </form>
  <!--/End Form danh sách câu hỏi -->
</div>
<!-- /End Info search -->
<!-- Button -->
<div class="col-md-4 btn-create">
  <a href="{{ route('user.add') }}" class=" btn btn-success"><span class="glyphicon glyphicon-plus"></span>Tạo người
    dùng mới</a>
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
          <th>Họ và tên</th>
          <th>Điểm kinh nghiệm</th>
          <th>Cấp độ Vie</th>
          <th>Team</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <span class="help-block">
          <strong style="color: red;">{{ $errors->first('user_del') }}</strong>
        </span>
        @foreach($users as $user)
        <tr user-id="{{ $user->id }}">
          <td>{{ $user->id }}</td>
          <td>{{ $user->email }}</td>
          <th><a href="{{ route('user.edit',['id' => $user->id]) }}">{{
              $user->nick_name }}</a></th>
          <th>{{ $user->experience }}</th>
          <th>{{ $user->level }}</th>
          <th>{{ $user->group ? $user->group->name : "~"}}</th>
          <td class="text-center">
            <a href="{{ route('user.edit',['id' => $user->id]) }}" style="text-decoration: none;">
              <div class="btn btn-info btn-xs glyphicon glyphicon-edit"></div>
            </a>
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