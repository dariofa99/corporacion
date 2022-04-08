<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\ReferenceTable;
use DB;
use App\Models\User;


class DiaryComposer
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
      
        $users = User::join('model_has_roles as ru', 'users.id','=', 'ru.model_id')
            ->join('roles','roles.id','=','ru.role_id')
            ->select('users.name as name','users.id as id')
          //  ->where('roles.name','<>','Admin')
            ->where('roles.name','<>','Amatai')
            ->orderBy('roles.id')
            ->get();
     

        $users_prof = User::join('model_has_roles as ru', 'users.id','=', 'ru.model_id')
            ->join('roles','roles.id','=','ru.role_id')
            ->select('users.name as name','users.id as id')
            ->where('roles.id','Profesional')->get();
           // $users_prof = User::all();
        $view->with(['users'=>$users])
        ->with(['users_prof'=>$users_prof]); 
             
       
    }
}