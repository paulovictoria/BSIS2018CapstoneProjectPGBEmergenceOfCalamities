<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
         'App\Events\SendReportEvent' => [
             'App\Listeners\SentReportNotification',
         ],
        'App\Events\ChatEvent' => [
            'App\Listeners\MessagesListener',
        ],
        'App\Events\RescuerLocationEvent' => [
            'App\Listeners\RescuerLocationListener',
        ],
        'App\Events\NotifyInSiteEvent' => [
            'App\Listeners\NotifyInSiteListener',
        ],
        'App\Events\BlockAUserEvent' => [
            'App\Listeners\BlockAUserListener',
        ],
        'App\Events\RescuerMessageEvent' => [
            'App\Listeners\RescuerMessageListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
