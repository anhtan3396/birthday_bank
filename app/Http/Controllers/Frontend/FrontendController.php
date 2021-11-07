<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Utils\SessionManager;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
  public function index( )
  {
    return view('Frontend.index');
  }

  public function loginIndex()
  {
    $sessionLogin = SessionManager::getLoginInfo();
    if($sessionLogin)
    {
      return redirect()->back();
    }
    return view('Frontend.auth.loginPage');
  }

  public function resetPassIndex()
  {
    return view('Frontend.auth.resetPass');
  }


  public function resetPass()
  {
    //
  }


  public function logout()
  {   
    Session::flush();
    return redirect()->route('home');
  }
}
