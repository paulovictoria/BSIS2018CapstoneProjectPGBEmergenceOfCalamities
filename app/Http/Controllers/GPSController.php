<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\RescuerLocationEvent;
use App\Events\NotifyInSiteEvent;
use Illuminate\Http\Request;
use App\Geolocation;
use App\Http\Requests\NotifyRequest;
use App\RescuerNotifications;
use Carbon\Carbon;
use GoogleMaps, Storage, Log;

class GPSController extends Controller
{
    public function gotoRescue()
    {
        return view('admin.rescue');
    }

    public function verifyRescuer($password) {
      return Geolocation::where('password', '=', $password)->firstOrFail();
    }

    public function updateLocation($lat, $lng, $id)
    {
        $location = Geolocation::find($id);
        $location->lat = $lat;
        $location->lng = $lng;
        $location->save();
        return response($location);
        broadcast(new RescuerLocationEvent($location));
    }

    public function resetLocation($id) {
      $location = Geolocation::find($id);
      $location->lat = '';
      $location->lng = '';
      $location->save();
      broadcast(new RescuerLocationEvent($location));
    }
    public function locateRescuer($lat, $lng)
    {
        $endpoint = \GoogleMaps::load('geocoding')
                    ->setParamByKey('latlng', "$lat,$lng") 
                    ->get('results.formatted_address');
        $exactGeolocation = $endpoint['results'][1];
        return response($exactGeolocation);
    }

    public function notifyInSite(NotifyRequest $request, $id)
    {
        $citizenName = $request->citizen_name;
        $upload = $request->file('image');
        $notify = Geolocation::find($id);
        $result = $notify->notifications()->create([
          'location' => $request->location,
          'time' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
          'landmark' => $request->landmark,
          'citizen_name' => $citizenName,
          'type' => $request->type,
          'status' => $request->status,
          'image' => md5(Carbon::now('Asia/Shanghai')->format('H:i:s')).$citizenName.'.'.$upload->extension()
        ]);
        $upload->move(storage_path().'/app/public/rescuers', md5(Carbon::now('Asia/Shanghai')->format('H:i:s')).$citizenName.'.'.$upload->extension());
        broadcast(new NotifyInSiteEvent($result));
        return response($result, 200); 
    }

    public function getAllNotifications()
    {
      return  RescuerNotifications::with('rescuer')->get();
    }    

    public function getSpecificNotification($id)
    {
      $notified = RescuerNotifications::with('rescuer')->find($id);
      $url = asset('storage/rescuers/'.$notified['image']);
      return response([ 
        'result' => $notified,
        'image' => $url
      ]);
    }
}
