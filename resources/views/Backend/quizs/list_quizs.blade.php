<?php
    use App\Models\MSetting;
    use App\Repositories\SettingRepository;
    $setting = new MSetting();
    $settingRepository = new SettingRepository($setting);

    $levels = MSetting::where('s_key','LEVEL')->get();
    $types  = MSetting::where('s_key','QUIZ_TYPE')->get();

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
        <!-- Trình độ -->
        {{-- <div class="form-group">
            <label class="col-md-4 control-label" for="appendUrlParams">Trình độ</label>
            <div class="col-md-8">
            @foreach($levels as $level)
                <div class="ckbox">
                    <input type="checkbox"
                        name="levels[]"
                        id="{{ $level->s_name }}"
                        value="{{ $level->s_value }}"
                        @if(isChecked($level, $oldLevels)) checked @endif
                    >
                    <label for="{{ $level->s_name }}"><span></span>{{ $level->s_name }}</label>
                </div>
            @endforeach
            </div>
        </div> --}}
        <!-- /End Trình độ -->
        <!-- Loại -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="appendUrlParams">Loại</label>
            <div class="col-md-8">
                @foreach($types as $type)
                <div class="ckbox">
                    <input type="checkbox"
                        name="types[]"
                        id="{{ $type->s_name }}"
                        value="{{ $type->s_value }}"

                       @if(isChecked($type, $oldTypes)) checked @endif
                    >
                    <label for="{{ $type-> s_name }}"><span></span>{{ $type->s_name }}</label>
                </div>
                @endforeach
            </div>
        </div>
        <!-- /End Loại -->
        <!-- Nhóm -->
        {{-- <div class="form-group">
            <label class="col-md-4 control-label" for="appendUrlParams">Nhóm</label>
            <div class="col-md-4">
                @foreach($groups as $group)
                <div class="ckbox">
                    <input type="checkbox"
                        name="groups[]"
                        id="{{ $group-> s_name }}"
                        value="{{ $group->s_value }}"
                        @if(isChecked($group, $oldGroups)) checked @endif
                    >
                    <label for="{{ $group-> s_name }}"><span></span>{{ $group->s_name }}</label>
                </div>
                @endforeach
            </div> --}}
            <!-- Button -->
            <div class="form-group">
                <!-- Button -->
                <div class="col-md-10 control-button">
                    <button id="searchButton" name="searchButton" class="btn btn-search">
                        <span class="glyphicon glyphicon-search"></span>Tìm kiếm
                    </button>
                    <a href="{{ asset('admin/quizs') }}" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>Reset</a>
                </div>
                <!-- /End Button -->
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
                <th>Trình độ</th>
                <th>Loại</th>
                <th>Nhóm</th>
                <th>Câu hỏi</th>
                <th>Ngày đăng</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        @foreach($quizs as $quiz)

            <tr quiz-id="{{ $quiz->quiz_id }}" id="quiz_{{ $quiz->quiz_id }}">
                <td class="text-center">
                    <div class="ckbox">
                        <input id="{{ $quiz->quiz_id }}" class="check-box" name="ckb" type="checkbox">
                        <label for="{{ $quiz->quiz_id }}"></label>
                    </div>
                </td>
                <td>{{ $quiz->quiz_id }}</td>
                <td>{{ $settingRepository->getName($quiz->level_id,'LEVEL') }}</td>
                <td>{{ $settingRepository->getName($quiz->quiz_type,'QUIZ_TYPE') }}</td>
                <td>{{ $settingRepository->getName($quiz->quiz_kbn,'QUIZ_KBN') }}</td>
                <td style="width:40%">{{ $quiz->content }}</td>
                <td>{{ $quiz->created_time }}</td>

                <td class="text-center">
                    <div class="btn-detail-quiz btn btn-success btn-xs glyphicon glyphicon-eye-open"></div>
                    <div class="btn-edit-quiz btn btn-info btn-xs glyphicon glyphicon-edit"></div>
                    <div class="btn-delete-quiz btn btn-danger btn-xs glyphicon glyphicon-remove"></div>
                </td>
            </tr>
            @endforeach

    </table>
    <!-- Button -->
    <div class="btn-remove">
       <button name="btn_delete_all" url="{{ asset('quizs/deleteall') }}" class="btn btn-danger" id="delete_all_quiz" content="{{ csrf_token() }}">Xóa lựa chọn
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
