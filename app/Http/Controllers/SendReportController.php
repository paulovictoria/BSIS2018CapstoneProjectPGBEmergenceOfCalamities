<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CitizenReports;
use App\Events\SendReportEvent;
use App\Http\Requests\SendReportRequest;
use Illuminate\Contracts\Support\Jsonable;
use DB, Storage, QueryBuilder, Image;
use Carbon\Carbon;
use App\Jobs\GeocodeAddress;
use App\Jobs\UploadImageJob;
use App\Jobs\SendSMSJob;

class SendReportController extends Controller
{
    public function gotoSendReport()
    {
        return view('users.report');
    }
    
    public function sendReport(SendReportRequest $request) {
      $upload = $request->file('image');
      if (!$upload) {
          $reports = CitizenReports::forceCreate([
            'fullName' => $request->fullName,
            'address' => $request->address,
            'contactNumber' => $request->contactNumber,
            'landmark' => $request->landmark,
            'type' => $request->type,
            'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
            'municipality' => $request->municipality,
            'lat' => 0,
            'lng' => 0,
            'ip' => request()->ip(),
            'status' => $request->status,
            'rescuedTime' => '',
            'respondTime' => '',
            'landline' => $request->landline
        ]);
        event(new SendReportEvent($reports));
        dispatch(new GeocodeAddress($reports));
      } else {
          $fileName = $request->fullName.Carbon::now('Asia/Shanghai')->format('y-m-d').$upload->getClientOriginalName().'.'.$upload->extension();
          $reports = CitizenReports::forceCreate([
            'fullName' => $request->fullName,
            'address' => $request->address,
            'contactNumber' => $request->contactNumber,
            'landmark' => $request->landmark,
            'type' => $request->type,
            'reportedDate' => Carbon::now('Asia/Shanghai')->toDateTimeString(),
            'municipality' => $request->municipality,
            'lat' => 0,
            'lng' => 0,
            'ip' => request()->ip(),
            'status' => $request->status,
            'rescuedTime' => '',
            'respondTime' => '',
            'image' => $fileName,
            'landline' => $request->landline
        ]);
        $upload->move(storage_path().'/app/public/reports', $fileName);
        event(new SendReportEvent($reports));
        dispatch(new GeocodeAddress($reports));
    }
  }

    public function getReports()
    {
        return CitizenReports::desc()->paginate(6);
    
    }

    public function getAllReports() {
        return CitizenReports::all();
    }

    public function queryReports($address, $date, $type)
    {
        $reports = CitizenReports::address($address)
                                ->date($date)
                                ->type($type)
                                ->get();

        $count = CitizenReports::address($address)
                                ->date($date)
                                ->type($type)
                                ->count();

        return response([
            'incidents' => $reports,
            'totalIncidentCount' => $count
        ]);
        
    }

    public function queryReportLandmarks($address, $date, $type, $landmark)
    {
        return \App\CitizenReports::address($address)
                                    ->date($date)
                                    ->type($type)
                                    ->landmark($landmark)->get();
    }

    public function queryPlaces($address, $status)
    {
        return CitizenReports::address($address)->undone($status)->desc()->get();
    }

    public function queryNotDone($status, $municipality) {
      if ($municipality == 'Administrator' || $municipality == 'Bulacan') {
        return CitizenReports::undone($status)->desc()->paginate(6);
      }
        return CitizenReports::undone($status)->municipality($municipality)->desc()->paginate(6);
    }

    public function updateReportStatus($status, $id) {
			
        if ($status == 'OnGoing') {
			    $report = CitizenReports::find($id);
       		$report->status = $status;
        	$report->respondTime = Carbon::now('Asia/Shanghai')->toDateTimeString();        
        	$report->save();
          $contactNumber = preg_replace("/^0/", "+63", $report->contactNumber);
          $message = 'From PDRRMO Bulacan - Our team is now preparing to move at your area. Stay calm and alert.';
          event(new SendReportEvent($report));
          dispatch(new SendSMSJob($contactNumber, $message));
				}
			    $report = CitizenReports::find($id);
       		$report->status = $status;
        	$report->rescuedTime = Carbon::now('Asia/Shanghai')->toDateTimeString();        
        	$report->save();
          return response($report);
          event(new SendReportEvent($report));
    }

    public function getReportsByLocation($municipality)
    {
        if ($municipality == 'Administrator' || $municipality == 'Bulacan') {
          return CitizenReports::all();
        }
        return CitizenReports::municipality($municipality)->get();
    }

   public function getUndoneReports($municipality, $status)
   {
     if ($municipality == 'Bulacan' || $municipality == 'Administrator') {
       return CitizenReports::undone($status)->get();
     }
     return CitizenReports::address($municipality)->undone($status)->get();
   } 
  
   public function getReportsByBarangay($address, $status)
   {
        return CitizenReports::address($address)->undone($status)->get();
   }

   public function getTodaysReport($status, $date)
   {
     return CitizenReports::undone($status)->date($date)->get();
   }

   public function getTodaysTotalReports($date)
   {
     return CitizenReports::todaysTotalReports($date);
   }

   public function getReportRangeDates($date, $address, $type)
   {
      $dates = [];
      $totalPerDay = [];
      $totalCountPerDayPerAddress = [];
      $reported = [];
      $datesCovered = [];
      $reports = CitizenReports::dateRange($date)->address($address)->type($type)->get();
      $count = CitizenReports::dateRange($date)
                                ->address($address)
                                ->type($type)
                                ->count();  
      foreach ($reports as $key => $value) {
        array_push($dates, $value['reportedDate']);
      }
      $unique = array_unique($dates);
      
      foreach ($unique as $key => $timeStamps) {
        $formattedDate = Carbon::parse($timeStamps)->format('Y-m-d');
        array_push($datesCovered, $formattedDate);
        array_push($totalPerDay, 
                  CitizenReports::date($formattedDate)->address($address)->type($type)->get());
        array_push($totalCountPerDayPerAddress, 
                  CitizenReports::date($formattedDate)->address($address)->type($type)->count());
      }
      
      return response([
            'incidents' => $reports,
            'totalIncidentCount' => $count,
            'dailyReports' =>  $totalPerDay,
            'datesCovered' => $datesCovered
      ]); 
   }

   public function getReportsByDate($date, $type, $address)
   {
     
      $addresses = [];
      $totalCount = [];
      $results = CitizenReports::date($date)->type($type)->address($address)->get();
      foreach ($results as $result) {
        array_push($addresses, $result->address);
      }
      $uniqueAddresses = array_unique($addresses);
      
      foreach ($uniqueAddresses as $uniqueAddress) {
        array_push($totalCount, 
            CitizenReports::date($date)->type($type)->address($uniqueAddress)->count());
      }
            return response([
              'addresses' => json_encode($uniqueAddresses),
              'count' => $totalCount
            ]);
   }

   public function getTotalReports($date, $type, $address)
   {
     $undone = CitizenReports::dateRange($date)->type($type)->address($address)->undone('Undone')->count();
      $ongoing = CitizenReports::dateRange($date)->type($type)->address($address)->undone('OnGoing')->count();
      $finished = CitizenReports::dateRange($date)->type($type)->address($address)->undone('Finished')->count();
      $fraud  = CitizenReports::dateRange($date)->type($type)->address($address)->undone('Fraud')->count();
      $allReports =CitizenReports::dateRange($date)->type($type)->address($address)->count();
      return response([
       'status' => ['Undone', 'Ongoing', 'Finished', 'Fraud'],
       'totals' => [$undone, $ongoing, $finished, $fraud],
       'allReports' => $allReports 
      ]);
   }
}