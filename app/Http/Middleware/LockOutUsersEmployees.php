<?php

namespace App\Http\Middleware;

use App\Helpers;

use Closure;

class LockOutUsersEmployees
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

        if((! Helpers::current_user_admin()) && (! Helpers::current_user_manager()) )
        {
            if($request->path() != '/')
            {
                return redirect()->home();
            }
        }

        return $next($request);
    }
}
