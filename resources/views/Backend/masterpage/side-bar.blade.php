<?php
    use App\Utils\SessionManager;
    $currentLogin = SessionManager::getLoginInfo();
    $paramater = Request::segment(1);
    $view = Request::segment(2);
?>
<div class="sidebar">
  <div class="container-fluid">
    <div class="row main nav-md">
      <!--SIDEBAR LEFT-->
      <div class="col-md-3 left_col">
        <div class="scroll-view">
          <!--PROFILE-->
          <div class="profile clearfix">
            <div class="profile_pic">
              @if($currentLogin->avatar == "default_avt.png" || $currentLogin->avatar == "")
              <img src="{{ URL::asset('upload/image/avatar/default_avt.png') }}" alt="..."
                class="img-circle profile_img">
              @else
              <img src="{{ URL::asset('upload/image/avatar/'.$currentLogin->avatar) }}" alt="..."
                class="img-circle profile_img">
              @endif
            </div>
            <div class="profile_info">
              <h2>{{ $currentLogin->nick_name }}</h2>
              <span>Admin</span>
            </div>
          </div>
          <!--/END PROFILE-->
          <!--SIDEBAR MENU-->
          <div class="main_menu">
            <div class="menu_section">
              <h3>Tổng quát</h3>
              <ul class="nav side-menu panel-group" id="accordionGeneral">
                <!--HOME-->
                @if($paramater == "")
                <li>
                  <a href="{{ asset('/admin') }}" class="active">
                    <i class="fa fa-home"></i> Trang chủ
                  </a>
                </li>
                @else
                <li>
                  <a href="{{ asset('/admin') }}">
                    <i class="fa fa-home"></i> Trang chủ
                  </a>
                </li>
                @endif
                <!--/END HOME-->
                <!--USER-->
                @if($paramater == "users")
                <li>
                  <a href="{{ asset('/admin/users') }}" class="active">
                    <i class="fa fa-user"></i> Người dùng
                  </a>
                </li>
                @else
                <li>
                  <a href="{{ asset('/admin/users') }}">
                    <i class="fa fa-user"></i> Người dùng
                  </a>
                </li>
                @endif
                <!--/END USER-->

                <!--CÂU HỎI-->
                @if($paramater == "quizs")
                <li>
                  <a href="{{ asset('/admin/quizs') }}" class="active">
                    <i class="fa fa-question"></i> Câu hỏi
                  </a>
                </li>
                @else
                <li>
                  <a href="{{ asset('/admin/quizs') }}">
                    <i class="fa fa-question"></i> Câu hỏi
                  </a>
                </li>
                @endif
                <!--/END CÂU HỎI-->
              </ul>
            </div>
          </div>
          <!--/END SIDEBAR MENU-->
          <!--MENU FOOTER-->
          <div class="sidebar-footer hidden-small">
            <!-- <a href="{{ asset('settings/list') }}" class="sidebar "data-placement="top" title="Cài đặt">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            Cài đặt
          </a> -->
            <a href="{{ asset('/admin/logout')}}" class="sidebar " data-placement="top" title="Đăng xuất">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              Đăng xuất
            </a>
          </div>
          <!--/END MENU FOOTER-->
        </div>
      </div>
      <!--/END SIDEBAR LEFT-->
    </div>
  </div>
  <div class="clearfix"></div>
</div>