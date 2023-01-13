<?php

namespace App\Http\Controllers;

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
       
       // return response()->json($request->all());
        $user = User::where('email',$request->email)->first();
        $users = $this->userService->getUsersByPermissionName('recibir_correo_user_register');
        $enviar = true;
      //  dd($users)    ;
        $users_listen = [] ;
        foreach($users as $key => $user_2){
        foreach($user_2->notifications()->get() as $key => $notification){   
            //dd($user_2->id, $user->id)    ;    
            if($notification->data['user_send_id'] and $notification->data['user_send_id'] == $user->id and Carbon::parse($notification->created_at)->format('Y-m-d') == date('Y-m-d')){
                $enviar = false;
            }            
         }   
         if($user_2->id == $user->id)$enviar = false;
       
         foreach ($request->users as $key => $user_r) {
            //return response()->json([$user_r['id']]);
           if($user_2->id!=$user_r['id']){
                $users_listen[] = User::where('email',$user_r['email'])->first();;
           }
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
