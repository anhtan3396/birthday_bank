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
			<form id="pay-info" action="{{ asset('recharge/payConfirmCardVtc') }}" method="post">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<input type="hidden" name="txtOrderID" id="txtOrderID" value="<?php 
						echo strtotime(Carbon::now()) ;
					?>"  readonly placeholder="id đơn hàng" />
				<div class="inline">
					<i class="icon icon-code"></i>
					<input type="text" name="txtUserName" id="txtUserName" value="<?php 
						echo session('r_nick_name') ;
					?>"  readonly placeholder="id đơn hàng" />
				</div>
				<div class="inline">
					<i class="icon icon-network"></i> 
					<select name="lstTelco" class="lstTelco">
						<option value="VTEL">Viettel</option>
	                    <option value="VMS">MobiFone</option>
	                    <option value="GPC">Vinaphone</option>
	                    <!-- <option value="gate">Gate</option> -->
	                    <option value="VCOIN">Vcoin</option>
	                    <!-- <option value="zing">Zing</option>
	                    <option value="bit">Bit</option> -->
	                    <option value="VTCPRO">VTCPro</option>
	                    <option value="VNM">vietnamobile</option>
					</select>
				</div>
				<div class="inline cboamount" style="display: none;">
					<i class="icon icon-network"></i> 
					<select name="cboamount" >
						<option value="">-----</option>
						<option value="50000">50,000</option>
	                    <option value="100000">100,000</option>
	                    <option value="200000">200,000</option>
	                    <option value="500000">500,000</option>
					</select>
				</div>
				<div class="inline">
					<i class="icon icon-seri"></i>
					<input type="text" name="txtSeri" placeholder="Số seri">
				</div>
				<div class="inline">
					<i class="icon icon-code"></i>
					<input type="text" name="txtCode" placeholder="Mã code">
				</div>
				<div style="margin-left: 130px">
					<ul class="fa-ul loading" style="display: none">
					  <li><i class="fa-li fa fa-spinner fa-spin"></i></li>
					</ul>
				</div>
				<div class="btn-center">
					<input type="submit" class="next-step" name="" value="Tiếp Tục">
					<a class="next-step" href="{{ asset('recharge/payCancel') }}">Cancel</a>
				</div>
			</form>
			<!-- <a class="next-step" href="{{ asset('recharge/payRecharge') }}">Tiếp Tục</a> -->
		</div>
		<div class="copy-right">
			<p>@Copyright - 2017 by THAOTOKYO</p>
		</div>
	</section>	
</body>
<footer>
	<script type="text/javascript" src={{ URL::asset('js/jquery.min.js')}}></script>
	<script type="text/javascript">
		$(function(){
			$(".lstTelco").on("change",function(){
				$(this).val() == "VTCPRO"?$(".cboamount").show():$(".cboamount").hide();
			});
			$(".next-step").on("click",function(){
				$(".loading").show();
			});
		})
	</script>
</footer>
</html>