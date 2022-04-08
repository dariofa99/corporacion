<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\CaseLog;


class LogDefendantNotification extends Notification
{
    //use Queueable;
    public $message;
    public $filename;
    public $notification;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CaseLog $notification)
    {
        //dd($notification) ;
       // $this->filename = $filename;
        $this->notification = $notification;
        //$this->session = $session;
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
    {   //  dd($this->notification->notification_type);
        return (new MailMessage)
        ->subject('Novedad en el sistema Lybra - '.env("MAIL_FROM_NAME"))
        //->attach(storage_path($this->filename))
        ->from(env("MAIL_FROM_ADDRESS"),env("MAIL_FROM_NAME"))
        ->view(
            'mail.log_defendant_notification',
            [   
                'token' => str_replace ('/', '', bcrypt(time())) , 
                'caseL' => $this->notification,    
            ]);
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
