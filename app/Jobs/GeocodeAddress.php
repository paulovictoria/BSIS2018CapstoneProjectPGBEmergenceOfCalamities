<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\CitizenReports;
use GoogleMaps;
use App\Events\SendReportEvent;
class GeocodeAddress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $reports;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CitizenReports $reports)
    {
        $this->reports = $reports;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sentReport = CitizenReports::find($this->reports->id);
        $response = \GoogleMaps::load('geocoding')
            ->setParam(['address' => $this->reports->address])
            ->get('results.geometry.location');
        $lat = $response['results'][0]['geometry']['location']['lat'];
        $lng = $response['results'][0]['geometry']['location']['lng'];
        $sentReport->lat = $lat;
        $sentReport->lng = $lng;
        $sentReport->save();
    }
}
