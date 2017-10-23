<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class UserResolver
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
        $request->setUserResolver(function(){
                            $user = Auth::User();
                            if ($user) {
                                return $user;
                            }
                            else
                            {
                                $user = Auth::guard('web_admin')->user();
                                return $user;
                            }
        });
        return $next($request);
    }
}
