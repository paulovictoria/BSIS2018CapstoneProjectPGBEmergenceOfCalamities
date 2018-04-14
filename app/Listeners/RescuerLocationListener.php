<?php

namespace App\Listeners;
use App\Geolocation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\RescuerLocationEvent;

class RescuerLocationListener implements ShouldQueue
{
    public $location;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Geolocation $location)
    {
        $this->location = $location;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(RescuerLocationEvent $event)
    {
        
    }
}
