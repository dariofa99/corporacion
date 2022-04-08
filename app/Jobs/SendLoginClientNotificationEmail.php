<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\LoginClientNotification;
use App\Models\SessionAdmin;


class SendLoginClientNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    public $user;
    public $date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,$date)
    {
        $this->user = $user; 
        $this->date = $date;        
    }

    /**
     * Execute the job. 
     *
     * @return void
     */
    public function handle()
    {
        $cases = $this->user->cases()->where('type_user_id',7)->get();      
        $users_cases = [];
        if(count($cases)>0){
            foreach ($cases as $key => $case) {                
                $users = $case->users()->where('type_user_id',8)->get();
                if(count($users)>0){
                    foreach ($users as $key => $user) {
                        $users_cases[] = $user->id;
                    }
                }
                //$users_cases[] = $users;
            }
        }
        $users_cases = collect($users_cases);
        $users_cases =  $users_cases->unique();
        $users = User::whereIn('id',$users_cases->values()->all())->get();
        
        if(count($users)>0){
            Notification::send($users, new LoginClientNotification($this->user,$this->date));    
        }
        //$this->user->notify(new LoginClientNotification($this->user,$this->session_data,$this->session));        
       //dd($this->user,'ho');
        }
}
