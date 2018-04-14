<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Admin;
use DB;
class ConfirmEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $admin, $verification_code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Admin $admin, $verification_code)
    {
        $this->admin = $admin;
        $this->verification_code = $verification_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        DB::table('user_verifications')->insert(['admin_id'=>$this->admin->id,'token'=>$this->verification_code]);
        $subject = "Please verify your email address.";
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject($subject)
                    ->with([
                        'admin_id' => $this->admin->id,
                        'token' => $this->verification_code,
                        'name' => $this->admin->name
                    ])
                    ->view('email.confirm');
    }
}
