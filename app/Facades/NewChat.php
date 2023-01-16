<?php

namespace App\Facades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Crypt;
class NewChat 
{
    public $username;
    public $room;
    public $idusuario;
    public $correo;
    public $imagen = 'dist/img/user-default-min.jpg';
    public $can_write;
    public function __construct(){

        $this->username=\Auth::user()->name;
        $this->room='salaatencion';
        $this->idusuario=\Auth::user()->identification_number;
        $this->correo=\Auth::user()->email;        
        $this->can_write=\Auth::user()->can('escribir_chat_oficina_virtual');   
        (\Auth::user()->image != "") ? $this->imagen=\Auth::user()->image : ''; 
    }

    public function render(){
        $data_chat = [
            'username'=>$this->username,
            'room'=>$this->room,
            'idusuario'=>$this->idusuario,
            'correo'=>$this->correo,
            'imagen'=>url($this->imagen),
           // 'can_write'=>$this->can_write 
            ];
        
        
           // dd($data_chat); 
            $data_chat= json_encode($data_chat);

                $data_chat = Crypt::encryptString($data_chat);
                $data_chat = str_replace("/", "&&&", $data_chat);

           // dd($data_chat);
       
         return view('content.resources.iframe_chat',compact('data_chat'));
    }

    public function room($room){
        $this->room=$room; 
        return $this;
    }

    public function image($image){        
        $this->image = $image;
        return $this;
    }
  

}