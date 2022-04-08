<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyStatus
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
        if (\Auth::user()->type_status_id==16) {
            \Auth::logout();
            \Session::flush();
            return redirect('/login')->with('status', 'Vamos a verificar la información registrada, nos comunicaremos muy pronto para darte acceso al sistema.!');;
           
        }
        return $next($request);
    }
}
