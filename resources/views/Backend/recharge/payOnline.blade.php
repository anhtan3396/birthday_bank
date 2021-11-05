<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Japanese Test | Thanh Toán</title>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/pay-online.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
  	<script src="{{ URL::asset('js/jquery.min.js') }}" type="text/javascript"></script>

</head>
<body>
	<section class="wrapper-pay">
		<div class="content">
			<div class="group-btn">
				<a href="javascript:void(0);" chref="{{ asset('recharge/payInfoCardVtc') }}" class="btn btn__card active btn_payOnline">Thẻ cào</a>
				<a href="javascript:void(0);" chref="{{ asset('recharge/payInfoBankVtc') }}" class="btn btn__inap btn_payOnline">Ngân hàng</a>
				<a style="display: none" href="javascript:void(0);" chref="{{ asset('recharge/payInfoCardVtc') }}" class="btn btn__visa btn_payOnline">Visa</a>
				<a style="display: none" href="javascript:void(0);" chref="{{ asset('recharge/payInfoBankCharging') }}" class="btn btn__bank btn_payOnline">Localbank</a>
			</div>
			<div class="guide-pay">
				<h4>Hướng dẫn thanh toán</h4>
				<ul>
					<li>Bước 1: Chọn hình thức thanh toán</li>
					<li>Bước 2: Nhấn tiếp tục</li>
				</ul>
			</div>
			<div class="btn-center">
			<div style="margin-left: 130px">
				<ul class="fa-ul loading" style="display: none">
				  <li><i class="fa-li fa fa-spinner fa-spin"></i></li>
				</ul>
			</div>
			<div>
				<a class="next-step" href="{{ asset('recharge/payInfoCardVtc') }}">Tiếp Tục</a>
			</div>
			<a class="next-step" href="{{ asset('recharge/payCancel') }}">Cancel</a>
			</div>
		</div>
		<div class="copy-right">
			<p>@Copyright - 2017 by THAOTOKYO</p>
		</div>
	</section>
	<script type="text/javascript">
		$('.btn_payOnline').on( 'click',function(){
			$('.btn_payOnline').removeClass('active');
			$(this).addClass('active');
			// son 
			$(".next-step").attr("href",$(this).attr("chref"));
		});
		$(".next-step").on("click",function(){
			$(".loading").show();
		});
	</script>
</body>
</html>