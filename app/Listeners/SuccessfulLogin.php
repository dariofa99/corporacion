<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Events\Login;
use Redis;
use Cookie;
use App\Models\SessionAdmin;
use App\Jobs\SendLoginNotificationEmail;
use App\Jobs\SendLoginClientNotificationEmail;

use App\Notifications\LoginNotification;

class SuccessfulLogin
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
    public function handle(Login $event)
    {
     
        $session_data=[];
        $session = new SessionAdmin();
      
        $session->verifyToken(); 
        

        $session_data['ip'] = $session->getUserIpAddr();
        $session_data['country'] = $session->getGeoLocalization('country');
        $session_data['city'] = $session->getGeoLocalization('city');
        $session_data['os'] = $session->getOS(request()->header('User-Agent'));
        $session_data['browser'] = $session->getBrowser(request()->header('User-Agent'));
        $session_data['time'] = date('Y-m-d H:i:s'); 
        $session->access_address = json_encode($session_data);               
        $session->save();
        Cookie::queue(Cookie::make('tokenpc',$session->token_pc, 1,null, null, false, false));
        session(['tokenpc'=>$session->token_pc]);      
        $event->user->remember_token = $session->token_pc;
        $event->user->save();   
           
       try {  
            SendLoginClientNotificationEmail::dispatch($event->user,date('Y-m-d H:i:s'))->onQueue('diarys');
        // SendLoginNotificationEmail::dispatch($event->user,$session,$session_data)->onQueue('login'); //descomentar
           // SendLoginClientNotificationEmail::dispatch($event->user,$session,$session_data)->onQueue('login');
           //$event->user->notify(new LoginNotification($event->user,$session_data,$session));
        } catch (\Throwable $th) { 
            request()
            ->session()  
            ->flash('mail_error',"A ocurrido un error al enviar el email de sesión. Consulte con el administrador.");
       }  
        
       // $redis = Redis::connection();
       // $redis -> publish('', json_encode(['channel' => 'login','message' =>  $event->user]));
    }
}
