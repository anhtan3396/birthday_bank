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
            <div class="cover-bg cover-bg-pass"></div>
            <!--/END BACKGROUND-->

            <!--FORGET PASSWORD-->
            <div class="landing-page">
                <!--LOGO-->
                <div class="logo">
                    <img src="{{ URL::asset('image/logo.png') }}" alt="logo">
                </div>
                <!--/END LOGO-->

                <!--FORM FORGET PASSWORD-->
                <div class="forget-password-page account-container">
                    <h2>Quên Mật Khẩu?</h2>
                    <h1>Vui lòng nhập email để nhận hướng dẫn thay đổi mật khẩu!</h1>

                    <form method="POST">
                        {{ csrf_field() }}
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="text">
                            </div>
                            <span class="help-block">
                                <strong style="color: #fff;">{{ $errors->first('error') }}</strong>
                            </span>
                            
                            <!--BUTTON FORGET PASSWORD-->
                            <input class="btn submit"  type="submit" value="Gửi">
                            <!--/END BUTTON FORGET PASSWORD-->
                            
                        </fieldset>
                    </form>

                </div>
                <!--/END FORM FORGET PASSWORD-->

            </div>
            <!--/END FORGET PASSWORD-->
        </div>
    </div>
</div>
 </body>

</html>