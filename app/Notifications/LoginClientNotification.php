<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;
use App\Models\SessionAdmin;

class LoginClientNotification extends Notification 
{
   // use Queueable;
    public $notification;
    public $data = [];
    public $date;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $notification,$date)
    {
        $this->notification = $notification;
        $this->date = $date;
       
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
        ->subject('Solicitante conectado en el sistema Lybra')
        //->cc('luiscarcm@gmail.com')
       // ->from(env("MAIL_FROM_ADDRESS"),env("MAIL_FROM_NAME"))
        ->view(
            'mail.login_client_notification',
             ['user' => $this->notification,
            'date' => $this->date]);
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
