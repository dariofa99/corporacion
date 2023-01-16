<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Role;
use App\Models\ReferenceTable;
use App\Models\ReferenceData;

class DirectoryComposer
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
        $types_data_directory = ReferenceData::where(['categories'=>'type_data_directory','table'=>'directory'])
       ->pluck('name','id');
   
         
        $view->with([
            'types_data_directory'=>$types_data_directory
            ]); 
             
       
    }
}