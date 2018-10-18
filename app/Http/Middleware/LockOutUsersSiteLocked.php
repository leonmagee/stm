<?php

namespace App\Http\Middleware;

use App\Helpers;

use Closure;

class LockOutUsersSiteLocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Helpers::is_normal_user() && Helpers::is_site_locked())
        {
            if(($request->path() != '/')  && ($request->path() != 'logout'))
            {
                return redirect()->home();
            }
        }

        return $next($request);
    }
}
