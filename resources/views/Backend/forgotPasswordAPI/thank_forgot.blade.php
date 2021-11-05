<!DOCTYPE html>
<html>
<head>
    @include('Backend.masterpage.head')
</head>
<body>
    <div class="type-login">
        <div class="container">
            <div class="row">
                <!--BACKGROUND-->
                <div class="cover-bg cover-bg-reset"></div>
                <!--/END BACKGROUND-->

                <!--FORGET PASSWORD-->
                <div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                    <!--LOGO-->
                    <div class="logo">
                        <img src="{{ URL::asset('image/logo.png') }}" alt="logo">
                    </div>
                    <!--/END LOGO-->


                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Tạo mật khẩu mới</div>
                        </div>                     
                        <div class="panel-body forget-password-page text-center">
                            <form id="signupform" class="form-horizontal" role="form" method="post">
                                {{ csrf_field() }}
                                <p>Bạn đã đổi mật khẩu thành công.</p>
                                <p>Cảm ơn bạn đã sử dụng App.</p>
                            </form>        
                            </div>                      
                        
                    </div>
                </div>

            </div>
            <!--/END FORGET PASSWORD-->
        </div>
    </div>
</div>
</body>

</html>