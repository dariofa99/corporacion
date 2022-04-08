<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Redis;
use App\Models\CaseM; 
use App\Models\ReferenceTable; 
use App\Models\ReferenceData; 
use DB;
use App\Exports\CasesExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportesChartsController extends Controller
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
        ->whereIn('type_data_id',['58','136'])->pluck('name','id');


		return view('content.reports.index',compact('types_data','ref_users'));
    }

    public function getData(Request $request){
        $chart=[];
        $response = [];
       // return response()->json($request->all());
     
        if(is_numeric($request->select_filter_graphic)){            
            $ref = ReferenceData::find($request->select_filter_graphic);            
            $options = $ref->options;
            if($request->select_filter_cruce){
                $data=[];
                $graph=[];

                if(!is_numeric($request->select_filter_cruce)){
                    $options_cruce = ReferenceTable::where([
                        'categories'=>$request->select_filter_cruce,
                        'table'=>'cases'
                    ])->get();
                    $ocselected = $request->select_filter_cruce."_id";
                    foreach ($options as $key => $option) {
                        $values=[];
                        foreach ($options_cruce as $key_2 => $option2) {
                             $counter = CaseM::join('user_cases','user_cases.case_id','=','cases.id')
                            ->join('users','users.id','=','user_cases.user_id')  
                            ->join('user_aditional_data','user_aditional_data.user_id','=','users.id')  
                            ->join('references_table as tb1','tb1.id','=','cases.type_status_id')
                            ->join('references_table as tb2','tb2.id','=','cases.type_case_id')
                            ->join('references_table as tb3','tb3.id','=','cases.type_branch_law_id')  
                            ->where("user_aditional_data.reference_data_option_id",$option->id)  
                            ->where("cases.".$ocselected,$option2->id)
                            ->where("user_cases.type_user_id",7)
                            ->where("cases.type_status_id","<>",15)
                            ->where(function($query) use ($request){   
                                if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                                    return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                                    ->whereDate('cases.created_at','<=',$request->fecha_fin);
                                }
                            })                                            
                            ->count();
                            $values[$option2->name] =  $counter ;
                            if($key==0)$graph[] = ['value_graph'=>$option2->name];
                        }
                        $values['encabezado'] = $option->value ;
                        $data[]= $values;
                    }
                }else{
                   // return "asi es";
                    $ref = ReferenceData::find($request->select_filter_cruce);            
                    $options_cruce = $ref->options;
                    foreach ($options as $key => $option) {
                        $values=[];
                        foreach ($options_cruce as $key_2 => $option2) {
                            $counter = CaseM::join('user_cases','user_cases.case_id','=','cases.id')
                            ->join('users','users.id','=','user_cases.user_id')  
                            ->join('user_aditional_data','user_aditional_data.user_id','=','users.id')  
                            ->join('references_table as tb1','tb1.id','=','cases.type_status_id')
                            ->join('references_table as tb2','tb2.id','=','cases.type_case_id')
                            ->join('references_table as tb3','tb3.id','=','cases.type_branch_law_id')  
                            ->where(function($query)use($option2,$option){
                                return $query->where("user_aditional_data.reference_data_option_id",$option2->id)  
                                ->where('user_aditional_data.reference_data_option_id',$option->id);
                            })
                            
                            ->where("user_cases.type_user_id",7)
                            ->where("cases.type_status_id","<>",15)
                            ->where(function($query) use ($request){
                                if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                                    return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                                    ->whereDate('cases.created_at','<=',$request->fecha_fin);
                                }
                            })                                            
                            ->count();
                            $values[$option2->value] =  $counter ;
                            if($key==0)$graph[] = ['value_graph'=>$option2->value];
                        }
                        $values['encabezado'] = $option->value ;
                        $data[]= $values;
                    }
                }
                $chart['data'] = $data;
                $chart['graph'] = $graph;
            }else{
                foreach ($options as $key => $option) {
                    $cases = CaseM::join('user_cases','user_cases.case_id','=','cases.id')
                        ->join('users','users.id','=','user_cases.user_id')  
                        ->join('user_aditional_data','user_aditional_data.user_id','=','users.id')  
                        ->join('references_table as tb1','tb1.id','=','cases.type_status_id')
                        ->join('references_table as tb2','tb2.id','=','cases.type_case_id')
                        ->join('references_table as tb3','tb3.id','=','cases.type_branch_law_id')  
                        ->where("user_aditional_data.reference_data_option_id",$option->id)  
                        ->where("user_cases.type_user_id",7)
                        ->where("cases.type_status_id","<>",15)
                        ->where(function($query) use ($request){
                            if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                                return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                                ->whereDate('cases.created_at','<=',$request->fecha_fin);
                            }
                        })   
                       // ->groupBy('cases.id')               
                        ->count();
                        $chart[]=[
                            "category"=>$option->value,
                            "value"=>$cases
                        ];
                }
            }

         
        }else{
            
           
            if($request->select_filter_graphic){
                $options = ReferenceTable::where([
                    'categories'=>$request->select_filter_graphic,
                    'table'=>'cases'
                ])->get();
                $oselected = $request->select_filter_graphic."_id";
                
                


                if($request->select_filter_cruce){
                    $data=[];
                    $graph=[];

                    if(!is_numeric($request->select_filter_cruce)){
                        $options_cruce = ReferenceTable::where([
                            'categories'=>$request->select_filter_cruce,
                            'table'=>'cases'
                        ])->get();
                        $ocselected = $request->select_filter_cruce."_id";
                        foreach ($options as $key => $option) {
                            $values=[];
                            foreach ($options_cruce as $key_2 => $option2) {
                                $counter = CaseM::where($ocselected,$option2->id)
                                ->where($oselected,$option->id)
                                ->where(function($query) use ($request){
                                    if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                                        return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                                        ->whereDate('cases.created_at','<=',$request->fecha_fin);
                                    }
                                })  
                                ->where("cases.type_status_id","<>",15)->count();
                                $values[$option2->name] =  $counter ;
                                if($key==0)$graph[] = ['value_graph'=>$option2->name];
                            }
                            $values['encabezado'] = $option->name ;
                            $data[]= $values;
                        }
                    }else{
                        $ref = ReferenceData::find($request->select_filter_cruce);            
                        $options_cruce = $ref->options;
                        foreach ($options as $key => $option) {
                            $values=[];
                            foreach ($options_cruce as $key_2 => $option2) {
                                $counter = CaseM::join('user_cases','user_cases.case_id','=','cases.id')
                                ->join('users','users.id','=','user_cases.user_id')  
                                ->join('user_aditional_data','user_aditional_data.user_id','=','users.id')  
                                ->join('references_table as tb1','tb1.id','=','cases.type_status_id')
                                ->join('references_table as tb2','tb2.id','=','cases.type_case_id')
                                ->join('references_table as tb3','tb3.id','=','cases.type_branch_law_id')  
                                ->where("user_aditional_data.reference_data_option_id",$option2->id)  
                                ->where("cases.".$oselected,$option->id)
                                ->where("user_cases.type_user_id",7)
                                ->where("cases.type_status_id","<>",15)
                                ->where(function($query) use ($request){
                                    if($request->has('fecha_ini') and $request->has('fecha_fin') ){
                                        return $query->whereDate('cases.created_at','>=',$request->fecha_ini)
                                        ->whereDate('cases.created_at','<=',$request->fecha_fin);
                                    }
                                })                                            
                                ->count();
                                $values[$option2->value] =  $counter ;
                                if($key==0)$graph[] = ['value_graph'=>$option2->value];
                            }
                            $values['encabezado'] = $option->name ;
                            $data[]= $values;
                        }
                    }
                    
                  
                   
                    
                    $chart['data'] = $data;
                    $chart['graph'] = $graph;
                  
                
                    
                    //dd($req
                }else{
                    $oselected = $request->select_filter_graphic."_id";
                    foreach ($options as $key => $option) {
                        $counter = CaseM::where($oselected,$option->id)->count();
                        $chart[]=[
                            "category"=>$option->name,
                            "value"=>$counter
                        ];
                    }
                }


            
               
               

            }


        }
        //dd($oselected,$options,$chart);
       
        return response()->json($chart);
     
        return response()->json($request->all());
    }


}
