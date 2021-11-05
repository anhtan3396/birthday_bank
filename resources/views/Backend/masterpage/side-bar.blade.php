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
              <img src="{{ URL::asset('upload/image/avatar/default_avt.png') }}" alt="..." class="img-circle profile_img">
              @else
              <img src="{{ URL::asset('upload/image/avatar/'.$currentLogin->avatar) }}" alt="..." class="img-circle profile_img">
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
                  <a href="{{ asset('/') }}" class="active">
                    <i class="fa fa-home"></i> Trang chủ
                  </a>
                </li>
              @else
              <li>
                <a href="{{ asset('/') }}">
                   <i class="fa fa-home"></i> Trang chủ
                </a>
              </li>
              @endif
              <!--/END HOME-->
              <!--USER-->
              @if($paramater == "users")
              <li>
                <a href="{{ asset('users') }}" class="active">
                  <i class="fa fa-user"></i> Người dùng
                </a>
              </li>
              @else
              <li>
                <a href="{{ asset('users') }}">
                  <i class="fa fa-user"></i> Người dùng
                </a>
              </li>
              @endif
              <!--/END USER-->
              <!--LIÊN HỆ-->
              @if($paramater == "feedbacks")
              <li class="panel panel-default">
                 <a href="{{ asset('feedbacks') }}" class="active">
                  <i class="fa fa-phone"></i> Phản hồi
                </a>
              </li>
              @else
              <li class="panel panel-default">
                 <a href="{{ asset('feedbacks') }}">
                  <i class="fa fa-phone"></i> Phản hồi
                </a>
              </li>
              @endif
              <!--/END LIÊN HỆ-->
              <!--BÀI TEST-->
              @if($paramater == "test")
              <li>
                  <a href="{{ asset('test') }}"  class="active">
                   <i class="fa fa-edit"></i> Bài kiểm tra
                </a>
              </li>
              @else
              <li>
                  <a href="{{ asset('test') }}">
                   <i class="fa fa-edit"></i> Bài kiểm tra
                </a>
              </li>
              @endif
              <!--/END BÀI TEST-->
              <!--CÂU HỎI-->  
              @if($paramater == "quizs")
              <li>
                  <a href="{{ asset('quizs') }}" class="active">
                   <i class="fa fa-question"></i> Câu hỏi
                </a>
              </li>
              @else
              <li>
                  <a href="{{ asset('quizs') }}">
                   <i class="fa fa-question"></i> Câu hỏi
                </a>
              </li>
              @endif
              <!--/END CÂU HỎI-->
              <!--TỪ VỰNG-->
              @if($paramater == "bunpos")
              <li class="panel panel-default">
                <a href="{{ asset('bunpos') }}" class="active">
                  <i class="fa fa-newspaper-o"></i> Từ vựng </span>
                </a>
              </li>
              @else
              <li class="panel panel-default">
                <a href="{{ asset('bunpos') }}">
                  <i class="fa fa-newspaper-o"></i> Từ vựng </span>
                </a>
              </li>
              @endif
              <!--/END TỪ VỰNG-->
              <!--VIDEO-->
              @if($paramater == "videos")
              <li class="panel panel-default">
                <a href="{{ asset('videos') }}" class="active">
                  <i class="fa fa-video-camera"></i> Video </span>
                </a>
              </li>
              @else
              <li class="panel panel-default">
                <a href="{{ asset('videos') }}">
                  <i class="fa fa-video-camera"></i> Video </span>
                </a>
              </li>
              @endif
              <!--/END VIDEO-->
              <!--Bảng xếp hạng-->
              @if($paramater == "ranking")
              <li class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordionGeneral" href="#nav-home" class="collapsed active">
                  <i class="fa fa-sitemap"></i> Bảng xếp hạng <span class="down fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu" id="nav-home">
                  @if($view == "topOfMonth")
                  <li>
                    <a href="{{ asset('ranking/topOfMonth') }}" class="collapsed active">
                      <i class="fa fa-star"></i> Top Tháng
                    </a>
                  </li>
                  <li>
                    <a href="{{ asset('ranking/topOfQuarterOfTheYear') }}">
                      <i class="fa fa-sort"></i> Top Qúy
                    </a>
                  </li>
                  <li>
                    <a href="{{ asset('ranking/topOfYear') }}">
                      <i class="fa fa-sitemap"></i> Top Năm
                    </a>
                  </li>
                  @endif
                  @if($view == "topOfQuarterOfTheYear")
                  <li>
                    <a href="{{ asset('ranking/topOfMonth') }}" >
                      <i class="fa fa-star"></i> Top Tháng
                    </a>
                  </li>
                  <li>
                    <a href="{{ asset('ranking/topOfQuarterOfTheYear') }}" class="collapsed active">
                      <i class="fa fa-sort"></i> Top Qúy
                    </a>
                  </li>
                  <li>
                    <a href="{{ asset('ranking/topOfYear') }}">
                      <i class="fa fa-sitemap"></i> Top Năm
                    </a>
                  </li>
                  @endif
                  @if($view == "topOfYear")
                  <li>
                    <a href="{{ asset('ranking/topOfMonth') }}" >
                      <i class="fa fa-star"></i> Top Tháng
                    </a>
                  </li>
                  <li>
                    <a href="{{ asset('ranking/topOfQuarterOfTheYear') }}">
                      <i class="fa fa-sort"></i> Top Qúy
                    </a>
                  </li>
                  <li>
                    <a href="{{ asset('ranking/topOfYear') }}"  class="collapsed active">
                      <i class="fa fa-sitemap"></i> Top Năm
                    </a>
                  </li>
                  @endif

                </ul>
              </li>
              @else
              <li class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordionGeneral" href="#nav-home">
                  <i class="fa fa-sitemap"></i> Bảng xếp hạng <span class="down fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu collapse" id="nav-home">
                  <li>
                    <a href="{{ asset('ranking/topOfMonth') }}">
                      <i class="fa fa-star"></i> Top Tháng
                    </a>
                  </li>
                  <li>
                    <a href="{{ asset('ranking/topOfQuarterOfTheYear') }}">
                      <i class="fa fa-sort"></i> Top Qúy
                    </a>
                  </li>
                  <li>
                    <a href="{{ asset('ranking/topOfYear') }}">
                      <i class="fa fa-sitemap"></i> Top Năm
                    </a>
                  </li>
                </ul>
              </li>
              @endif
              <!--end BXH-->
              <!--lịch sử-->
              @if($paramater == "histories")
              <li class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordionGeneral" href="#nav-histories" class="collapsed active">
                  <i class="fa fa-history"></i> Lịch sử thanh toán <span class="down fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu" id="nav-histories">
                  @if($view == "purchase")
                  <li>
                    <a href="{{ asset('histories/purchase') }}" class="collapsed active">
                      <i class="fa fa-shopping-cart"></i> Lịch sử mua
                    </a>
                  </li>
                  <li>
                    <a href="{{ asset('histories/recharge') }}">
                      <i class="fa fa-id-card-o"></i> Lịch sử nạp tiền
                    </a>
                  </li>
                  @endif
                  @if($view == "recharge")
                  <li>
                    <a href="{{ asset('histories/purchase') }}">
                      <i class="fa fa-shopping-cart"></i> Lịch sử mua
                    </a>
                  </li>
                  <li>
                    <a href="{{ asset('histories/recharge') }}"  class="collapsed active">
                      <i class="fa fa-id-card-o"></i> Lịch sử nạp tiền
                    </a>
                  </li>
                  @endif
                </ul>
              </li>
              @else
              <li class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordionGeneral" href="#nav-histories">
                  <i class="fa fa-history"></i> Lịch sử thanh toán<span class="down fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu collapse" id="nav-histories">
                  <li>
                    <a href="{{ asset('histories/purchase') }}">
                      <i class="fa fa-shopping-cart"></i> Lịch sử mua
                    </a>
                  </li>
                  <li>
                    <a href="{{ asset('histories/recharge') }}">
                      <i class="fa fa-id-card-o"></i> Lịch sử nạp tiền
                    </a>
                  </li>
                </ul>
              </li>
              @endif
              <!--end--> 
            </ul>
          </div>
        </div>
        <!--/END SIDEBAR MENU-->
        <!--MENU FOOTER-->
        <div class="sidebar-footer hidden-small">
          <a href="{{ asset('settings/list') }}" class="sidebar "data-placement="top" title="Cài đặt">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            Cài đặt
          </a>
          <a href="{{ asset('/logout')}}" class="sidebar "data-placement="top" title="Đăng xuất">
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