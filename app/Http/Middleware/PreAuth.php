<?php

namespace App\Http\Middleware;

use Closure;

class PreAuth
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
        // dd($request->input());
        if(config('app.secret') != base64_decode($request->input('secret')))
        {
            return response()->json(['error' => 'you need our secret']);
        }
        return $next($request);
    }
}
