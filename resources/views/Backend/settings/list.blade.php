<?php
    use App\Models\MSetting;
    use App\Repositories\SettingRepository;
    $setting = new MSetting();
    $settingRepository = new SettingRepository($setting);
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
    <h4>Danh sách dữ liệu</h4>
@endsection
@section('content')    
<!-- Form danh sách câu hỏi -->
<div class="bg-form">
<form class="form-horizontal">
        <fieldset>
            <!-- Từ khóa -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Từ khóa</label>
                <div class="col-md-6">
                    <input class="form-control" name="s_key" type="text" value="<?= isset ($_GET['s_key']) ? $_GET['s_key'] : '' ?>">
                </div>
            </div>
            <!-- /End Từ khóa -->

            <!-- Tên dữ liệu -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Tên dữ liệu</label>
                <div class="col-md-6">
                    <input class="form-control" name="s_name" type="text" value="<?= isset ($_GET['s_name']) ? $_GET['s_name'] : '' ?>">
                </div>
            </div>
            <!-- /End Tên dữ liệu -->
            
            <div class="form-group">
                <!-- Button -->
                <div class="col-md-10 control-button">
                    <button id="searchButton" name="searchButton" class="btn btn-search pull-right">
                        <span class="glyphicon glyphicon-search" ></span>Tìm kiếm
                    </button>
                    <a href="{{ asset('settings/list') }}" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>Reset</a>
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
    <a href="{{ asset ('settings/add') }}" class="btn btn-success">
    <span class="glyphicon glyphicon-plus"></span>Tạo dữ liệu mới</a>
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
                
                <th>ID</th>
                <th>Từ khóa</th>
                <th>Giá trị</th>
                <th>Giá trị hiển thị</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        @foreach($settings as $setting)
            
            <tr setting-id="{{ $setting->setting_id }}" id="setting_{{ $setting->setting_id }}">
                <td class="text-center">
                    <div class="ckbox">
                        <input id="{{ $setting->setting_id }}" class="check-box" name="ckb" type="checkbox">  
                        <label for="{{ $setting->setting_id }}"></label>  
                    </div>
                </td> 
                <td>{{ $setting->setting_id }}</td> 
                <td>{{ $setting->s_key }}</td>
                <td>{{ $setting->s_value }}</td>
                <td>{{ $setting->s_name }}</td>
                <td class="text-center">
                    <div class="btn-edit-setting btn btn-info btn-xs glyphicon glyphicon-edit"></div>
                    <div class="btn-delete-setting btn btn-danger btn-xs glyphicon glyphicon-remove"></div>
                </td>
            </tr>
            @endforeach
            
    </table>
    <!-- Button -->
    <div class="btn-remove">
       <button name="btn_delete_all" url="{{ asset('settings/deleteall') }}" class="btn btn-danger" id="delete_all_setting" content="{{ csrf_token() }}">Xóa lựa chọn
       </button>
       <input type="hidden" id="_token" value="{{ csrf_token() }}" />  
    </div>
    <!-- /End Button -->
    <!-- Phân trang -->
    {{ $settings->links() }}
    <!-- /End Phân trang -->
 </div>
</div>
<!-- /End Bảng hiển thị danh sách câu hỏi -->
@endsection