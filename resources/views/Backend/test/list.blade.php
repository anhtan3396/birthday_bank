<?php
    use App\Models\MSetting;
    use App\Models\TUserTestScore;
    use App\Repositories\SettingRepository;
    $setting = new MSetting();
    $settingRepository = new SettingRepository($setting);
    $levels = MSetting::where('s_key','LEVEL')->get();
    $types  = MSetting::where('s_key','QUIZ_TYPE')->get();
    $groups  = MSetting::where('s_key','QUIZ_KBN')->get();

    function isChecked($now, $arrOld) {
        if (count($arrOld) > 0) {
            foreach ($arrOld as $old) {
                if ($old == $now->s_value)
                    return true;
            }
        }
        return false;
    }
    
    //get total test
    function getTotalTest($id)
    {
        $total = TUserTestScore::where('test_id','=',$id)->count();
        return $total;
    }
    
?>
@extends('Backend.masterpage.masterpage')
@section('content')

@section('titleForm')
    <h4>Tạo bài kiểm tra</h4>
@endsection
<div class="bg-form">
    <form class="form-horizontal" method="GET" action="">
        <fieldset>
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Tên bài test</label>
                <div class="col-md-6">
                
                <input id="textinput" name="textInput" type="text" class="form-control" value="{{ $textInput }}">

                </div>
            </div>
                <div class="form-group">
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
                </div>
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
                <div class="form-group">
                    <label class="col-md-4 control-label" for="date-f">Ngày đăng</label>
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
                
                <div class="form-group">
                    <!-- Button -->
                    <div class="col-md-10 control-button">
                    <button id="searchButton" name="searchButton" class="btn btn-search">
                        <span class="glyphicon glyphicon-search"></span>Tìm kiếm
                    </button>
                    <a href="{{ asset('test') }}" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>Reset</a>
                    </div>
                    <!-- /End Button -->
                </div>

                <!-- /End Nhóm -->

            <hr>
        </fieldset>
    </form>
</div>

<div class="col-md-4 btn-create">
    <a href="{{ asset ('test/add') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>Tạo bài test mới</a>
</div>
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
                    <th>Hình ảnh</th>
                    <th>Trình độ</th>
                    <th>Loại</th>
                    <th>Tên bài test</th>
                    <th>Giá xu</th>
                    <th>Ngày tạo</th>
                    <th class="text-center">Tổng số bài làm</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
			
            @foreach($tests as $test)
            <tr test-id="{{ $test->test_id }}" id="test_{{ $test->test_id }}">
                <td class="text-center">
                    <div class="ckbox">
                        <input id="{{ $test->test_id }}" class="check-box" name="ckb" type="checkbox">  
                        <label for="{{ $test->test_id}}"></label>  
                    </div>
                </td> 
                <td>{{ $test->test_id }}</td>
                <td><img src="{{ URL::asset('upload/image/test/'.$test->test_id.'_'. $test->test_image_icon) }}" width="60%"></td>
                <td>{{ $settingRepository->getName($test->test_level_id,'LEVEL') }}</td>
                <td>{{ $settingRepository->getName($test->test_type_id,'QUIZ_TYPE') }}</td>
                <td>{{ $test->test_name }}</td>
                <th>{{ $test->test_price }} xu</th>
                <td>{{ $test->created_time }}</td>
                <td class="text-center">{{ getTotalTest($test->test_id) }}</td>
                <td class="text-center">
                    <div class="btn-edit-test btn btn-info btn-xs glyphicon glyphicon-edit"></div>
                    <div class="btn-delete-test btn btn-danger btn-xs glyphicon glyphicon-remove"></div>
                </td>
            </tr>
            @endforeach
    
        </table>
        <!-- Button -->
        <div class="btn-remove">
            <button name="btn_delete_all" url="{{ asset('test/deleteall') }}" class="btn btn-danger" id="delete_all_test" content="{{ csrf_token() }}">Xóa lựa chọn</button>
        <input type="hidden" id="_token" value="{{ csrf_token() }}" />  
        </div>
        <!-- /End Button -->
        <!-- Phân trang -->
        {{ $tests->links() }}
        <!-- /End Phân trang -->
    </div>
</div> 
@endsection