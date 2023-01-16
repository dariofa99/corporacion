<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\CaseLog;
class LogDatabaseNotification extends Notification
{
    use Queueable;
    public $date;   
    public $notification;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CaseLog $notification,$date)
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'type_notification'=>'Notificación de bitacora',          
            'message'=>($this->notification->description),
            'concept'=>($this->notification->concept),
            'created_at'=>$this->date
        ];
    }
}
