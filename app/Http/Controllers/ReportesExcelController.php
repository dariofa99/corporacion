<?php

namespace App\Http\Controllers;

use App\Exports\CasesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Redis;
use App\Models\CaseM; 
use App\Models\User; 
use App\Models\ReferenceTable; 
use App\Models\ReferenceData; 
use DB;

use Maatwebsite\Excel\Facades\Excel;

class ReportesExcelController extends Controller
{

     
    public function __construct()
    {
        $this->middleware('auth');      
      //  $this->middleware('permission:access_dashboard_cases',   ['only' => ['index','edit']]);
       // $this->middleware('permission:crear_casos',   ['only' => ['create','store']]);
    }
 


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $types_data = ReferenceTable::where('categories','type_data_case')->pluck('name','id');
       // $ref_cases = ReferenceTable::where('categories','type_data_user')->get();
        $ref_users = ReferenceData::where('categories','type_data_user')
        ->orWhere('categories','type_data_novelty')
        ->orWhere('categories','type_data_novelty_has')
        ->whereIn('type_data_id',['58','136'])->pluck('name','id');      

        $ref_data_users = ReferenceData::where('categories','type_data_user')
        ->pluck('name','id')->toArray();

        $types_data_user = [];
        $types_data_user[] = 'Número de identificación';
        $types_data_user[] = 'Tipo de identificación';
        $types_data_user[] = 'Nombre';
        $types_data_user[] = 'Email';        
        $types_data_user[] = 'Número de teléfono';
        $types_data_user[] = 'Dirección';
        $types_data_user[] = 'Estado';
               
        
        array_push($types_data_user,$ref_data_users);
     
