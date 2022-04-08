<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\ReferenceTable;
use App\Models\ReferenceData;
use App\Models\Role;
use App\Models\User;


class FrontComposer
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
         

       

         $types_categories_pays = Referencetable::where(['categories'=>'type_category_pay','table'=>'payments'])
         ->pluck('name','id');

         $types_payment = Referencetable::where(['categories'=>'type_payment','table'=>'payments'])
         ->pluck('name','id');

         $types_periodpay = Referencetable::where(['categories'=>'type_periodpay','table'=>'payments'])
         ->pluck('name','id');

         
         $types_status_pay = Referencetable::where(['categories'=>'type_status','table'=>'payments'])
         ->pluck('name','id');

         $types_payment_method  = Referencetable::where(['categories'=>'type_payment_method ','table'=>'payment_credits']) 
         ->pluck('name','id');

         $types_support_file = Referencetable::where(['categories'=>'type_support_file','table'=>'payments'])
         ->pluck('name','id');

       	
		
		
        $view->with(['types_support_file'=>$types_support_file])
        ->with(['types_categories_pays'=>$types_categories_pays])
        ->with(['types_payment'=>$types_payment])
        ->with(['types_periodpay'=>$types_periodpay])
        ->with(['types_payment_method'=>$types_payment_method])
        ->with(['types_status_pay'=>$types_status_pay]); 
             
       
    }
}