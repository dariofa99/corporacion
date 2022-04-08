<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;

class UserRegisterNotificationMail extends Notification 
{
   // use Queueable;
    public $notification;    
    public $password_send;    

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $notification,$password_send)
    {
        $this->notification = $notification;
        $this->password_send = $password_send;
      
       
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
        ->subject('Registro de cuenta en el sistema Lybra - '.env("MAIL_FROM_NAME"))      
        ->from(env("MAIL_FROM_ADDRESS"),env("MAIL_FROM_NAME"))
        ->view(
            'mail.user_register_notification',
             ['user' => $this->notification,
             'password_send' => $this->password_send]);
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
