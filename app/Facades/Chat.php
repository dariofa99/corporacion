<?php

namespace App\Facades;

use App\Repositories\GuzzleHttpRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
class Chat extends GuzzleHttpRequest
{

    public $key;
    public $code;
    public $password;
    public $username;   
    public $email;
    public $imagen = 'dist/img/user-default-min.jpg';
    public $can_write;
    public $room;
    public $httpGuzzle;
    protected $view ='content.resources.iframe_chat';
    
    public function __construct(){
        parent::__construct();
        $this->key=config()->get('chat.connection.key');   ; 
        $this->code=config()->get('chat.connection.code');   ; 
        $this->password=config()->get('chat.connection.password');   ;
        $this->username=Auth::user()->name;
        $this->email=Auth::user()->email;        
        $this->can_write=Auth::user()->can('escribir_chat_oficina_virtual');   
        if(Auth::user()->image != "") $this->imagen=Auth::user()->image; 
       
    }

    
    public function render(){
           
        $data = $this->get('/applications/'.$this->getBcryptData(),$this->data());
        return view($this->view,compact('data'));
    }

    public function data(){
        return [
            'code'=>$this->code,
            'password'=>$this->password,
            'key'=>$this->key,
            'username'=>$this->username,
            'room'=>$this->room,
            'email'=>$this->email,
            'imagen'=>url($this->imagen),  
            'appname'=>config('app.name'),
            'appurl'=>config('app.url'),           
            ];
    }

    public function getBcryptData(){
        $data_chat= json_encode($this->data());
        $data_chat = Crypt::encryptString($data_chat);
        return  str_replace("/", "&&&", $data_chat);
        
    }

   }