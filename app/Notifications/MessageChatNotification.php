<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;

class MessageChatNotification extends Notification 
{
   // use Queueable;
    public $notification;     
    public $password_send;    

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $notification)
    {
        $this->notification = $notification;
        //$this->password_send = $password_send;
      
       
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
        ->subject('Registro de cuenta en el sistema Lybra -  Corporación ocho de marzo')      
        //->from('recepciondecasos@corporacionochodemarzo.org','Corporación ocho de marzo')
        //->from('recepciondecasos@corporacionochodemarzo.org','Corporación ocho de marzo')
        ->view(
            'mail.user_register_notification',
             ['user' => $this->notification,
             'password_send' => "sadas"]);
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
            'type_notification'=>'Notificación de chat',          
            'message'=>($this->notification->name)." ha enviado un mensaje de chat",
            'url'=>"/admin/users/".$this->notification->id."/edit",
            'created_at'=>date("Y-m-d H:i:s"),
            'icon'=>'fas fa-user',
            'notification_id'=>'notification_chat',
            'user_send_id'=>$this->notification->id
        ];
    }
}
