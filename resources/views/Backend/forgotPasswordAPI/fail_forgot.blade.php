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
                            <div class="panel-title">Lỗi</div>
                        </div>                     
                        <div class="panel-body forget-password-page">
                            <form id="signupform" class="form-horizontal" role="form" method="post">
                                {{ csrf_field() }}
                                <p>Xin lỗi, không có tài khoản này hoặc hasb bị sai hay hết thời gian.</p>
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