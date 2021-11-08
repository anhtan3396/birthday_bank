<?php
    function isChecked($now, $arrOld) {
        if (count($arrOld) > 0) {
            foreach ($arrOld as $old) {
                if ($old == $now->s_value)
                    return true;
            }
        }
        return false;
    }
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Danh sách câu hỏi</h4>
@endsection
@section('content')
<!-- Form danh sách câu hỏi -->
<div class="bg-form">
  <form class="form-horizontal" method="GET" action="">
    <fieldset>
      <!-- Câu hỏi -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="textinput">Câu hỏi</label>
        <div class="col-md-6">
          <input id="textinput" name="textinput" type="text" placeholder="Nội dung câu hỏi" class="form-control"
            value="{{ $textInput }}">
        </div>
      </div>
      <!-- /End Câu hỏi -->
      <!-- Loại -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="appendUrlParams">Loại</label>
        <div class="col-md-8">
          @foreach($types as $type)
          <div class="ckbox">
            <input type="checkbox" name="types[]" id="{{ $type->s_name }}" value="{{ $type->s_value }}"
              @if(isChecked($type, $oldTypes)) checked @endif>
            <label for="{{ $type->s_name }}"><span></span>{{ $type->s_name}}</label>
          </div>
          @endforeach
        </div>
      </div>
      <!-- /End Loại -->
      <!-- Nhóm -->
      <!-- Button -->
      <div class="form-group">
        <!-- Button -->
        <div class="col-md-10 control-button">
          <button id="searchButton" name="searchButton" class="btn btn-search">
            <span class="glyphicon glyphicon-search"></span>Tìm kiếm
          </button>
          <a href="{{ asset('admin/quizs') }}" class="btn btn-primary"><span
              class="glyphicon glyphicon-refresh"></span>Reset</a>
        </div>
        <!-- /End Button -->
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
  <a href="{{ asset ('admin/quizs/add') }}" class="btn btn-success">
    <span class="glyphicon glyphicon-plus"></span>Tạo câu hỏi mới</a>
</div>
<!-- /End Button -->
<!-- Bảng hiển thị danh sách câu hỏi -->
<div class="container-fluid">
  <div class="table-responsive">
    <table class="table table-striped custab">
      <thead>
        <tr>
          <th class="text-center">
            <div class="ckbox">
              <input id="cb_All" name="btSelectAll" type="checkbox">
              <label for="cb_All"></label>
            </div>
          </th>

          <th>#</th>
          <th style="width:10%">Loại</th>
          <th style="width:10%">Câu hỏi</th>
          <th class="text-center" style="width:5%">Hành động</th>
        </tr>
      </thead>
      @foreach($quizs as $quiz)

      <tr quiz-id="{{ $quiz->id }}" id="quiz_{{ $quiz->id }}">
        <td class="text-center">
          <div class="ckbox">
            <input id="{{ $quiz->id }}" class="check-box" name="ckb" type="checkbox">
            <label for="{{ $quiz->id }}"></label>
          </div>
        </td>
        <td>{{ $quiz->id }}</td>
        <td style="width:10%">{{ $quiz->level == 1 ? "Câu hỏi thường" : "Câu hỏi đặc biệt"}}</td>
        <td style="width:10%">{{ $quiz->content }}</td>

        <td style="width:5%" class="text-center">
          <!-- <div class="btn-detail-quiz btn btn-success btn-xs glyphicon glyphicon-eye-open"></div> -->
          <a href="{{ route('editQuiz',['id' => $quiz->id]) }}" style="text-decoration: none;">
            <div class="btn btn-info btn-xs glyphicon glyphicon-edit"></div>
          </a>
          <div class="btn-delete-quiz btn btn-danger btn-xs glyphicon glyphicon-remove"></div>
        </td>
      </tr>
      @endforeach

    </table>
    <!-- Button -->
    <div class="btn-remove">
      <button name="btn_delete_all" url="{{ asset('quizs/deleteall') }}" class="btn btn-danger" id="delete_all_quiz"
        content="{{ csrf_token() }}">Xóa lựa chọn
      </button>
      <input type="hidden" id="_token" value="{{ csrf_token() }}" />
    </div>
    <!-- /End Button -->
    <!-- Phân trang -->
    {{ $quizs->links() }}
    <!-- /End Phân trang -->
  </div>
</div>
<!-- /End Bảng hiển thị danh sách câu hỏi -->
@endsection