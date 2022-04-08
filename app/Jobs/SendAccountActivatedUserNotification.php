<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Notifications\AccountActivatedNotification;

use App\Models\SessionAdmin;


class SendAccountActivatedUserNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
 
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {  
      
        $this->user = $user;
      
    }

    /**
     * Execute the job. 
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new AccountActivatedNotification($this->user));
    }
}
