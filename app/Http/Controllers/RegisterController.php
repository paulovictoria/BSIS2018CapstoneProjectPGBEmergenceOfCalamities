<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Admin;
use DB, Mail, Password;
use Illuminate\Mail\Message;
use Carbon\Carbon;
use App\Jobs\ConfirmEmailJob;
use App\Notifications\ResetPassword;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function gotoRegister() {
        return view('admin.register');
    }

    public function createUser(RegisterRequest $request) {

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $municipality = $request->municipality;
        $usercontact = $request->usercontact;
        $municipalAddress = $request->municipalAddress;
        $now = Carbon::now('Asia/Shanghai')->toDateTimeString();
        $admin = Admin::create(
            [ 'name' => $name,
              'email' => $email,
              'password' => bcrypt($password),
              'municipality' => $municipality,
              'usercontact' => $usercontact, 
              'municipalAddress' => $municipalAddress,
              'userDate' => $now]);
				
				$verification_code = str_random(30);
				$job = (new ConfirmEmailJob($admin, $verification_code))->delay(Carbon::now()->addSeconds(5));
				dispatch($job);
        return redirect('login')->with(['message'=> 'Please check your email to complete your registration.']);

    }

    public function verifyUser($code) {
            $check = DB::table('user_verifications')->where('token',$code)->first();
            if(!is_null($check)){
                $admin = Admin::find($check->admin_id);
                if($admin->is_verified == 1){;
                    return redirect('login')->with(['message'=> 'Account already verified..']);
                }
                $admin->update(['is_verified' => 1]);
                DB::table('user_verifications')->where('token',$code)->delete();
                    return redirect('login')->with(['message'=> 'Please login again.']);
            }
            return redirect('login')->with(['message'=> 'Verification code is invalid!']);
    }

    public function recover(Request $request)
    {
        $user = Admin::where('email', $request->email)->first();
        if (!$user) {
            $error_message = "Your email address was not found.";
            return redirect()->back()->with(['errors' => $error_message]);
				}
				$token = hash_hmac('sha256', Str::random(40), $user->name);
        $user->notify(new ResetPassword($user, $token));
        return redirect()->route('login')->with(['message' => 'A reset email has been sent! Please check your email.']);
		}
}
