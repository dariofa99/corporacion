<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Events\Logout;
use Redis;
use App\Models\SessionAdmin;

class UserLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *   
     * @param  object  $event
     * @return void
     */
    public function handle(Logout $event)
    {  
           
        $session = $event->user->sessions()->where('token_pc',request()->token)->orderBy('id','desc')->first();
        //dd( $session);
        if($session){
            $session->out_date = date('Y-m-d H:i:s');
            $session->save();
        } 
       // dd(request()->path());
        $event->user->remember_token = '';  
        $event->user->save();

        //$redis = Redis::connection();
        //$redis -> publish('', json_encode(['channel' => 'logout','message' => $event->user]));
    }
}
