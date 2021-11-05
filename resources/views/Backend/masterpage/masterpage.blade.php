<!DOCTYPE html>
<html>
<head>  
	@include('Backend.masterpage.head')
</head>
<body>
	@include('Backend.masterpage.header')
	<div class="container bg-color">
		<div class="row main nav-md">
			<!--SIDEBAR LEFT-->
			<div class="col-md-3 left_col">
				@include('Backend.masterpage.side-bar')
			</div>
			<!--/END SIDEBAR LEFT-->
			<div class="right-col">
				<div class="content-header">
					{!! Breadcrumbs::render()!!}
					@yield('titleForm')
				</div>
				<div class="main-content">
					@yield('content')
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	@include('Backend.masterpage.footer')
</body>
</html>

