<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class NotBanned
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
        if ( Auth::check() )
        {
            if(Auth::user()->isBanned()){
                Auth::logout();
                return redirect('/')->withErrors(['Таны нэвтрэх эрхийг хязгаарласан байна.']);
            }
            return $next($request);
        }

        return $next($request);
    }
}
