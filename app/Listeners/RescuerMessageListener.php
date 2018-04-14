<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\RescuerMessageEvent;
use App\Geolocation;
class RescuerMessageListener implements ShouldQueue
{
    public $rescuer;
    /**
     * Create the event listener.
     *
     * @return void
     */
  public function __construct(Geolocation $rescuer)
    {
        $this->rescuer = $rescuer;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(RescuerMessageEvent $event)
    {
        //
    }
}
