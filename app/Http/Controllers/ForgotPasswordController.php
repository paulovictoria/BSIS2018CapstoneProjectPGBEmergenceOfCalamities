<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
  
    public function gotoForgot() {
      return view('admin.forgot');
    }

    public function sendRequest() {
      return view('admin.login');
    }
}
