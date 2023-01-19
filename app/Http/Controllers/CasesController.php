<?php

namespace App\Http\Controllers;

use App\Events\LoginEvent;
use App\Events\NotifyClientStreamEvent;
use \Facades\App\Facades\NewPush;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redis;
use App\Models\CaseM; 
use DB;
use App\Models\User;
use App\Models\Payment;
use App\Models\PanicAlert;
use App\Models\UserMailNotification;
use App\Models\Reception;
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
        if((!$request->data and !$request->type) ||
         ($request->type=='case_number' || $request->type=='type_case' || 
         $request->type=='branch_law' || $request->type=='status' || $request->type=='view_all')){
            $cases=CaseM::join('references_table as rt','rt.id','cases.type_status_id')
            ->join('references_table as rtc','rtc.id','cases.type_case_id')
            ->join('references_table as rtr','rtr.id','cases.type_branch_law_id')
            ->getData($request)
            ->where('cases.type_status_id','<>','15')
            ->select('cases.case_number','cases.id','rt.name as status','rt.options as color','rt.id as status_id','rtc.name as type_case','rtr.name as branch_law')
            ->orderBy('cases.created_at','desc')->paginate(15);
            
        }else{
            $cases=CaseM::join('user_cases as uc','uc.case_id','=','cases.id')
            ->join('users','users.id','=','uc.user_id')
            ->join('references_table as rt','rt.id','cases.type_status_id')
            ->join('references_table as rtc','rtc.id','cases.type_case_id')
            ->join('references_table as rtr','rtr.id','cases.type_branch_law_id')
            ->getData($request)
            ->where('cases.type_status_id','<>','15')
            ->select('cases.case_number','cases.id','rt.name as status','rt.options as color','rt.id as status_id','rtc.name as type_case','rtr.name as branch_law')
            ->orderBy('cases.created_at','desc')->paginate(15); 
            
        }

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
            $response['render_view'] = view('content.cases.partials.ajax.client_data',compact('case'))->render();
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
        $response['render_view'] = view('content.cases.partials.ajax.client_data',compact('case'))->render();
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

}
