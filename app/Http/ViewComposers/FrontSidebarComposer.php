<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\ReferenceTable;
use App\Models\CaseM;
use App\Models\Diary;

class FrontSidebarComposer
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
 
      
            $num_cases = auth()->user()->cases()
            ->where('type_status_id', '!=',15)->where('type_user_id',7)->count();

            $receptions = auth()->user()
            ->receptions()->where('receptions.type_status_id', '=',142)->count();
            $num_cases = ($num_cases + $receptions);
  
            $view->with([
                'num_cases'=>$num_cases,
                'receptions_count'=>$receptions
            ]); 
             
       
    }
}