<?php

namespace App\Http\Controllers;

use App\Events\LoginEvent;
use App\Events\NotifyClientStreamEvent;
use \Facades\App\Facades\NewPush;
use Illuminate\Http\Request;
use App\Models\ReferenceData;
use App\Models\ReferenceDataOptions;
use App\Models\CaseNoveltyData;
use App\Models\CaseNoveltyHasData;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redis;
use App\Models\CaseM; 

use App\Models\User;
use App\Models\Payment;
use App\Models\PanicAlert;
use App\Models\UserMailNotification;
use App\Models\Reception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Facades\Auditor;


class CasesController extends Controller
{

     
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware('permission:access_dashboard_cases',   ['only' => ['index','edit']]);
        $this->middleware('permission:crear_casos',   ['only' => ['create','store']]);
    }
 


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        /* if(NewPush::isRedisReady()){
                NewPush::channel("register")
                ->message(["response" => "Register"])
                ->publish();
        }
 */
      
        $cases= $this->allcases($request);
      
        if (\Auth::user()->can('ver_todos_casos')) {
            $cases= $this->allcases($request);
        } else {
            $cases= $this->casesAsignados($request);
        }
        if($request->ajax()){ 
            $response = [
                'view'=>view('content.cases.partials.ajax.index',compact('cases'))->render(),
            ];
            return response()->json($response);      
        }
        return view('content.cases.index',compact('cases')); 

    }

    public function allCases(Request $request)
    {

        if (\Auth::user()->can('ver_todos_casos')) {}
        $cases=CaseM::join('references_table as rt','rt.id','cases.type_status_id')
            ->join('references_table as rtc','rtc.id','cases.type_case_id')
            ->join('references_table as rtr','rtr.id','cases.type_branch_law_id')
            ->leftJoin('user_cases', 'user_cases.case_id', '=', 'cases.id')
            ->join('users','users.id','=','user_cases.user_id')
            ->getData($request)
            ->where('cases.type_status_id','<>','15')
            ->select('cases.created_at','cases.case_number','cases.id','rt.name as status','rt.options as color','rt.id as status_id','rtc.name as type_case','rtr.name as branch_law')
            ->orderBy('cases.case_number','desc')->paginate(15);
        if((!$request->data and !$request->type)){
           /*  $cases=CaseM::join('references_table as rt','rt.id','cases.type_status_id')
            ->join('references_table as rtc','rtc.id','cases.type_case_id')
            ->join('references_table as rtr','rtr.id','cases.type_branch_law_id')
            ->getData($request)
            ->where('cases.type_status_id','<>','15')
            ->select('cases.created_at','cases.case_number','cases.id','rt.name as status','rt.options as color','rt.id as status_id','rtc.name as type_case','rtr.name as branch_law')
            ->orderBy('cases.created_at','desc')->paginate(15); */
            
        }/* else{
            $cases=CaseM::join('user_cases as uc','uc.case_id','=','cases.id')
            ->join('users','users.id','=','uc.user_id')
            ->join('references_table as rt','rt.id','cases.type_status_id')
            ->join('references_table as rtc','rtc.id','cases.type_case_id')
            ->join('references_table as rtr','rtr.id','cases.type_branch_law_id')
            ->getData($request)
            ->where('cases.type_status_id','<>','15')
            ->select('cases.case_number','cases.id','rt.name as status','rt.options as color','rt.id as status_id','rtc.name as type_case','rtr.name as branch_law')
            ->orderBy('cases.created_at','desc')->paginate(15); 
            
        } */

        return $cases;
        
    }


    public function casesAsignados(Request $request)
    {
        $user=\Auth::user();
       // $proyectos = $user->proyectos()->whereIn('tipo_user_id',[99, 100])->get();
        
       // $casos = \Auth::user()->casos()->where('type_user_id','8')->get();

        if((!$request->data and !$request->type) ||
         ($request->type=='case_number' || $request->type=='type_case' || 
         $request->type=='branch_law' || $request->type=='status' || $request->type=='view_all')){
            $cases=CaseM::join('references_table as rt','rt.id','cases.type_status_id')
            ->join('references_table as rtc','rtc.id','cases.type_case_id')
            ->join('references_table as rtr','rtr.id','cases.type_branch_law_id')
            ->join('user_cases', 'user_cases.case_id','cases.id')
            ->where('user_cases.user_id', \Auth::user()->id)
            ->where('user_cases.type_user_id','8')
            ->where('cases.type_status_id','<>','15')
            ->getData($request)
            ->select('cases.case_number','cases.id','rt.name as status','rt.options as color','rt.id as status_id','rtc.name as type_case','rtr.name as branch_law')
            ->orderBy('cases.created_at','desc')->paginate(15);
            
        }else{
            $cases=CaseM::join('user_cases as uc','uc.case_id','=','cases.id')
            ->join('users','users.id','=','uc.user_id')
            ->join('references_table as rt','rt.id','cases.type_status_id')
            ->join('references_table as rtc','rtc.id','cases.type_case_id')
            ->join('references_table as rtr','rtr.id','cases.type_branch_law_id')
            ->join('user_cases', 'user_cases.case_id','cases.id')
            ->where('user_cases.user_id', \Auth::user()->id)
            ->where('user_cases.type_user_id','8')
            ->where('cases.type_status_id','<>','15')
            ->getData($request)
            ->select('cases.case_number','cases.id','rt.name as status','rt.options as color','rt.id as status_id','rtc.name as type_case','rtr.name as branch_law')
            ->orderBy('cases.created_at','desc')->paginate(15); 
        }
        return $cases;


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) 
    {
        $case_number = $this->getId();
        if($request->has('wus') and $request->has('puid') and $request->puid != '' and $request->wus != ''){
            $panic_alert = PanicAlert::find($request->puid);
            if($panic_alert){
                $user =  $panic_alert->user;
                if($user and $user->identification_number == $request->wus){
                    return view('content.cases.create',compact('case_number','user'));
                }
            }       
        }  
        if($request->has('ruser') and $request->has('ruid') and $request->ruid != '' and $request->ruser != ''){
            $reception = Reception::find($request->ruid);
            if($reception){
                $user =  $reception->user;
                if($user and $user->identification_number == $request->ruser){
                    return view('content.cases.create',compact('case_number','user'));
                }
            }       
        }
        return view('content.cases.create',compact('case_number'));
    }


    private function getId(){
        //Nuevo codigo para crear el id autoincrementable
            $year_act= Date('Y');
            $mount= Date('m');       
            $indice=0;
            $expediente =  CaseM::orderBy('id','desc')->first(); 
            $id = $year_act.''.$mount.'-'.("01");       
            if($expediente){
              $indices = explode("-",$expediente->case_number);            
              if(isset($indices[0]) and  isset($indices[1])){
                $year_last = substr($indices[0], 0, -2);
                $indice = intval($indices[1]);
                if($year_act!=$year_last){
                  $indice=0;
                }
                $id = $year_act.''.$mount.'-'.($indice+1);
              }else{
                $id = $year_act.''.$mount.'-'.($indice+1); 
              }           
            }             
           return $id;
      }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return response()->json($request->all());
        if(!$request->has('reception_id')){
            $reception = Reception::create([
                'number'=>time(),
                'token'=>bcrypt(\Str::random(5)),
                'user_id'=>$request->user_id,
                'type_status_id'=>143
            ]);
            $request['reception_id'] = $reception->id;
        }else{
            $reception = Reception::find($request->reception_id);
            $reception->type_status_id = 144;
            $reception->save();
        } 
        $request['type_status_id'] = 9;
        $case = CaseM::create($request->all());
        
        $case->users()->attach($request->user_id,[
            'type_user_id'=>7,
            'status'=>1
        ]); 
        if (auth()->user()->can('auto_asig_caso')) {
            $case->users()->attach(\Auth::user()->id,[
                'type_user_id'=>8,
                'status'=>1
            ]); 
        }
        if($request->has('panic_alert_id')){
            $case->panic_alerts()->attach($request->panic_alert_id); 
        }
      
         $response = [];
         $response['new_id'] = $this->getId();

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $case = CaseM::find($id);

       /*  if(!$case->reception) {
            $reception = Reception::create([
                'number'=>rand(1,5),
                'token'=>bcrypt(rand(1,4)),
                'user_id'=>$user->id,
                'type_status_id'=>143
            ]);
            $case->reception_id = $reception->id;
            $case->save();
        }  */



        return view('content.cases.edit',compact('case'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $case = CaseM::find($id);
        $case->fill($request->all());
        $case->save();
        return response()->json($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $case = CaseM::find($id);
        $case->type_status_id = 15;
        $case->save();
       return response()->json($case);
    }

    public function insertData(Request $request){
        $data = DB::table('case_data')
       ->where(['type_data_id'=>$request->type_data_id,
       'case_id'=>$request->case_id])->first();    
       if($data){           
           $data = DB::table('case_data')
           ->where(['type_data_id'=>$request->type_data_id,
           'case_id'=>$request->case_id])->update($request->all());   
       }else{
           $request['user_id'] = \Auth::user()->id;
           $data = DB::table('case_data')
           ->where(['type_data_id'=>$request->type_data_id,
           'case_id'=>$request->case_id])->insert($request->all());
       }

       return response()->json($request->all());
    }

    public function storeNoveltyData(Request $request){
        if ($request->has('data') and is_array($request->data)) {
            $case = CaseM::find($request['case_id']);
            $requestData = $request->data;
            foreach ($request->data as $key => $option_r) {
              $option_r['case_id'] = $request['case_id'];
              $ref_data = ReferenceData::where(function ($query) use ($option_r) {
                if (isset($option_r['short_name'])) {
                  $query->where([
                    'short_name' => $option_r['short_name']
                  ]);
                } elseif (isset($option_r['question_id'])) {
                  $query->where([
                    'id' => $option_r['question_id']
                  ]);
                }
              })->where([
                'section' => $request['component']
              ])->first();
              if ($ref_data) {
                $this->storeData($ref_data, $option_r);
              }
              //
            }
          }

          $response=[];
          $response['render_view'] = view('content.cases.partials.ajax.novelty',compact('case'))->render();
          return response()->json($response);
    }

    public function updateNoveltyData(Request $request){
        
        return response()->json($request->all());
    }

    public function editNoveltyData($id){
        $noveltyData = CaseNoveltyData::find($id);
        $types_categories_novelty = ReferenceData::where(['categories'=>'type_data_novelty','table'=>'case'])
         ->pluck('name','id');
        $options = ReferenceData::find($noveltyData->reference_data_id)->options()->pluck('value', 'id'); // Adjust 'name' and 'id' fields as needed
        $response=[];
        $response['render_view'] = view('content.cases.partials.modals.novelty_edit',compact('noveltyData','types_categories_novelty','options'))->render();
        return response()->json($response);
    }

    public function deleteNoveltyData(Request $request){
        $case = CaseM::find($request->case_id);
        $case_novelty = DB::table('case_novelty_data')->where('id',$request->id)->delete();
        $response=[];
        $response['render_view'] = view('content.cases.partials.ajax.novelty',compact('case'))->render();
        return response()->json($response);
    }
    
    private function storeData($question, $request){
        if (isset($request['options']) and count($request['options']) > 0) {

            $caseId =  $request['case_id'];

            $data = CaseNoveltyData::where([
                'reference_data_id' => $question->id,
                'case_id' => $caseId
            ])->delete();

        foreach ($request['options'] as $key => $option_r) {
            $option = ReferenceDataOptions::where(function ($query) use ($option_r) {
            if (isset($option_r['value_db'])) {
                $query->where([
                'value_db' => $option_r['value_db']
                ]);
            } elseif (isset($option_r['option_id'])) {
                $query->where([
                'id' => $option_r['option_id']
                ]);
            }
            })->first();
            $tipo_pregunta = $question->type_data_id;
            $data = CaseNoveltyData::where([
            'reference_data_id' => $question->id,
            'case_id' => $caseId,
            /* 'reference_data_option_id' => $option->id */
            ])->where(function($query) use ($option,$tipo_pregunta){
            if($tipo_pregunta==136){
                $query->where(['reference_data_option_id' => $option->id]);
            }
            })->first();


            if ($data) {
            
            Log::info($tipo_pregunta);
            if ($tipo_pregunta != 136) { ///texto
                $data->value = $option_r["value"];
                $data->reference_data_option_id = $option->id;
                $data->value_is_other = (isset($option_r["value_is_other"]) and $option_r["value_is_other"] != "") ? $option_r["value_is_other"] : "";
                $data->save();
            } else if ($tipo_pregunta == 136) {
                if ($option_r["value"] != "") {
                $data->value = $option_r["value"];
                $data->reference_data_option_id = $option->id;
                $data->value_is_other = (isset($option_r["value_is_other"]) and $option_r["value_is_other"] != "") ? $option_r["value_is_other"] : "";
                $data->save();
                }else{
                $data->delete();
                }
            }
            } else {
            if ($option_r["value"] != '') {
                $data = CaseNoveltyData::create([
                'reference_data_id' => $question->id,
                'reference_data_option_id' => $option->id,
                'case_id' => $caseId,
                'value' => $option_r["value"],
                'value_is_other' => (isset($option_r["value_is_other"]) and $option_r["value_is_other"] != "") ? $option_r["value_is_other"] : "",
                ]);
            }
            }
        }
        }
        return $data;
    }

    public function storeNoveltyHasData(Request $request){
        if ($request->has('data') and is_array($request->data)) {
            $case = CaseM::find($request['case_id']);
            $requestData = $request->data;
            foreach ($request->data as $key => $option_r) {
              $option_r['case_id'] = $request['case_id'];
              $ref_data = ReferenceData::where(function ($query) use ($option_r) {
                if (isset($option_r['short_name'])) {
                  $query->where([
                    'short_name' => $option_r['short_name']
                  ]);
                } elseif (isset($option_r['question_id'])) {
                  $query->where([
                    'id' => $option_r['question_id']
                  ]);
                }
              })->where([
                'section' => $request['component']
              ])->first();
              if ($ref_data) {
                $this->storeHasData($ref_data, $option_r);
              }
              //
            }
          }

          $response=[];
          $response['render_view'] = view('content.cases.partials.ajax.novelty_has',compact('case'))->render();
          return response()->json($response);
    }

    public function updateNoveltyHasData(Request $request){
        
        return response()->json($request->all());
    }

    public function editNoveltyHasData($id){
        $noveltyData = CaseNoveltyHasData::find($id);
        $types_categories_novelty_has = ReferenceData::where(['categories'=>'type_data_novelty_has','table'=>'case_has'])
         ->pluck('name','id');
        $options = ReferenceData::find($noveltyData->reference_data_id)->options()->pluck('value', 'id'); // Adjust 'name' and 'id' fields as needed
        $response=[];
        $response['render_view'] = view('content.cases.partials.modals.novelty_has_edit',compact('noveltyData','types_categories_novelty_has','options'))->render();
        return response()->json($response);
    }

    public function deleteNoveltyHasData(Request $request){
        $case = CaseM::find($request->case_id);
        $case_novelty = DB::table('case_novelty_has_data')->where('id',$request->id)->delete();
        $response=[];
        $response['render_view'] = view('content.cases.partials.ajax.novelty_has',compact('case'))->render();
        return response()->json($response);
    }
    
    private function storeHasData($question, $request){
        if (isset($request['options']) and count($request['options']) > 0) {

            $caseId =  $request['case_id'];

            $data = CaseNoveltyHasData::where([
                'reference_data_id' => $question->id,
                'case_id' => $caseId
            ])->delete();

        foreach ($request['options'] as $key => $option_r) {
            $option = ReferenceDataOptions::where(function ($query) use ($option_r) {
            if (isset($option_r['value_db'])) {
                $query->where([
                'value_db' => $option_r['value_db']
                ]);
            } elseif (isset($option_r['option_id'])) {
                $query->where([
                'id' => $option_r['option_id']
                ]);
            }
            })->first();
            $tipo_pregunta = $question->type_data_id;
            $data = CaseNoveltyHasData::where([
            'reference_data_id' => $question->id,
            'case_id' => $caseId,
            /* 'reference_data_option_id' => $option->id */
            ])->where(function($query) use ($option,$tipo_pregunta){
            if($tipo_pregunta==136){
                $query->where(['reference_data_option_id' => $option->id]);
            }
            })->first();


            if ($data) {
            
            Log::info($tipo_pregunta);
            if ($tipo_pregunta != 136) { ///texto
                $data->value = $option_r["value"];
                $data->reference_data_option_id = $option->id;
                $data->value_is_other = (isset($option_r["value_is_other"]) and $option_r["value_is_other"] != "") ? $option_r["value_is_other"] : "";
                $data->save();
            } else if ($tipo_pregunta == 136) {
                if ($option_r["value"] != "") {
                $data->value = $option_r["value"];
                $data->reference_data_option_id = $option->id;
                $data->value_is_other = (isset($option_r["value_is_other"]) and $option_r["value_is_other"] != "") ? $option_r["value_is_other"] : "";
                $data->save();
                }else{
                $data->delete();
                }
            }
            } else {
            if ($option_r["value"] != '') {
                $data = CaseNoveltyHasData::create([
                'reference_data_id' => $question->id,
                'reference_data_option_id' => $option->id,
                'case_id' => $caseId,
                'value' => $option_r["value"],
                'value_is_other' => (isset($option_r["value_is_other"]) and $option_r["value_is_other"] != "") ? $option_r["value_is_other"] : "",
                ]);
            }
            }
        }
        }
        return $data;
    }
 
    public function insertUser(Request $request){
       $case = CaseM::find($request->case_id);        
       $type_defendant = $request->type_defendant ? $request->type_defendant : null;
       $case->users()->attach($request->id,[
            'type_user_id'=>$request->type_user_id, 
            'status'=>1,
            'type_defendant'=>$type_defendant
        ]); 

        $response=[];
        $response['type_user_id'] = $request->type_user_id;
        if($request->type_user_id==7){            
            //$response['render_view'] = view('content.cases.partials.ajax.client_data',compact('case'))->render();
        }
        if($request->type_user_id==8){            
            $response['render_view'] = view('content.cases.partials.ajax.professional_data',compact('case'))->render();
        }
        if($request->type_user_id==21){            
            $response['render_view'] = view('content.cases.partials.ajax.defendant',compact('case'))->render();
        }
        if($request->type_user_id==25){            
            $response['render_view'] = view('content.cases.partials.ajax.interventor',compact('case'))->render();
        }
        $response['user'] = User::find($request->id);
        return response()->json($response);

   }

   public function storePayment(Request $request){
    $case = CaseM::find($request->case_id); 
    $payment = [
        'concept'=>'Nuevo cobro',
        'description'=>'.',
        'value'=>1,
        'num_payments'=>1,
        'case_id'=>$request->case_id,
        'type_status_id'=>57,
        'type_category_id'=>37,
        'type_payment_id'=>39,
        'type_periodpay_id'=>41
    ];
    $payment = new Payment($payment);   
    $payment->save();
    $payment->can_edit = auth()->user()->can('actualizar_pago');
    $response=[];
     try {
         $response['payment'] = $payment;
         $response['image_list'] = view('content.cases.partials.ajax.list_payments_files',compact('payment'))->render();
         $response['render_view'] = view("content.cases.partials.ajax.case_bill",compact('case'))->render();
     } catch (\Throwable $th) {
        $response['error'] = $th->getMessage();
     }
    
   
     return response()->json($response);

   
}

public function editPayment(Request $request){
   
    $payment =  Payment::find($request->payment_id);   
    $payment->credits;
    $payment->can_edit = auth()->user()->can('actualizar_pago');
    $response=[];
     try {
         $response['payment'] = $payment;
         $response['image_list'] = view('content.cases.partials.ajax.list_payments_files',compact('payment'))->render();
        
        } catch (\Throwable $th) {
        $response['error'] = $th->getMessage();
     }
    
   
     return response()->json($response);

}
public function deletePayment(Request $request){
   
    $payment =  Payment::find($request->payment_id);   
    $payment->type_status_id=15;
    $payment->save();    
    $response=[];
     try {
         $case = CaseM::find($payment->case_id);   
         $payment->get_total_payments = $case->getTotalPayments();
         $payment->get_balance_payments = $case->getBalancePayments();      
         $response['payment'] = $payment;
         $response['render_view'] = view("content.cases.partials.ajax.case_bill",compact('case'))->render();
 
        } catch (\Throwable $th) {
        $response['error'] = $th->getMessage();
     }
    
   
     return response()->json($response);

}

public function updatePayment(Request $request){
  //  return response()->json($request);
    $payment =  Payment::find($request->id); 
    $request['shared'] = ($request->shared and $request->shared=='on') ? true : false;      
    $payment->fill($request->all());
    $payment->save();
    $response=[];    
     try {
        $case = CaseM::find($payment->case_id); 
         $response['payment'] = $payment;
         $response['render_view'] = view("content.cases.partials.ajax.case_bill",compact('case'))->render();
    
        } catch (\Throwable $th) {
        $response['error'] = $th->getMessage();
     }
    
   
     return response()->json($response);
;
}

   public function getLogs(Request $request){
        $case = CaseM::find($request->case_id);        
        if($request->type_log_id==18){
            $case->logs_rec = $case->logs()
            ->where('case_log.type_status_id','<>',15)->where(['type_log_id'=>22])->get();
            $case->logs_rec->each(function($file){
                $file->files;
            });
            $case->logs_send = $case->logs()
            ->where('case_log.type_status_id','<>',15)->whereIn('type_log_id',[18,33])->where(
                ['shared'=>1])->get(); 
            $case->logs_send->each(function($file){
                $file->files;
            });
        }else{
            $case->logs_notif = $case->logs()
            ->where('case_log.type_status_id','<>',15)
            ->where(['type_log_id'=>$request->type_log_id])->get();
            $case->logs_notif->each(function($file){
                $file->files;
            });
        }
        return response()->json($case);
   }

   public function searchLogs(Request $request){
    $response=[];
    $case = CaseM::find($request->case_id);        
    if($request->data || $request->type ){
        $case->logs = $case->logs()->where(function($query) use ($request){
            if($request->type == 'created_at') return $query->whereDate('case_log.created_at',$request->data);
            if($request->type == 'category') return $query->where('case_log.type_category_id',$request->data);
            if($request->type == 'shared') return $query->where('case_log.shared',1);
            //if($request->type == 'clientnotif') return $query->where('case_log.type_log_id',23);
            if($request->type == 'support') return $query->where('case_log.type_log_id',33);
            if($request->type == 'event') return $query->where('case_log.share_on_diary',1);
            if($request->type == 'notification') return $query->where('case_log.notification_date','<>',null);            
        })->orderBy('case_log.created_at','desc')->get();
        $case->logs->each(function($file){
            $file->files;
        });      
    }
    $logs = $case->logs;
    $response['render_view'] = view('content.cases.partials.ajax.case_log_search',compact('logs'))->render();
    return response()->json($response);
}

   public function deleteUser(Request $request){
    //return response()->json($response);
    $case = CaseM::find($request->case_id);
    $user = DB::table('user_cases')->where('id',$request->pivot_id)->delete();
    $response=[];
    if($request->type_user_id==7){
        //$response['render_view'] = view('content.cases.partials.ajax.client_data',compact('case'))->render();
    }
    if($request->type_user_id==8 OR $request->type_user_id==36){            
        $response['render_view'] = view('content.cases.partials.ajax.professional_data',compact('case'))->render();
    }
    if($request->type_user_id==21){            
        $response['render_view'] = view('content.cases.partials.ajax.defendant',compact('case'))->render();
    }
    if($request->type_user_id==25){            
        $response['render_view'] = view('content.cases.partials.ajax.interventor',compact('case'))->render();
    }
    return response()->json($response);
   }

   public function notifyClientStream(Request $request){
    $case = CaseM::find($request->id);
    $hashid=null;

    foreach ($case->users()->where('type_user_id',7)->get() as $user ) {
Log::info("Si pasa");
        event(new NotifyClientStreamEvent($user,'https://meet.jit.si/lybra_'.sha1($request->id)));

        /* $hashid =sha1($user->id);
        $redis = Redis::connection();
        $redis -> publish('', json_encode(['channel' => 'stream'.$hashid,'message' =>  'https://meet.jit.si/lybra_'.sha1($request->id)]));
    */ }

    return response()->json(['id'=>$case->users()->where('type_user_id',7)->get()]);

   }
   
   public function findNotificationMail(Request $request){

    $notification = UserMailNotification::find($request->notification_id);
    $notification->user;
    $notification->log;
    try{
        $notification->log->files;
    }catch(\Throwable $e){

    }
   
    //$notification->access_address = null;
    if($notification->access_address!=null){
        $access_address = json_decode($notification->access_address); 
        $notification->access_address = $access_address;
    }  
    $notification->status = "Sin revisar";
    if($notification->token==null){
        $notification->status = "Revisado";
    }
    //$user->notifications_mail = $user->notifications_mail()->where()->get();

    return response()->json(['notification'=>$notification]);

   }

   public function asigReception(Request $request){
    $case = CaseM::find($request->case_id);
    $reception = Reception::create([
        'number'=>random_int(1000,99999),
        'token'=>bcrypt(str_random(5)),
        'user_id'=>$case->users()->first()->id,
        'type_status_id'=>143
    ]);
    $case->reception_id = $reception->id;
    $case->save();
    

    return response()->json($reception);

   }

   public function asigInputForUsers(Request $request){
        
    $case = CaseM::find($request->case_id);
    $case->inputsForUser()->syncWithoutDetaching([
        $request->question_id => ['user_id' => $request->user_id]
    ]);

    return response()->json($request->all());

   }

   public function getOptionsByCategory($categoryId){
    $options = TypeCategoriesNovelty::find($categoryId)->options()->pluck('name', 'id'); // Adjust 'name' and 'id' fields as needed
    return response()->json($options);
   }

}
