<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Verified
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
        // dd($request);
        if (Auth::user()->verified == '1') {
            return $next($request);
        }
        else
            return redirect('/verifyaccountscreen');
    }
}
