<?php
use App\Models\MSetting;
use App\Models\MUser;
use App\Models\TRechargeHistory;
use App\Repositories\SettingRepository;
$setting = new MSetting();
$settingRepository = new SettingRepository($setting);
?>
@extends('Backend.masterpage.masterpage')
@section('titleForm')
    <h4>Chi tiết nạp tiền</h4>
@endsection
@section('content')   

<div class="bg-form">
            <!-- Form danh sách câu hỏi -->
           <form class="form-horizontal">
                <fieldset>
                    <!-- Email -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="comparison">Email người nạp tiền</label>
                        <label class="col-md-4 control-view" for="comparison">{{ MUser::find((int) $recharges->user_id)->email }}</label>
                    </div>  
                    <hr>
                    <!-- /End Email -->
    
                    <!-- Lời phản hồi -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Cách thức thanh toán</label>
                        <label class="col-md-6 control-view" for="comparison">
                            {{ $settingRepository->getName($recharges->recharge_type,'RECHARGE_TYPE')  }}
                        </label>
                    </div>
                    <hr>
                    <!-- /End Lời phản hồi -->

                    <!-- Ngày trả lời -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Số tiền nạp</label>
                        <label class="col-md-6 control-view" for="comparison">{{ $recharges->money }}</label>
                    </div>
                    <hr>                 
                    <!-- /End Ngày trả lời -->

                    <!-- Ngày trả lời -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Số xu được qui đổi</label>
                        <label class="col-md-6 control-view" for="comparison">{{ $recharges->coin }}</label>
                    </div>
                    <hr>                 
                    <!-- /End Ngày trả lời -->
                    
                    <!-- Nội dung phản hồi -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Thời gian nạp tiền</label>
                        <label class="col-md-6 control-view" for="comparison">
                            {{old('recharge_time',$recharges->recharge_time) }}
                        </label>
                    </div>     
                    <hr>
                    <!-- /End Nội dung phản hồi -->
                    
                </fieldset>
                <!-- Button -->
                <div class="sidebar-footer hidden-small">
                    <div class="form-group">
                        <!-- Button -->
                        <div class="control-button">
                            <a href="{{ asset('/histories/recharge') }}" class="btn btn-primary">
                                <span class="glyphicon glyphicon-arrow-left"></span>Quay lại
                            </a>
                        </div>
                        <!-- /End Button -->
                    </div>
                </div>   
                <!-- /End Button -->
            </form>
            <!--/End Form Chi tiết phản hồi -->
    </div>
    
@endsection