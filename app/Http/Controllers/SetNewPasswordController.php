<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Http\Requests\SetNewPasswordRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\App;
use IlluminateDatabaseEloquentModelNotFoundException;

class SetNewPasswordController extends Controller
{
    public function setNewPassword(SetNewPasswordRequest $request) {
      try {
        $email = $request->email;
        $newPassword = $request->confirmPassword;
        $admin = Admin::where('email', $email)->firstOrFail();
        $admin->password = bcrypt($newPassword);
        $admin->save();
        return redirect()->route('login')->with(['message' => 'Your password has been changed!']);
      } catch (ModelNotFoundException $ex) {
        return redirect()->back()->with(['message' => 'Invalid Email Address!']);
      }
    }
}
