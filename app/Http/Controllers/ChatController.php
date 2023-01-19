<?php

namespace App\Http\Controllers;

use App\Events\NotificationPushEvent;
use App\Jobs\SendMessageChatNotification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\MessageChatNotification;
use App\Services\UsersService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class ChatController extends Controller
{
    private $userService;

    public function __construct(UsersService $userService)
    {
        $this->userService = $userService;
        //$this->middleware('auth')->except(['listenMessageEvent']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all();
        return view('content.chat.index',compact('users'));
    }


    public function show($id)
    {
        return response()->json([
            "user"=>$id
        ]);
    

        $users = User::all();
        return view('content.chat.index','users');
    }
    public function chat()
    {
        return response()->json([
            "user"=>"fsdf"
        ]);
        return view('content.chat.index');
    }

    public function listenMessageEvent(Request $request)
    {
       
        //return response()->json($request->all());
        $user = User::where('email',$request->email)->first();
        $users = $this->userService->getUsersByPermissionName('recibir_correo_mensaje_chat');
        $enviar = true;       
        $users_notification = [] ;
        foreach($users as $key_ => $user_2){
        $enviar = true; 
        if(count($user_2->notifications()->get())>0)    {           
            foreach($user_2->notifications()->get() as $key => $notification){
                //return response()->json([($notification->data['created_at']==date('Y-m-d'))]);
                if((isset($notification->data['user_send_id']) and isset($notification->data['notification_id']) and isset($notification->data['day_at'])                    
                    and $notification->data['notification_id'] == $user->name
                    and $notification->data['day_at']==date('Y-m-d')
                    )                    
                   ){          
                
                    $enviar = false;                  
                }         
             }    
             if($user_2->id == $user->id)$enviar = false;        
             if($enviar){
                $notifi = User::where('email',$user_2->email)->first();
                $users_notification[] =  $notifi;               
            }

        }else{
            if($user_2->id != $user->id) {
                $notifi = User::where('email',$user_2->email)->first();
                $users_notification[] =  $notifi;
               
            }
        }              
        } 

        Notification::send($users_notification,new MessageChatNotification($user)); 
        
      
        return response()->json($users_notification);

        $users_listen=[];
        if($user_2->id == $user->id)$enviar = false;
       
         foreach ($request->users as $key => $user_r) {
            //return response()->json([$user_r['id']]);
           if($user_2->id!=$user_r->id){
                $users_listen[] = User::where('email',$user_r['email'])->first();;
           }
         }
       
       // if($enviar)Notification::send($users,new MessageChatNotification($user)); 
       // return response()->json([$enviar,$user->id , auth()->user()->id]);
       // dd($user->id , auth()->user()->id)    ; 
        //if($user->id == auth()->user()->id) $enviar = false; 
        if($enviar)Notification::send($users,new MessageChatNotification($user)); 
        if($enviar)Notification::send($users_listen,new MessageChatNotification($user));
        //SendMessageChatNotification::dispatch($users,$user)->onQueue('diarys');
        
        return response()->json($users_listen);
    }

}
