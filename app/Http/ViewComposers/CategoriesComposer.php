<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\ReferenceTable;
use App\Models\CaseM;
use App\Models\Diary;

class CategoriesComposer
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
 
      
            $typesQuestions =  Referencetable::where([
                'categories'=>'type_aditional_data',
                'table'=>'aditional_data'
                ])
            ->pluck('name','id');
        
            $view->with([
                'typesQuestions'=>$typesQuestions                
            ]); 
             
       
    }
}