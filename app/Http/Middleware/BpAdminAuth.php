<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class BpAdminAuth
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
        if(Auth::user())
        {
        if(Auth::user()->super)
        {
            return $next($request);
        }        
        else
        {
            return redirect('/unauthorize');
        }
        }
        else
        {
            return redirect('/login');
        }
    }
}
