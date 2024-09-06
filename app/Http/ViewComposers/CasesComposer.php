<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\ReferenceTable;
use App\Models\ReferenceData;
//use App\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class CasesComposer
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
         $types_case = Referencetable::where('categories','type_case')->pluck('name','id');

         $types_branch_law = Referencetable::where('categories','type_branch_law')->pluck('name','id');
        
         $types_identification = Referencetable::where('categories','type_identification')->pluck('name','id');
        
         $types_status = Referencetable::where(['categories'=>'type_status','table'=>'cases'])->pluck('name','id');
        
         $types_data_user = ReferenceData::where('categories','type_data_user')
         ->where('section','case')->pluck('name','id');

         $types_categories_log = ReferenceData::where(['categories'=>'type_category_log','table'=>'case_log'])
         ->pluck('name','id');

         $types_categories_novelty = ReferenceData::where(['categories'=>'type_data_novelty','table'=>'case'])
         ->pluck('name','id');

         $types_categories_novelty_has = ReferenceData::where(['categories'=>'type_data_novelty_has','table'=>'case'])
         ->pluck('name','id');

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

        // $roles_access_vo = Permission::whereName('acceso_oficina_virtual')->first()->roles;
         //$roles_prof=Permission::whereName('revisar_casos')->first()->roles;
        $roles_access_vo = Role::leftjoin('role_has_permissions','roles.id','=','role_has_permissions.role_id')
         ->where('role_has_permissions.permission_id','14')
         ->get();

         $roles_prof= Role::where('name','Profesional')->get();

         $users_prof = User::join('model_has_roles as ru', 'users.id','=', 'ru.model_id')
            ->join('roles','roles.id','=','ru.role_id')
            ->join('role_has_permissions as pr','pr.role_id','=','roles.id')
            ->join('permissions','permissions.id','=','pr.permission_id')
            ->select('users.name as name','users.id as id')
            ->where('permissions.name','revisar_casos')->get();
          //  $users_prof = User::limit(10)->get();
           /*$users = $users->each(function ($key) {
                return $key->hasRole('Amatai');*/
      //  dd($users_prof);
        $view->with(['types_case'=>$types_case])
        ->with(['types_branch_law'=>$types_branch_law])
        ->with(['types_identification'=>$types_identification])
        ->with(['roles_access_vo'=>$roles_access_vo])
        ->with(['types_data_user'=>$types_data_user])
        ->with(['types_support_file'=>$types_support_file])
        ->with(['types_categories_pays'=>$types_categories_pays])
        ->with(['types_payment'=>$types_payment])
        ->with(['types_periodpay'=>$types_periodpay])
        ->with(['types_payment_method'=>$types_payment_method])
        ->with(['types_status_pay'=>$types_status_pay])
        ->with(['types_status'=>$types_status])
        ->with(['roles_prof'=>$roles_prof])
        ->with(['types_categories_log'=>$types_categories_log])
        ->with(['types_categories_novelty'=>$types_categories_novelty])
        ->with(['types_categories_novelty_has'=>$types_categories_novelty_has])
        ->with(['users_prof'=>$users_prof]); 
             
       
    }
}