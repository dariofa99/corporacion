<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\ReferenceTable;
use App\Models\ReferenceData;

class UsersComposer
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
         $roles = Role::where('id','<>',1)->where('id','<>',4)->pluck('name','id');
         $types_identification = ReferenceTable::where('categories','type_identification')->pluck('name','id');
         $types_status = ReferenceTable::where('categories','type_status')
         ->where('table','users')->pluck('name','id');
       
         $types_data_user = ReferenceData::where('categories','type_data_user')
         ->where('section','case')->pluck('name','id');

         $types_data_am_user = ReferenceData::where('categories','type_data_user')
         ->where('section','about_me')->pluck('name','id');
           
         $data_aditional_info = 
         ReferenceData::where('categories','type_data_user')
         ->where('section','aditional_info')->get();
         

         //dd($data_aditional_info);
        $view->with(['roles'=>$roles])
        ->with(['types_data_user'=>$types_data_user])
        ->with(['types_data_am_user'=>$types_data_am_user])
        ->with([
            'types_identification'=>$types_identification,
            'data_aditional_info'=>$data_aditional_info,
            'types_status'=>$types_status
        ]); 
             
       
    }
}