<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\MUser;
use App\Utils\SessionManager;
use App\Repositories\UserRepository;

class CheckUserActivePass
{
  public function handle($request, Closure $next)
  {
    $info = SessionManager::getLoginInfo();
    $loginUserInfo = MUser::findOrFail($info->id);
    if ($loginUserInfo->reset_pass || $loginUserInfo->email === 'admin@gmail.com')
    {
      return $next($request);
    }else{
      return redirect()->route('guest_reset_pass');
    }
  }
}