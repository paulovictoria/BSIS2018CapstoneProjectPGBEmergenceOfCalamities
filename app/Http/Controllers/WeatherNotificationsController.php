<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Forecast\Forecast;
class WeatherNotificationsController extends Controller
{
  public function getWeatherUpdate($lat, $lng)
	{
		$list = array( 'minutely', 'alerts', 'flags' ,'daily',);
		$forecast = new Forecast('your api key');
		$result = json_encode($forecast->get(
			$lat,
			$lng,
			null,
		    array(
        'units' => 'ca',
        'exclude' =>  implode( ",", $list )
        )));    
		return response($result);
	}
}
