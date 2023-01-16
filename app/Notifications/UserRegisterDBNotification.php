<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;
class UserRegisterDBNotification extends Notification
{
    use Queueable;
    public $date;   
    public $notification;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $notification)
    {  
       
        $this->notification = $notification;     
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
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
        ->subject('Novedad en el sistema Lybra')
         ->view(
            'mail.admin_user_register_notification',[
                'user' => $this->notification,               
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
            'message'=>($this->notification->name)." se ha registrado",
            'url'=>"/admin/users/".$this->notification->id."/edit",
            'created_at'=>date("Y-m-d H:i:s"),
            'icon'=>'fas fa-user'
        ];
    }
}
