<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\SendReportEvent;
use App\CitizenReports;
use GoogleMaps;
class GeocodeAddressListener implements ShouldQueue
{
    public $reports;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CitizenReports $reports)
    {
        $this->reports = $reports;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SendReportEvent $event)
    {


    }
}
