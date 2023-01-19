<?php

namespace App\Notifications;

use App\Events\NotificationPushEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Support\Facades\Log;

class MessageChatNotification extends Notification implements ShouldQueue //implements ShouldBroadcast
{
    //use Dispatchable, InteractsWithSockets, SerializesModels;
    use Queueable;
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
        return ['database','broadcast'];
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
        ->subject('Mensaje de chat -  Corporación ocho de marzo')      
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
            'url'=>"/admin/users/".$this->notification->id."/edit?chat=true",
            'created_at'=>date("Y-m-d H:i:s"),
            'day_at'=>date("Y-m-d"),
            'icon'=>'fas fa-user',
            'notification_id'=>$this->notification->name,
            'user_send_id'=>$this->notification->id 
        ];
    }

    /**
 * Get the broadcastable representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return BroadcastMessage
 */
    public function toBroadcast($notifiable)
    {
        /* $bra = (new BroadcastMessage([
            'invoice_id' => $notifiable->id, 
            'amount' => "amount",
        ])); */
        Log::info("Notification fire: sisa");
        return  (new BroadcastMessage([
            'user' => $notifiable->notifications()->orderBy('created_at','desc')->first(),           
        ]));
        //->onQueue('database');
    }

    /**
 * Get the type of the notification being broadcast.
 *
 * @return string
 */
    public function broadcastType()
    {
        return 'broadcast.message';
    }


}
