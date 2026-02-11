<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if (session()->has('locale')) {
            \App::setLocale(session()->get('locale'));
        } 
        else {
            \App::setLocale('en');
        }
            return $next($request);
    }
}
