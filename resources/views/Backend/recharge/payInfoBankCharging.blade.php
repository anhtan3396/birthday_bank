<?php 
	use App\Utils\SessionManager;
	use Carbon\Carbon;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Japanese Test | Thanh Toán</title>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/pay-online.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
</head>
<body>
	@if(isset($user_id))
		<section class="wrapper-pay">
			<div class="content">
				<div class="title">
					<h2>Thông tin thanh toán</h2>
					<h4>(Vui lòng nhập các thông tin bên dưới)</h4>
				</div>
				@if(Session::has("flash_level"))
					<div style="margin-left: 15px" class='alert alert-{!! Session::get("flash_level")  !!}'>
						{!! Session::get("flash_message") !!}
					</div>	
				@endif
				@if($errors->any())
					<div style="margin-left: 15px" class="alert alert-danger">
						<ul>
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<form name="pay-info" id="pay-info" action="{{ asset('recharge/payInfoBankCharging') }}" method="post">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="inline">
						<i class="icon icon-code"></i>
						<input type="text" name="order_id" id="order_id" value="<?php 
							echo strtotime(Carbon::now()) ;
						?>"  readonly placeholder="id đơn hàng">
					</div>
					<div class="inline">
						<i class="icon icon-seri"></i>
						<input type="text" name="amount" placeholder="lớn hơn 10.000">
					</div>
					<div class="inline">
						<i class="icon icon-seri"></i>
						<input type="text" name="order_info" placeholder="Nhập order info">
					</div>
					<input type="submit" class="next-step" name="" value="Tiếp Tục">
					<a class="next-step" href="{{ asset('recharge/payCancel') }}">Cancel</a>
				</form>
				<!-- <a class="next-step" href="{{ asset('recharge/payRecharge') }}">Tiếp Tục</a> -->
			</div>
			<div class="copy-right">
				<p>@Copyright - 2017 by THAOTOKYO</p>
			</div>
		</section>	
	@endif
</body>
</html>