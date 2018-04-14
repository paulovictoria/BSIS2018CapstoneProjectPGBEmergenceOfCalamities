<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Carbon\Carbon;
use App\TideUpdates;
use App\Http\Requests\TideUpdateRequest;
use App\Events\TideUpdateEvent;

class TidesController extends Controller
{
    public function getTideUpdates()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.tideschart.com/Philippines/Central-Luzon/Province-of-Bulacan/Hagonoy/');
        $crawler->filter('h2 > a')->each(function ($node) {
            print $node->text()."\n";
        });
    }

    public function saveTideUpdates(TideUpdateRequest $request)
    {   
        $tideUpdates = TideUpdates::create([
            'date_gathered' => $request->date_gathered,
            'tideTime' => $request->tideTime,
            'tideHeight_mt' => $request->tideHeight_mt,
            'tideDateTime' => $request->tideDateTime,
            'tideType' => $request->tideType
        ]);
        event(new TideUpdateEvent($tideUpdates));
    }

    public function getTimeSeries()
    {
        $tideTimeSeries = TideUpdates::all();
        return response($tideTimeSeries, 200);
    }

    public function newTideUpdates()
    {
       return  TideUpdates::orderBy('id', 'desc')->take(2)->get();
    }
}
