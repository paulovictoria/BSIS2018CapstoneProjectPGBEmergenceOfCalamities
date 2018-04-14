<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\ConfirmEmail;
use Mail;
use App\Admin;

class ConfirmEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $admin, $verification_code;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Admin $admin, $verification_code)
    {
        $this->admin = $admin;
        $this->verification_code = $verification_code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->admin->email)->send(new ConfirmEmail($this->admin, $this->verification_code));
    }
}
