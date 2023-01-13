<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\SessionAdmin;
use App\Notifications\AccountActivatedNotification;
use App\Notifications\MessageChatNotification;

class SendMessageChatNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
 
    public $users;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $users,$user)
    {  
      
        $this->users = $users;
        $this->user = $user;
      
    }

    /**
     * Execute the job. 
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->users as $key => $user) {
            
        }
        Notification::send($this->users,new MessageChatNotification($this->user));
    }
}
