<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\ReferenceTable;
use App\Models\ReferenceData;
use App\Models\Role;
use App\Models\User;


class PanicAlertComposer
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
         $types_status = ReferenceTable::where(['categories'=>'type_status','table'=>'panic_alerts'])
         ->pluck('name','id');
        
        
		
        $view->with(['types_status'=>$types_status]); 
             
       
    }
}