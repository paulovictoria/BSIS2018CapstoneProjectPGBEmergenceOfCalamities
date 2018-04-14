<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CitizenReports;
use DB;
use Carbon\Carbon;
class GetIPAddressController extends Controller
{
    public function getIP()
    {   
        $average = CitizenReports::where('ip', '=', request()->ip())
                                ->whereDate('reportedDate','=', Carbon::today()->toDateTimeString())
                                ->count();
        // if ($average >= 5) {
		// 			return response([
        //                 'message' => 'Our system detects its multiple usage, please come after 5 minutes!',
        //                 'count' => $average]);	
        //     } 
            return response(['count' => $average]);                     
    }
}
