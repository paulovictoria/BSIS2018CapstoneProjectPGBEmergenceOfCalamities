<?php

namespace App\Listeners;
use App\Geolocation;
use App\Events\NotifyInSiteEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class NotifyInSiteListener implements ShouldQueue
{
   
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NotifyInSiteEvent $event)
    {
        //
    }
}
