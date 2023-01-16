<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Models\UserMailNotification;
use App\Notifications\LogDefendantNotification;
use App\Mail\LogMail;
use App\Models\CaseLog;
use App\Models\User;


class SendDefendantNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   // public $session;
    public $caseL;
    public $users;
    public $user;
    public $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users,CaseLog $caseL,User $user,$token)
    {
        
        $this->caseL = $caseL;
        $this->users = $users;
        $this->user = $user; 
        $this->token = $token;  

    }

    /**
     * Execute the job. 
     *
     * @return void
     */
    public function handle()
    {
              
            \Mail::to($this->user->email)->send(new LogMail($this->caseL,$this->token)); 
         
        
       
    }
}
