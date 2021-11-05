<?php

namespace App\Http\Middleware;

use Closure;
use App\Utils\SessionManager;
use App\Repositories\UserRepository;

class AdminAuthencation
{
    public function handle($request, Closure $next)
    {
        if (SessionManager::isAdmin())
        {
            return $next($request);
        }
        else
        {
            return redirect('login');
        }
    }
}