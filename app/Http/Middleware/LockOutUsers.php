<?php

namespace App\Http\Middleware;

use App\Helpers;

use Closure;

class LockOutUsers
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

        if(Helpers::is_normal_user())
        {
            if($request->path() != '/')
            {
                return redirect()->home();
            }
        }

        return $next($request);
    }
}
