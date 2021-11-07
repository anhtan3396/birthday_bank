<?php
    use App\Utils\SessionManager;
    $currentLogin = SessionManager::getLoginInfo();
?>
<div class="header">
  <div class="container" style="width: 100%">
    <div class="row main nav-md">

      <div class="nav_title">
        <a href="{{ asset('/') }}" class="site_title">
          <i><img src="{{ URL::asset('image/logo.png')}}" alt="" width="34" height="36"></i>
          <span>BANK</span>
        </a>
      </div>

      <!--TOP NAV-->
      <div class="top_nav">
        <div class="nav_menu">
          <nav>
            <!--BUTTON TOGGLE BAR-->
            <div class="nav toggle">
              <a id="btn_menu"><i class="fa fa-bars"></i></a>
            </div>
            <!--/END BUTTON TOGGLE BAR-->

            <!--NAVBAR RIGHT-->
            <ul class="nav navbar-nav navbar-right">

            </ul>
            <!--/END NAVBAR RIGHT-->
          </nav>
        </div>
      </div>
      <!--/END TOP NAV-->
      <div class="clearfix"></div>
    </div>
  </div>

</div>