<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifySessionAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::user()) {
           
            $session = \Auth::user()->sessions()->where([
                'token_pc'=>session('tokenpc')]) ->orderBy('id','desc')->first();
                //dd($session);
            if($session and ($session->logout ||$session->locked)){   
                \Auth::logout();
                \Session::flush();
                return redirect('/login');
            }else if(!$session){
                \Auth::logout();
                \Session::flush();
                return redirect('/login');
            }
               // dd($session);
            //return redirect('/home');
        }
        return $next($request);
    }
}
