<?php
use App\Models\MSetting;
use App\Models\MUser;
use App\Repositories\UserRepository;
use App\Repositories\SettingRepository;
$setting = new MSetting();
$settingRepository = new SettingRepository($setting);
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Danh sách người mua</h4>
@endsection
@section('content')<!-- Main content -->

<div class="bg-form">  
  <span class="help-block" style=" text-align: center;">
    <strong style="color: red;">{{ $errors->first('error') }}</strong>
  </span>
  <form class="form-horizontal" method="GET" action="">
    <fieldset>
      <!-- EMAIL -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="textinput">Email</label>
        <div class="col-md-6">
          <input class="form-control" name="email" type="text" value="{{ $email}}">
        </div>
      </div>
      <!-- /End EMAIL -->
      <!-- Ngày phản hồi -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="date-f">Ngày mua</label>
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
      <!-- Button -->
      <div class="form-group">
        <!-- Button -->
        <div class="col-md-10 control-button">
          <button id="searchButton" name="searchButton" class="btn btn-search">
            <span class="glyphicon glyphicon-search"></span>Tìm kiếm
          </button>
          <a href="{{ asset('/histories/purchase') }}" class="btn btn-primary">
            <span class="glyphicon glyphicon-refresh"></span>Reset
          </a>
        </div>
        <!-- /End Button -->
      </div>

      <!-- /End Button -->
      <hr>
    </fieldset>
  </form>
  <!--/End Form danh sách phản hồi của người dùng -->
</div>
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
          <th>STT</th>
          <th>Email</th>
          <th>Loại vật phẩm</th>
          <th>Số xu mua</th>
          <th>Ngày mua</th>
          <th class="text-center">Hành động</th>
        </tr>
      </thead>
      @foreach($purchases as $purchase)
      <tr purchase-id ="{{ $purchase->id }}" id="purchase_{{ $purchase->id }}">
        <td class="text-center">
          <div class="ckbox">
            <input id="{{ $purchase->id }}" class="check-box" name="ckb" type="checkbox">  
            <label for="{{ $purchase->id }}"></label>  
          </div>
        </td> 
        <td>{{ $purchase->id }}</td> 
        <td>{{ MUser::find((int) $purchase->user_id)->email }}</td>
        <td>{{ $settingRepository->getName($purchase->purchase_item_type,'PURCHASE_ITEM_TYPE') }}</td>
        <td>{{ $purchase->purchase_coin }}</td>
        <td>{{ $purchase->purchase_time }}</td>
        <td class="text-center">
          <div class="btn-delete-purchase btn btn-danger btn-xs glyphicon glyphicon-remove"></div>
          <div class="btn-detail-purchase btn btn-success btn-xs glyphicon glyphicon-eye-open"></div>
        </td>
      </tr>
      @endforeach
    </table>
    <!-- Button -->
    <div class="btn-remove">
     <button name="btn_delete_all" url="{{ asset('histories/purchase/deleteall') }}" class="btn btn-danger" id="delete_all_purchase" content="{{ csrf_token() }}">Xóa lựa chọn
     </button>
     <input type="hidden" id="_token" value="{{ csrf_token() }}" />  
   </div>
   <!-- /End Button -->
   <!-- Phân trang -->
   {{ $purchases->links() }}
 </div>
 <!-- /End Phân trang -->
</div>
<!-- /End Bảng hiển thị danh sách câu hỏi -->


@endsection