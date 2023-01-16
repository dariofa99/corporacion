<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\CaseM;
use App\Models\Directory;
use App\Models\Library;
use App\Models\Reception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SidebarComposer
{
    

    public function __construct()
    {
       
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
 
         if (Auth::user()->can('ver_todos_casos')) {
            $num_cases = CaseM::where('cases.type_status_id','<>','15')->count();
        } else {
            $num_cases=CaseM::join('references_table as rt','rt.id','cases.type_status_id')
            ->join('references_table as rtc','rtc.id','cases.type_case_id')
            ->join('references_table as rtr','rtr.id','cases.type_branch_law_id')
            ->join('user_cases', 'user_cases.case_id','cases.id')
            ->where('user_cases.user_id', \Auth::user()->id)
            ->where('user_cases.type_user_id','8')
            ->where('cases.type_status_id','<>','15')
            ->select('cases.id')
            ->count();

            $receptions = auth()->user()
            ->receptions()->where('receptions.type_status_id', '!=',15)->count();
            $num_cases = ($num_cases + $receptions);
        }
        $directories =   Directory::where('type_status_id','<>',15)
        ->where('origin','web')->count();

        $num_recep =   Reception::where('type_status_id',142)
       ->count();

         $num_diarys = count(auth()->user()->diarys()->where('inicio', '>=', date('Y-m-d H:i:s'))->get());
         
         $clients_c = 
          User::join('model_has_roles as ru', 'users.id','=', 'ru.model_id')
         ->select('users.id as id','name', 'email', 'password','identification_number','phone_number','type_identification_id','address','image')
         ->where('users.id','<>',Auth::user()->id)
         ->where('role_id','5')->count(); 

         $users_staff =
         User::join('model_has_roles as ru', 'users.id','=', 'ru.model_id')
         ->select('users.id as id','name', 'email', 'password','identification_number','phone_number','type_identification_id','address','image')
         ->where('users.id','<>',Auth::user()->id)
         ->where('role_id','<>','5')->where('role_id','<>','1')->count();

         $library_c = Library::select('id','name_file','size','user_id','created_at')
         ->count();

        $view->with(['num_cases'=>$num_cases])
        ->with(['num_diarys'=>$num_diarys])
        ->with(['users_staff'=>$users_staff])
        ->with(['library_c'=>$library_c])
        ->with(['clients_c'=>$clients_c])
        ->with([
            'directories'=>$directories,
            'num_recep'=>$num_recep
        ]); 
             
       
    }
}