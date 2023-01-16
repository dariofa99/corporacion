<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SessionAdmin;

class SessionAdminController extends Controller
{
    public function adminSessionToken($token,$action){
        $session = \Auth::user()->sessions()->where([
            'token_confirm'=>$token,
            'locked'=>0
            ])->first();
        if($session){
            if($action=='confirm'){
                $session->confirm = 1;
                request()->session()->flash('success', 'Has registrado este equipo como seguro.');
            }elseif ($action=='locked') {
                $session->locked = 1;
                request()->session()->flash('success', 'Se ha registrado un equipo como inseguro. Se ha BLOQUEADO la sesión con éxito.');
    
            }elseif ($action=='logout') {
                $session->logout = 1;
                request()->session()->flash('success', 'Se ha CERRADO la sesión con éxito.');
    
            }elseif ($action=='unconfirmed') {
                $session->logout = 0;
                $session->confirm = 1;
                request()->session()->flash('success', 'Se ha ABIERTO la sesión con éxito.');
    
            }           
            $session->save();
        }
       
       return redirect('/home');
    }

    public function lockedSessionToken($token){
        $session = \Auth::user()->sessions()->where([
            'token_confirm'=>$token,
            'locked'=>0
            ])->first();
           
        if($session){
            $session->locked = 1;
            $session->save();
        }  
        request()->session()->flash('success', 'Se ha registrado un equipo como inseguro. Se ha cerrado la sesión con éxito');
       return redirect('/home');
       // dd($token);
    }
}
