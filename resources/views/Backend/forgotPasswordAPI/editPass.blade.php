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

                                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Tạo mật khẩu mới</div>
                        </div>                     
                        <div class="panel-body forget-password-page">
                            <form id="signupform" class="form-horizontal" role="form" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="email" class=" control-label col-sm-4">Mật khẩu mới</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu mới">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class=" control-label col-sm-4">Nhập lại mật khẩu mới</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Nhập lại mật khẩu mới">
                                    </div>
                                </div>
                                <button name="btn submit" class="btn submit" >Lưu thay đổi
                                </button>
                                
                            </div>                      
                        </form>
                    </div>
                </div>

            </div>
            <!--/END FORGET PASSWORD-->
        </div>
    </div>
</div>
</body>

</html>