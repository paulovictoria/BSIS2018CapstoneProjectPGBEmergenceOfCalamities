<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Events\BlockAUserEvent;

class AccessControlController extends Controller
{
    public function getAllUsers()
    {
      return Admin::all();
    }

    public function blockUser(Request $request, $id)
    {
      $admin = Admin::find($id);
      $admin->isBlock = $request->isBlock;
      $admin->save();
      broadcast(new BlockAUserEvent($admin));
      return response(['message' => 'Operation success!'], 200);
    }

    public function sortUsers($key)
    {
      if ($key == 1) {
        return Admin::block()->except('Administrator')->except('Bulacan')->get();
      }
       return Admin::activated()->except('Administrator')->except('Bulacan')->get();
    }
}
