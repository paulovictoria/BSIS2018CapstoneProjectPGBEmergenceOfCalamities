<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginMiddleware
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
        if (Auth::attempt([
            'email' => $request['email'], 
            'password' => $request['password'], 
            'is_verified' => '1',
            'isBlock' => null
          ])) 
          {
            return redirect()->route('reports');
          } 
        else if (Auth::attempt([
            'email' => $request['email'], 
            'password' => $request['password'], 
            'is_verified' => '0',
            'isBlock' => null
          ])) 
          {
            return redirect()->back()->with(['errors' => 'Please verify your account first!']);
          }
        else if (Auth::attempt([
            'email' => $request['email'], 
            'password' => $request['password'], 
            'is_verified' => '1',
            'isBlock' => 1
          ])) 
          {
            return redirect()->back()->with(['errors' => 'Your account has been deactivated, Please contact your administrator!']);
          }
        return redirect()->back()->with(['errors' => 'Invalid Username or Password!']);     
    }
}
