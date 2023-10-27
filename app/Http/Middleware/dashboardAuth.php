<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class DashboardAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && !$request->user()->can('access dashboard')){
            Session::flash('error','You Dont Have Permissions To Access This Content');
            return redirect()->route('shop.show');
        }elseif(!Auth::check()){
            Session::flash('error','You Need To Log In First');
            return redirect()->route('login.create');
        }
        return $next($request);
    }
}
