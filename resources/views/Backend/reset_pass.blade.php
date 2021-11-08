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
        <div class="cover-bg"></div>
        <!--/END BACKGROUND-->

        <!--LOGIN-->
        <div class="landing-page">
          <!--LOGO-->
          <div class="logo">
            <!-- <img src="{{ URL::asset('image/logo.png') }}" alt="logo"> -->
          </div>
          <!--/END LOGO-->

          <!--FORM LOGIN-->
          <div class="login-page account-container">
            <h1>Vui lòng đổi mật khẩu đăng nhập</h1>

            <form action="" method="post">
              {{ csrf_field() }}
              <fieldset>

                <div class="form-group">
                  <input class="form-control" placeholder="Mật khẩu" name="password" type="password" value=""
                    autocomplete=false>
                  <hr>
                  <input class="form-control" placeholder="Nhập lại mật khẩu" name="password_confirmation"
                    type="password" value="">
                </div>

                <span class="help-block">
                  <strong style="color: #fff;">{{ $errors->first() }}</strong>
                </span>

                <!--BUTTON LOGIN-->
                <input class="btn submit-button" type="submit" value="Cập nhật">
                <!--/END BUTTON LOGIN-->

              </fieldset>
            </form>

          </div>
          <!--/END FORM LOGIN-->

        </div>
        <!--/END LOGIN-->
      </div>
    </div>
  </div>

</body>

</html>