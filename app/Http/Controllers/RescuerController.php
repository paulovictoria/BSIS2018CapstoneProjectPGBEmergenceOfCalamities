<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Geolocation;
use App\RescuerMessages;
use App\Http\Requests\RescuerRequest;
use Carbon\Carbon;
use App\Events\RescuerMessageEvent;

class RescuerController extends Controller
{
   public function addMember(RescuerRequest $request)
   {
      $count = Geolocation::where('rescuerName', '=', $request->rescuerName)->count();
      if ($count == 1) {
        return response(['errors'=> ['user' => 'The user was already exist!']], 422);
      }
      $geolocation = Geolocation::create([
          'rescuerName' => $request->rescuerName,
          'password' => $request->password,
          'password_confirmation' => $request->password_confirmation,
          'assignRoute' => $request->assignRoute,
          'municipality' => $request->municipality,
          'lat' => '',
          'lng' => ''
        ]);
        return response($geolocation, 200);
   }
   
   public function getMembers($municipality) {
      return Geolocation::where('municipality', '=', $municipality)->paginate(6);
   }

   public function editUser(Request $request, $id) {
     $user = Geolocation::find($id);
     $user->assignRoute = $request->assignRoute;
     $user->municipality = $request->municipality;
     $user->save();
   }

   public function deleteUser($id)
   {
      $user = Geolocation::find($id);
      $user->delete();
   }

   public function sendMessage(Request $request)
   {
     $rescuer = Geolocation::find($request->geolocation_id);
     $message = $rescuer->rescuerMessages()->create([
        'message' => $request->input('message'),
        'messageDate' => Carbon::now('Asia/Shanghai')->toDateTimeString() 
     ]);
      return response($rescuer);
      broadcast(new RescuerMessageEvent($rescuer, $message));
   }

   public function getMessage()
   {
     return RescuerMessages::with('rescuerName')->get();
   }
}
