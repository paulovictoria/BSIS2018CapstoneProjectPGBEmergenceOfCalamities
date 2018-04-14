<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GoogleMaps;

class GoogleMapsController extends Controller
{
    public function getDirections($origin, $destination)
    {
			 $response = \GoogleMaps::load('directions')
                                ->setParam([
																	'origin' => $origin,
																	'destination'=> $destination,
																					])
																->get();
				return response($response);
		}
		
		public function geoCode($address) 
		{
			$response = \GoogleMaps::load('geocoding')
								->setParam(['address' => $address])
								->get('results.geometry.location');
			$lat = $response['results'][0]['geometry']['location']['lat'];
			$lng = $response['results'][0]['geometry']['location']['lng'];
			return response($lng);
		}
}
