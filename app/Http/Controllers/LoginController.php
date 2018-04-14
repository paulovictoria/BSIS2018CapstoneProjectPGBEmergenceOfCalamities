<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function gotoLogin()
    {
        return view('admin.login');
    }

    public function loggedIn(LoginRequest $request) {
      return view('admin.login');
    }
}
