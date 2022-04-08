<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\UserRegisterNotificationMail;
use App\Models\SessionAdmin;


class SendRegisterNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    public $user;
    public $password_send;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,$password_send)
    {  
        $this->user = $user;
        $this->password_send = $password_send;
        //dd($this->user);
    }

    /**
     * Execute the job. 
     *
     * @return void
     */
    public function handle()
    {
      
        $this->user->notify(new UserRegisterNotificationMail($this->user,$this->password_send));

       //dd($this->user,'ho');
        //Notification::send($this->user, new LoginNotification($this->user,$this->session_data,$this->session));
    }
}
