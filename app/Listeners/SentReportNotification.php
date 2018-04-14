<?php

namespace App\Listeners;

use App\Events\SendReportEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentReportNotification implements ShouldQueue
{
    public $reports;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SendReportEvent $reports)
    {
        $this->reports = $reports;
    }

    /**
     * Handle the event.
     *
     * @param  SendReportEvent  $event
     * @return void
     */
    public function handle(SendReportEvent $event)
    {
        //
    }
}
