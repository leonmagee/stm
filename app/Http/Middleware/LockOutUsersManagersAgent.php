<?php

namespace App\Http\Middleware;

use App\Helpers;

use Closure;

/**
 * Lock out all users, employees, but only lock out managers if it's the agent site
 */
class LockOutUsersManagersAgent
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
        $current_site = Helpers::current_role_id();

        if(! Helpers::current_user_admin() && ((! Helpers::current_user_manager()) || ($current_site === 3)))
        {
            if($request->path() != '/')
            {
                return redirect()->home();
            }
        }

        return $next($request);
    }
}
