<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Classes\SmsGateway;
use Twilio;

class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $contactNumber, $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($contactNumber, $message)
    {
        $this->contactNumber = $contactNumber;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $smsGateway = new SmsGateway('your_email', 'your_password');
        $deviceID = 'your_device_id';
        $result = $smsGateway->sendMessageToNumber($this->contactNumber, $this->message, $deviceID);
    }
}
