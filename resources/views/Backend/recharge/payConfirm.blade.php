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
		<div class="content" id="pay-confirm">
			<div class="title">
				<h2>Xác nhận thanh toán</h2>
			</div>
			<div class="wrapper-info">
				<div class="info-user">
					<label>Thông tin cá nhân</label>
					<p>Tên: {!! $user_id["nick_name"] !!}</p>
				</div>
				<div class="pay-method">
					<label>Phương thức thanh toán</label>
					<p>{!! $recharge_type !!}</p>
					<p>Số tiền đã nạp: {!! sprintf(' %s', number_format( $amount, 2)) !!} vnđ</p>
					<p>Tài khoản đã được cộng {!! sprintf(' %s', number_format($amount/1000, 2)) !!} xu</p>
				</div>
			</div>
			<div style="margin-left: 130px">
				<ul class="fa-ul loading" style="display: none">
				  <li><i class="fa-li fa fa-spinner fa-spin"></i></li>
				</ul>
			</div>
			<a class="next-step" href="{{ asset('recharge/payCancel') }}">Hoàn tất</a>
		</div>
		<div class="copy-right">
			<p>@Copyright - 2017 by THAOTOKYO</p>
		</div>
	</section>
	@endif
</body>
<footer>
	<script type="text/javascript">
		$(function(){
			$(".next-step").on("click",function(){
				$(".loading").show();
			});
		})
	</script>
</footer>
</html>