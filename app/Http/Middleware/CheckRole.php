<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$role)
    {
        // dd($role);
        if(in_array($request->user()->role,$role)){
            return $next($request);
        }elseif($request->user()->role == "admin"){
            return $next($request);
        }elseif($request->user()->role == "guest"){
            auth()->logout();
            return redirect('/');
        }
        return redirect('/');

    }
}
