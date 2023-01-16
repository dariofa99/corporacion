<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\CaseM;
use App\Models\User;
use App\Models\ReferenceTable;
use App\Models\Role;
use App\Models\PanicAlert;
use App\Models\Reception;
use App\Models\Directory;
use DB;
use Carbon\Carbon;
use App\Models\PaymentCredit;
class FrontClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('vstatus');
        $this->middleware('permission:acceso_oficina_virtual',   ['only' => ['index']]);
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        session()->forget('session_case');
        session()->forget('session_chat_token');
        session()->forget('session_reception');
    
        if($request->get('user_case_id')){
            $case = \Auth::user()->cases()
            ->where('type_status_id', '!=',15)
            ->where('case_id',$request->get('user_case_id'))->first();
            session(['session_case'=>$case]);            
            if($case->reception) {
                session(['session_chat_token'=>$case->reception->number]);
            }   
             
            return redirect()->route('office.chat');
        }elseif($request->get('user_reception_id')){           
            $reception = \Auth::user()->receptions()->where('type_status_id', '!=',15)
            ->where('receptions.id',$request->get('user_reception_id'))->first();
               if($reception){                 
                return redirect()->route('office.reception',$reception->id); 
                return view("content.front.reception.index",compact('reception'));
            }
            return abort(404);
        
        }else{
            $cases = \Auth::user()->cases()->where('type_status_id', '!=',15)
            ->where('type_user_id',7)->get();
            $receptions = \Auth::user()->receptions()
            ->where('receptions.type_status_id', '=',142)
            ->get();
            $process = (count($cases)+count($receptions));
            if($process > 1){             
                return view("content.front.index",compact('cases','receptions'));
            }elseif(count($cases)==1){
                session(['session_case'=>$cases[0]]);  
                session(['session_chat_token'=>$cases[0]->reception->number]);             
                return redirect()->route('office.chat');                              
                return view("content.chat.index");
            }elseif(count($receptions)==1){                
                return redirect()->route('office.reception',$receptions[0]->id);                 
            }
        }      
       // return view("content.front.reception.index",compact('data_chat'));
        echo("Ups! Al parecer NO tienes casos asignados, refresca para salir de esta página...");
        \Auth::logout();
       // abort(404);

    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function panic_alerts(Request $request)
    {
        $panic_alerts = PanicAlert::where('user_id',\Auth::user()->id)
        ->orderBy('created_at','desc')
        ->orderBy('user_id','asc')->paginate(10);
        //($panic_alerts);
        if($request->ajax()){ 
            $response = [
                'view'=>view('content.front.panic_api.partials.ajax.index',compact('panic_alerts'))->render(),
            ];
            return response()->json($response);      
        }

        return view("content.front.panic_api.index",compact('panic_alerts'));
    }

    public function panic_directories()
    {
        $directories = Directory::where('type_status_id','<>',15)
        ->where('user_id',\Auth::user()->id)
        ->where('origin','movil')->get();
        return view('content.front.panic_api.directories',compact('directories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function editProfile($id)
    {

        $user = User::find($id);
         $roles = Role::pluck('name','id');
//dd($user->roles);
        if($id != auth()->user()->id and !auth()->user()->can('edit_usuarios') and
         !auth()->user()->can('ver_perfil_usuario') and !auth()->user()->can('editar_perfil_cliente')){
            abort(403);
        }  
        $canedit = true;        
        if ($id != auth()->user()->id) {
        $canedit = false;
            if(auth()->user()->can('edit_usuarios')){
                $canedit = true;
            }elseif(auth()->user()->can('editar_perfil_cliente')){
                if(count($user->roles)<=0 || (count($user->roles)>0 and $user->roles[0]->name =='cliente')){
                    $canedit = true;
                }else{
                    if(!auth()->user()->can('edit_usuarios') and !auth()->user()->can('ver_perfil_usuario')) abort(403);
                }
            }elseif(auth()->user()->can('ver_perfil_usuario')){
                $canedit = false;
            }          
        }
       // $canedit = false;
        return view('content.front.user.user_edit',compact('user','canedit'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function notifications()
    {
        if(!session()->has('session_case')) return redirect()->route('office.chat');
   
     /*    $fechas = session('session_case')->logs()->where('type_log_id',23)
        ->groupBy('case_log.created_at')->get(); */
        $fechas = \DB::table('case_log')     
        ->join('users','users.id','=','case_log.user_id')  
        ->where(['case_id'=>session('session_case')->id,
        'type_log_id'=>23])
        ->select('users.name','case_log.description','case_log.created_at')
        ->orderBy('created_at','desc')
        ->get();

        //
       // dd(($fechas));
        $data = [];
        $anterior = '';
        $day = [];
        foreach ($fechas as $key => $noti) {
            $created_at = Carbon::parse($noti->created_at)->format('Y-m-d');    
            $hour_at = Carbon::parse($noti->created_at)->diffForHumans();    
            $noti->difforHumans = $hour_at     ;
            $day[] = $noti;
            if($anterior!=$created_at){ 
                $day = [];
                $noti->difforHumans = $hour_at ;
                $day[] = $noti;               
                $data[$created_at] = $day;
                $anterior = $created_at;                
            }else{
                $data[$created_at] = $day;

            }
           
        }
   
       // dd(($data));
        return view("content.front.notifications.index",compact('data'));

    }

    public function documents()
    {
        if(!session()->has('session_case')) return redirect()->route('office.chat');
   
        return view("content.front.documents.index");

    }

    public function chat()
    {
        if(!session()->has('session_case') and !session()->has('session_reception') ) return redirect('/oficina');
        return view("content.front.chat.index");
    }

    public function reception(Request $request,$id)
    {
        $reception = Reception::find($id);        
        if($reception->case){
            return redirect()->route('oficina.index'); 
        }
        session(['session_reception'=>$reception]); 
        session(['session_chat_token'=>$reception->number]);
        return view("content.front.reception.index",compact("reception"));
    }

    public function payments()
    {
        
        if(!session()->has('session_case')) return redirect()->route('office.chat');
       

        return view("content.front.payments.index");
        

    }

    public function diary()
    {
        
        $diarys= DB::table('diary')
        ->join('diary_user', 'diary.id', '=', 'diary_user.diary_id')
        ->where ('user_id', \Auth::user()->id )
        ->select('diary.id as id','title','inicio','fin','color','owner')->get();
        return view("content.front.diary.index", compact('diarys'));
        

    }

    public function uploadSupport(Request $request)
    {
       // $payment = Payment::find($request->payment_id);
        if($request->file('file')!=''){
            $paymenCredit = PaymentCredit::find($request->payment_credit_id);      
            $paymenCredit->type_status_id = 116;
            $paymenCredit->save();
            $payment = $paymenCredit->payment;
            //uploadFile(file,disk,ruta)
            $file = $payment->uploadFile($request->file('file'),'payment_files','/case_'.$payment->case_id);
            
            $payment->files()->attach($file,[
                'type_category_id'=>$request->type_category_id
            ]);                 
        }
        

        try {
            $response=[];
            $case = session('session_case');
             $response['render_view'] = view("content.front.payments.ajax.index",compact('case'))->render();
      
            } catch (\Throwable $th) {
            $response['error'] = $th->getMessage();
         }
        return response()->json($response); 
                    
        return response()->json($paymenCredit);
        

    }
}
