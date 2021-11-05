<?php 
use App\Models\MUser;
use App\Models\MSetting;
use App\Repositories\SettingRepository;
$setting = new MSetting();
$settingRepository = new SettingRepository($setting);
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
    <h4>Lịch sử nạp tiền</h4>
@endsection
@section('content')  
<!-- Form lịch sử nạp tiền -->
<div class="bg-form">
<span class="help-block" style=" text-align: center;">
    <strong style="color: red;">{{ $errors->first('error') }}</strong>
  </span>
 <form class="form-horizontal" method="GET" action="">
    <fieldset>
        <!-- Câu hỏi -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Email</label>
            <div class="col-md-6">
                <input id="textinput" name="email" type="text" placeholder="Email" class="form-control"
                value="{{ $email }}">
            </div>
        </div>
        <!-- /End Câu hỏi -->
        <!-- Ngày -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="date-f">Ngày thanh toán(từ)</label>
            <div class="col-md-6">
            <input id="date-f" name="date-f" value="{{ $oldDate_f }}" type="date" class="form-control">
            </div>
        </div>
        <!-- /End Ngày đăng từ -->
        <!-- Ngày -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="date-t">Ngày thanh toán(đến)</label>
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
            <a href="{{ asset('histories/recharge') }}" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>Reset</a>
            </div>
            <!-- /End Button -->
        </div>
    </fieldset>
 </form>
 <!--/End Form  -->
</div>
<!-- /End Info search -->

<!-- Bảng hiển thị danh sách  -->
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
                <th>Số thứ tự</th>
                <th>Email</th>
                <th>Loại nạp tiền</th>
                <th>Số tiền</th>
                <th>Số xu quy đổi</th>
                <th>Thời gian nạp tiền</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
            @foreach($recharges as $val)
            <tr recharge-id="{{ $val->id }}" id="recharge_{{ $val->id }}">
                <td class="text-center">
                    <div class="ckbox">
                        <input id="{{ $val->id }}" class="check-box" name="ckb" type="checkbox">  
                        <label for="{{ $val->id }}"></label>  
                    </div>
                </td>
                <td>{{ $val->id }}</td>
                <td>{{ MUser::find((int) $val->user_id)->email }}</td>                                     
                <td>{{ $settingRepository->getName($val->recharge_type,'RECHARGE_TYPE')  }}</td>                           
                <td>{{ $val->money }}</td>
                <td>{{ $val->coin }}</td>
                <td>{{ $val->recharge_time }}</td>
                <td class="text-center">
                    <div class="btn-delete-recharge btn btn-danger btn-xs glyphicon glyphicon-remove"></div>
                    <div class="btn-detail-recharge btn btn-success btn-xs glyphicon glyphicon-eye-open"></div>
                </td>
            </tr>
            @endforeach
    </table>
    <!-- Button -->
    <div class="btn-remove">
       <button name="btn_delete_all" url="{{ asset('rechages/deleteall') }}" class="btn btn-danger" id="delete_all_recharges" content="{{ csrf_token() }}">Xóa lựa chọn
       </button>
       <input type="hidden" id="_token" value="{{ csrf_token() }}" />  
    </div>
    <!-- /End Button -->
    <!-- Phân trang -->
     {{ $recharges->links() }}
    <!-- /End Phân trang -->
 </div>
</div>
<!-- /End Bảng hiển thị danh sách câu hỏi --> 
@endsection