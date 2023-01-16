<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Diary;
use App\Models\SessionAdmin;

class DiaryNotification extends Notification
{
    
    public $message;
    public $data = [];
    public $notification;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Diary $notification)
    {
       // dd($notification) ;
        
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
        return ['mail','database'];
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
        ->subject('Nuevo evento en el sistema Lybra')
        //->cc('luiscarcm@gmail.com')
       // ->from(env("MAIL_FROM_ADDRESS"),env("MAIL_FROM_NAME"))
        ->view(
            'mail.diary_notification',
             [              
                'diary' => $this->notification,
                
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
            'type_notification'=>'Notificación de usuario',          
            'message'=>($this->notification->users[0]->name)." te ha registrado en un evento",
            'url'=>$this->notification->url,
            'created_at'=>date("Y-m-d H:i:s"),
            'icon'=>'far fa-calendar-alt'
        ];
    }
}
