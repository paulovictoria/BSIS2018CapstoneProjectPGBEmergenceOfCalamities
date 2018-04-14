<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\DamUpdates;
use Illuminate\Support\Facades\Auth;

class DamUpdateController extends Controller
{

    public function __construct() {
    // $this->user = Auth::user()->name;
        
    //     print_r($user);
        // if (Auth::check()) {
           
        //     // if ($name == 'Rannie Ollit') {
                
                
        //     // }
        // }
    }

    public function updateDams(Request $request) {
        $user = Auth::user();
        $amount = $user->updates()->create([
          'amount' => $request->input('amount')
        ]);
        
        return response($user, 200);
    }

    public function getAngatDamUpdates() {
            return \App\Admin::with('updates')->where('municipality', '=', 'Angat Dam')->get();
    }

    public function getIpoDamUpdates() {
        return \App\Admin::with('updates')->where('municipality', '=', 'Ipo Dam')->get();
    }

    public function getBustosDamUpdates() {
        return \App\Admin::with('updates')->where('municipality', '=', 'Bustos Dam')->get();

    }

    public function gotoDashboard()
    {
        return view('admin.dashboard');
    }
}