		return view('content.reports.index',compact('types_data','ref_users','types_data_user'));
    }

    public function toExcel(Request $request){
       // dd($request->all());

        if(!is_numeric($request->select_filter_table) and $request->select_filter_table!='all'){
            $var_c = $request->select_filter_table."_id";
           
            $cases = CaseM::join('user_cases','user_cases.case_id','=','cases.id')
            ->join('references_table as tb1','tb1.id','=','cases.type_status_id')
            ->join('references_table as tb2','tb2.id','=','cases.type_case_id')
            ->join('references_table as tb3','tb3.id','=','cases.type_branch_law_id')
            ->where("cases.$var_c",$request->select_options_filter_table)
            ->where("user_cases.type_user_id",7)
            ->where("cases.type_status_id","<>",15)
            ->where(function($query) use ($request){
                if($request->has('fecha_ini') and $request->has('fecha_fin') ){                  
                      return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                    ->whereDate('cases.created_at','<=',$request->fecha_fin); 
                }
            })
            ->groupBy('cases.id')
             ->select(
                DB::raw("cases.id, cases.case_number,cases.created_at, cases.updated_at,tb1.name as type_status,
                tb2.name type_case,tb3.name as type_branch_law,count(cases.id) as 'num_users'")) 
            ->get();
            //dd($request->fecha_ini,$request->fecha_fin,$cases,$request->all());
            if(count($cases)<=0){
                return redirect()->back()->with('status', 'No se encontraron registros');
            }
                    $cases_ids = $cases->pluck('id')->toArray();

                    $users_cases = User::join('user_cases','user_cases.user_id','=','users.id')
                    ->join('cases','cases.id','=','user_cases.case_id')                   
                    ->where("cases.$var_c",$request->select_options_filter_table) 
                    ->where("user_cases.type_user_id",7)
                    ->where("cases.type_status_id","<>",15)   
                    ->where(function($query) use ($request){
                        if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                            return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                            ->whereDate('cases.created_at','<=',$request->fecha_fin);
                        }
                    })               
                    ->select(
                        DB::raw("users.id, user_cases.case_id, users.name, users.identification_number,cases.case_number")) 
                    ->get();                    
                  
                    $users = User::join('user_cases','user_cases.user_id','=','users.id')
                    ->join('cases','cases.id','=','user_cases.case_id')  
                    ->join('references_table as tb1','tb1.id','=','users.type_identification_id')  
                    ->join('references_table as tb2','tb2.id','=','users.type_status_id')  
                    ->where("cases.$var_c",$request->select_options_filter_table)    
                    ->where("user_cases.type_user_id",7)
                    ->where("cases.type_status_id","<>",15)
                    ->where(function($query) use ($request){
                        if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                            return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                            ->whereDate('cases.created_at','<=',$request->fecha_fin);
                        }
                    }) 
                    ->groupBy('users.id')               
                    ->select(
                        DB::raw("users.id, users.name,identification_number,phone_number,
                        users.status,email,image,address, tb1.name as type_identification, tb2.name as type_status, 
                        users.created_at, users.updated_at, count(users.id) as 'num_casos'")) 
                    ->get();  

                    $cases_novelty_data = CaseM::join('case_novelty_data as cnd','cnd.case_id','=','cases.id')
                    ->join('references_data as rd','rd.id','=','cnd.reference_data_id')  
                    ->join('references_data_options as rdo','rdo.id','=','cnd.reference_data_option_id')
                    ->where("cases.type_status_id","<>",15)
                    ->whereIn('cases.id', $cases_ids)
                    ->where(function($query) use ($request){
                        if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                            return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                            ->whereDate('cases.created_at','<=',$request->fecha_fin);
                        }
                    })              
                    ->groupBy('cases.id')               
                    ->select(
                        DB::raw("cases.case_number,rd.name as novelty,rdo.value as novelty_data")) 
                    ->get();

                    $cases_novelty_has_data = CaseM::join('case_novelty_has_data as cnhd','cnhd.case_id','=','cases.id')
                    ->join('references_data as rd','rd.id','=','cnhd.reference_data_id')  
                    ->join('references_data_options as rdo','rdo.id','=','cnhd.reference_data_option_id')
                    ->where("cases.type_status_id","<>",15)
                    ->whereIn('cases.id', $cases_ids)
                    ->where(function($query) use ($request){
                        if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                            return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                            ->whereDate('cases.created_at','<=',$request->fecha_fin);
                        }
                    })              
                    ->groupBy('cases.id')               
                    ->select(
                        DB::raw("cases.case_number,rd.name as novelty_has,rdo.value as novelty_has_data")) 
                    ->get();
           
        }elseif(is_numeric($request->select_filter_table)){
            $cases = CaseM::join('user_cases','user_cases.case_id','=','cases.id')
            ->join('users','users.id','=','user_cases.user_id')  
            ->join('case_novelty_data as cnd','cnd.case_id','=','cases.id')
            ->join('case_novelty_has_data as cnhd','cnhd.case_id','=','cases.id')  
            ->join('user_aditional_data','user_aditional_data.user_id','=','users.id')  
            ->join('references_table as tb1','tb1.id','=','cases.type_status_id')
            ->join('references_table as tb2','tb2.id','=','cases.type_case_id')
            ->join('references_table as tb3','tb3.id','=','cases.type_branch_law_id')  
            ->where("user_aditional_data.reference_data_option_id",$request->select_options_filter_table) 
            ->orwhere("cnd.reference_data_option_id",$request->select_options_filter_table)  
            ->orwhere("cnhd.reference_data_option_id",$request->select_options_filter_table)  
            ->where("user_cases.type_user_id",7)
            ->where("cases.type_status_id","<>",15)
            ->where(function($query) use ($request){
                if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                    return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                    ->whereDate('cases.created_at','<=',$request->fecha_fin);
                }
            })   
            ->groupBy('cases.id')               
            ->select(
                DB::raw("cases.id, cases.case_number,cases.created_at, cases.updated_at,tb1.name as type_status,
                tb2.name type_case,tb3.name as type_branch_law,count(cases.id) as 'num_users'")) 
            ->get();

            if(count($cases)<=0){
                return redirect()->back()->with('status', 'No se encontraron registros');
            }

            $cases_ids = $cases->pluck('id')->toArray();

            $users = User::join('user_cases','user_cases.user_id','=','users.id')
            ->join('cases','cases.id','=','user_cases.case_id')  
            ->join('case_novelty_data as cnd','cnd.case_id','=','cases.id')
            ->join('case_novelty_has_data as cnhd','cnhd.case_id','=','cases.id')
            ->join('user_aditional_data','user_aditional_data.user_id','=','users.id')  
            ->join('references_table as tb1','tb1.id','=','users.type_identification_id')  
            ->join('references_table as tb2','tb2.id','=','users.type_status_id')  
            ->where("user_aditional_data.reference_data_option_id",$request->select_options_filter_table)
            ->orwhere("cnd.reference_data_option_id",$request->select_options_filter_table)  
            ->orwhere("cnhd.reference_data_option_id",$request->select_options_filter_table) 
            ->where("user_cases.type_user_id",7)
            ->where("cases.type_status_id","<>",15)
            ->where(function($query) use ($request){
                if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                    return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                    ->whereDate('cases.created_at','<=',$request->fecha_fin);
                }
            })     
            ->groupBy('users.id')               
            ->select(
                DB::raw("users.id, users.name,identification_number,phone_number,
                users.status,email,image,address, tb1.name as type_identification, tb2.name as type_status, 
                users.created_at, users.updated_at, count(users.id) as 'num_casos'")) 
            ->get();

          
            $users_cases = User::join('user_cases','user_cases.user_id','=','users.id')
            ->join('user_aditional_data','user_aditional_data.user_id','=','users.id')   
            ->join('cases','cases.id','=','user_cases.case_id')                
            ->join('case_novelty_data as cnd','cnd.case_id','=','cases.id')
            ->join('case_novelty_has_data as cnhd','cnhd.case_id','=','cases.id')
            ->where("user_aditional_data.reference_data_option_id",$request->select_options_filter_table)  
            ->orwhere("cnd.reference_data_option_id",$request->select_options_filter_table)  
            ->orwhere("cnhd.reference_data_option_id",$request->select_options_filter_table)  
            ->where("user_cases.type_user_id",7)
            ->where("cases.type_status_id","<>",15)
            ->where(function($query) use ($request){
                if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                    return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                    ->whereDate('cases.created_at','<=',$request->fecha_fin);
                }
            })            
            ->select(
                DB::raw("users.id, user_cases.case_id, users.name, users.identification_number,
                cases.case_number")) 
            ->get(); 

            $cases_novelty_data = CaseM::join('case_novelty_data as cnd','cnd.case_id','=','cases.id')
            ->join('references_data as rd','rd.id','=','cnd.reference_data_id')  
            ->join('references_data_options as rdo','rdo.id','=','cnd.reference_data_option_id')
            ->where("cases.type_status_id","<>",15)
            ->whereIn('cases.id', $cases_ids)
            ->where(function($query) use ($request){
                if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                    return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                    ->whereDate('cases.created_at','<=',$request->fecha_fin);
                }
            })              
            ->groupBy('cases.id')               
            ->select(
                DB::raw("cases.case_number,rd.name as novelty,rdo.value as novelty_data")) 
            ->get();

            $cases_novelty_has_data = CaseM::join('case_novelty_has_data as cnhd','cnhd.case_id','=','cases.id')
            ->join('references_data as rd','rd.id','=','cnhd.reference_data_id')  
            ->join('references_data_options as rdo','rdo.id','=','cnhd.reference_data_option_id')
            ->where("cases.type_status_id","<>",15)
            ->whereIn('cases.id', $cases_ids)
            ->where(function($query) use ($request){
                if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                    return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                    ->whereDate('cases.created_at','<=',$request->fecha_fin);
                }
            })              
            ->groupBy('cases.id')               
            ->select(
                DB::raw("cases.case_number,rd.name as novelty_has,rdo.value as novelty_has_data")) 
            ->get();

        }elseif ($request->select_filter_table=='all') {
            $cases = CaseM::join('user_cases','user_cases.case_id','=','cases.id')
            ->join('users','users.id','=','user_cases.user_id')  
            //->join('user_aditional_data','user_aditional_data.user_id','=','users.id')  
            ->join('references_table as tb1','tb1.id','=','cases.type_status_id')
            ->join('references_table as tb2','tb2.id','=','cases.type_case_id')
            ->join('references_table as tb3','tb3.id','=','cases.type_branch_law_id') 
            ->where("user_cases.type_user_id",7)  
            ->where("cases.type_status_id","<>",15)
            ->where(function($query) use ($request){
                if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                    return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                    ->whereDate('cases.created_at','<=',$request->fecha_fin);
                }
            })              
            ->groupBy('cases.id')               
            ->select(
                DB::raw("cases.id, cases.case_number,cases.created_at, cases.updated_at,tb1.name as type_status,
                tb2.name type_case,tb3.name as type_branch_law,count(cases.id) as 'num_users'")) 
            ->get();
            if(count($cases)<=0){
                return redirect()->back()->with('status', 'No se encontraron registros');
              }

            $users = User::join('user_cases','user_cases.user_id','=','users.id')
            ->join('cases','cases.id','=','user_cases.case_id')  
            //->join('user_aditional_data','user_aditional_data.user_id','=','users.id')  
            ->join('references_table as tb1','tb1.id','=','users.type_identification_id')  
            ->join('references_table as tb2','tb2.id','=','users.type_status_id')  
            ->where("user_cases.type_user_id",7)
            ->where("cases.type_status_id","<>",15)
            ->where(function($query) use ($request){
                if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                    return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                    ->whereDate('cases.created_at','<=',$request->fecha_fin);
                }
            })
            ->groupBy('users.id')               
            ->select(
                DB::raw("users.id, users.name,identification_number,phone_number,
                users.status,email,image,address, tb1.name as type_identification, tb2.name as type_status, 
                users.created_at, users.updated_at, count(users.id) as 'num_casos'")) 
            ->get();

          
            $users_cases = User::join('user_cases','user_cases.user_id','=','users.id')
            //->join('user_aditional_data','user_aditional_data.user_id','=','users.id')   
            ->join('cases','cases.id','=','user_cases.case_id')  
            ->where("user_cases.type_user_id",7)
            ->where("cases.type_status_id","<>",15)             
            ->where(function($query) use ($request){
                if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                    return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                    ->whereDate('cases.created_at','<=',$request->fecha_fin);
                }
            }) 
            ->select(
                DB::raw("users.id, user_cases.case_id, users.name, users.identification_number,
                cases.case_number")) 
            ->get();

            $cases_novelty_data = CaseM::join('case_novelty_data as cnd','cnd.case_id','=','cases.id')
            ->join('references_data as rd','rd.id','=','cnd.reference_data_id')  
            ->join('references_data_options as rdo','rdo.id','=','cnd.reference_data_option_id')
            ->where("cases.type_status_id","<>",15)
            ->where(function($query) use ($request){
                if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                    return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                    ->whereDate('cases.created_at','<=',$request->fecha_fin);
                }
            })              
            ->groupBy('cases.id')               
            ->select(
                DB::raw("cases.case_number,rd.name as novelty,rdo.value as novelty_data")) 
            ->get();

            $cases_novelty_has_data = CaseM::join('case_novelty_has_data as cnhd','cnhd.case_id','=','cases.id')
            ->join('references_data as rd','rd.id','=','cnhd.reference_data_id')  
            ->join('references_data_options as rdo','rdo.id','=','cnhd.reference_data_option_id')
            ->where("cases.type_status_id","<>",15)
            ->where(function($query) use ($request){
                if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                    return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                    ->whereDate('cases.created_at','<=',$request->fecha_fin);
                }
            })              
            ->groupBy('cases.id')               
            ->select(
                DB::raw("cases.case_number,rd.name as novelty_has,rdo.value as novelty_has_data")) 
            ->get();

        }
        $to_export = [];
                        if (count($cases)>0 and isset($request->values) and count($request->values)>0 ) {
                            $data_cases = $this->getDataCases($cases,$request);
                            $to_export[] = $data_cases;
                        }
                        if (count($users)>0 and isset($request->user_values) and count($request->user_values)>0) {
                            $data_users = $this->getDataUsers($users,$request);
                            $to_export[] = $data_users;
                        }
                        if (count($users_cases)>0) {
                            $data_users_cases = $this->getDataUsersCases($users_cases);
                            $to_export[] = $data_users_cases;
                        }
                        if (count($cases_novelty_data)>0) {
                            $data_cases_novelty_data = $this->getDataCasesNovelty($cases_novelty_data);
                            $to_export[] = $data_cases_novelty_data;
                        }
                        if (count($cases_novelty_has_data)>0) {
                            $data_cases_novelty_has_data = $this->getDataCasesNoveltyHas($cases_novelty_has_data);
                            $to_export[] = $data_cases_novelty_has_data;
                        }
            return Excel::download(new CasesExport($to_export), 'cases.xlsx');

       
    }


    private function getDataUsersCases($model_array){
        $to_excel = [];
        $header=[];      
        $header[] = "nombres";
        $header[] = "número identificación";
        $header[] = "número de caso";

        $data_val = [];
        foreach ($model_array as $key_1 => $model) {
            $data_val = [];
            $data_val[] = $model->name;
            $data_val[] = $model->identification_number;
            $data_val[] = $model->case_number; 
            $to_excel[] = $data_val;
        }
        return ["data"=>$to_excel,"header"=>$header,'title'=>'perfil_casos'];
    }

    private function getDataUsers($users,Request $request){
        $to_excel = [];
        $header=[];      
        foreach ($request->user_header as $key => $type_data) {
            $header[] = $type_data;
        }
        $header[] = "número de casos";
        foreach ($users as $key_1 => $model) {
            $data_val = [];        
            foreach ($request->user_values as $id => $type_data) {
                if(is_numeric($type_data)){
                    $question = ReferenceData::find($type_data);
                    if($question->type_data_id == 58 || $question->type_data_id == 136){
                        $data = $model->getAditionalDataValueById($type_data);
                    }else{
                        $data = $model->getDataValue($type_data);
                        
                    }                   
                    if($data){
                        $data_val[] = $data->value;
                    }else{                        
                        $data_val[] = 'Sin registro';
                                              
                    }
                }else{
                    if($type_data=='numero_de_identificacion'){
                        $data_val[] = $model->identification_number;
                    }
                    if($type_data=='tipo_de_identificacion'){
                        $data_val[] = $model->type_identification;
                    }
                    if($type_data=='nombre'){
                        $data_val[] = $model->name;
                    }
                    if($type_data=='email'){                       
                        $data_val[] = $model->email;
                    }
                    if($type_data=='numero_de_telefono'){                       
                        $data_val[] = $model->phone_number;
                    }
                    if($type_data=='direccion'){                       
                        $data_val[] = $model->address;
                    }
                    if($type_data=='estado'){                       
                        $data_val[] = $model->status ? "Activo":"Inactivo";
                    }
                }                
            }
            $data_val[] = $model->num_casos;
            $to_excel[] = $data_val;
            
        }       
        return ["data"=>$to_excel,"header"=>$header,'title'=>'perfiles'];
    }
    private function getDataCases($cases,Request $request){
        $to_excel = [];
        $header=[];     
        foreach ($request->header as $key => $type_data) {
            $header[] = $type_data;
        }
        $header[] = 'número de usuarios';
        foreach ($cases as $key_1 => $case) {
            $data_val = [];        
            foreach ($request->values as $id => $type_data) {
                if(is_numeric($type_data)){
                    $data = $case->getCaseData($type_data);
                    if($data){
                        $data_val[] = $data->value;
                    }else{
                        $data_val[] = 'Sin registro';
                    }
                }else{
                    if($type_data=='numero_caso'){
                        $data_val[] = $case->case_number;
                    }
                    if($type_data=='estado'){
                        $data_val[] = $case->type_status;
                    }
                    if($type_data=='tipo_proceso'){
                        $data_val[] = $case->type_case;
                    }
                    if($type_data=='rama_derecho'){                       
                        $data_val[] = $case->type_branch_law;
                    }
                }
                
            }
            $data_val[] = $case->num_users;
            $to_excel[] = $data_val;
            
        }
        return ["data"=>$to_excel,"header"=>$header,'title'=>'casos'];
    }

    private function getDataCasesNovelty($model_array){
        $to_excel = [];
        $header=[];      
        $header[] = "número de caso";
        $header[] = "autoridad competente";
        $header[] = "novedad";

        $data_val = [];
        foreach ($model_array as $key_1 => $model) {
            $data_val = [];
            $data_val[] = $model->case_number;
            $data_val[] = $model->novelty;
            $data_val[] = $model->novelty_data; 
            $to_excel[] = $data_val;
        }
        return ["data"=>$to_excel,"header"=>$header,'title'=>'autoridades_competentes_casos'];
    }

    private function getDataCasesNoveltyHas($model_array){
        $to_excel = [];
        $header=[];      
        $header[] = "número de caso";
        $header[] = "cuenta con";
        $header[] = "novedad";

        $data_val = [];
        foreach ($model_array as $key_1 => $model) {
            $data_val = [];
            $data_val[] = $model->case_number;
            $data_val[] = $model->novelty_has;
            $data_val[] = $model->novelty_has_data; 
            $to_excel[] = $data_val;
        }
        return ["data"=>$to_excel,"header"=>$header,'title'=>'cuenta_con_casos'];
    }


    public function getOptionFilter(Request $request){
        $response = [];
        if(is_numeric($request->filter_id)){
            $ref = ReferenceData::find($request->filter_id);            
            $response['options'] = $ref->options;

        }else{
            if($request->filter_id){
                $response['options'] = ReferenceTable::where([
                    'categories'=>$request->filter_id,
                    'table'=>'cases'
                ])->get();
            }
        }
       
        return response()->json($response);
    }

}
