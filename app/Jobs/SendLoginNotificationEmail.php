<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\LoginNotification;
use App\Models\SessionAdmin;


class SendLoginNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $session;
    public $session_data;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,SessionAdmin $session,$session_data)
    {
        $this->session_data = $session_data;
        $this->session = $session;
        $this->user = $user;
        //dd($this->user);
    }

    /**
     * Execute the job. 
     *
     * @return void
     */
    public function handle()
    {
      
        $this->user->notify(new LoginNotification($this->user,$this->session_data,$this->session));        
       //dd($this->user,'ho');
        //Notification::send($this->user, new LoginNotification($this->user,$this->session_data,$this->session));
    }
}
