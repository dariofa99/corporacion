<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->can('acceso_oficina_virtual')){
            return redirect('/oficina');
         } elseif (auth()->user()->can('access_dashboard_cases')) {
             return redirect('/casos');
         }else{
             \Auth::logout();
             \Session::flush();
             return redirect('/login')->with('status', 'Tú cuenta fue creada con éxito, Falta ser confirmada..!');;
         }
    }
}
