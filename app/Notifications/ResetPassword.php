<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Password;
use App\Admin;

class ResetPassword extends ResetPasswordNotification implements ShouldQueue
{
    use Queueable;
    public $admin, $token; 
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Admin $admin, $token)
    {
        $this->admin = $admin;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
       return (new MailMessage)
                    ->greeting('Hello!')
                    ->line('You are receiving this email because we received a password reset request for your account.')
                    ->action('Reset Password', url('/password/reset', $this->token))
                    ->line('If you did not request a password reset, no further action is required.');
      
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
