<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class DashboardMiddleware
{
    public function handle($request, Closure $next) {
        if (!Auth::check()) {
            return redirect()->route('login');
        //  return $next($request);
        }
        // return $next($request);
        return redirect()->route('dashboard');
        // return redirect()->route('login');
    }
}
