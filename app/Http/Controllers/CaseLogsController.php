<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\CaseM;

use App\Models\CaseLog;
use App\Models\LogFile;
use App\Models\Diary;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Notifications\LogDefendantNotification;
use App\Mail\LogMail;
use App\Jobs\SendEventDiaryEmail;
use App\Jobs\SendLogNotificationEmail;
use App\Jobs\SendDefendantNotificationEmail;
use App\Jobs\SendLogNotificationDatabase;
use App\Models\UserMailNotification;
use App\Notifications\LogDatabaseNotification;
use App\Notifications\LogNotification;
use App\Notifications\DiaryNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CaseLogsController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cases = CaseM::all();  
        return view('content.cases.index',compact('cases')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.cases.create');
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //return response()->json($request->all());
       $response=[];
       $type_category_id = ($request->type_category_id) ? $request->type_category_id : 8; 
       if($request->has('category_name')){
        $type_category_id = $this->insertReferencesData($request);

       }
          $shared = ($request->shared && $request->shared == 'on' ) ? true : false;
          $share_on_diary = ($request->share_on_diary && $request->share_on_diary == 'on' ) ? true : false;
          $caseL = new CaseLog($request->except(['category_name']));
          $caseL->user_id = Auth::user()->id;
          $caseL->type_category_id = $type_category_id;
          $caseL->shared = $shared;
          $caseL->share_on_diary = $share_on_diary;
          if(!$request->has('concept'))  $caseL->concept = 'Notificación';
          if(!$request->has('type_status_id'))  $caseL->type_status_id = 11;         
          $caseL->save();
          $notification_message = 'documento';
          $case = $caseL->case;
        if($request->file('log_file')!=''){
            $notification_message = 'documento';
            $file = $caseL->uploadFile($request->file('log_file'),'log_files','/case_'.$caseL->case_id);
            $caseL->files()->attach($file,['type_status_id'=>1]);                   
        }elseif ($request->has('files')) {
            $notification_message = 'documento';
        } else{           
            if($shared){
                $caseL->type_log_id = 23;
                $caseL->save();  
                $notification_message = 'notificacion';
                $users = $case->users()->where('type_user_id',7)->get();
                
                if(count($users)>0){ 
                     try {     
                        SendLogNotificationDatabase::dispatch($caseL,$users)->onQueue('diarys');                   
                      // Notification::send($users, new LogDatabaseNotification($caseL,date("Y-m-d H:i:s")));
                     } catch (\Throwable $th) {
                         request()
                         ->session()
                         ->flash('mail_error',"A ocurrido un error al enviar el email. Consulte con el administrador.");
             
                         $response['mail_error']='A ocurrido un error al enviar el email. Consulte con el administrador.';
                     }
                   } 
            }           
        }


        if($request->type_log_id == 22) $notification_message = 'cliente';        
        $caseL->files;
        if($request->has('share_on_diary')){
            $diary = Diary::create([
                'title'=>$request['concept'],
                'description'=>$request['description'],
                'color'=>"#FF5733",
                'inicio'=>$request['notification_date'],
                'fin'=>$request['notification_date'],
                'type_status_id'=>16
            ]);
            $data = [
                'diary_id'=>$diary->id,
                'user_id'=>Auth::user()->id,
                'owner'=>'1',
                'inspected'=>'0'
              ];
            $asistencia = DB::table('diary_user')
              ->insert($data);
            $caseL->diarys()->attach($diary->id);
            if($shared){
                $case = CaseM::find($caseL->case_id);  
                $users =  $case->users()->where('type_user_id',7)->get();             
                if(count($users)>0){
                    foreach ($users as $key => $user) {
                        $asistencia = DB::table('diary_user')
                        ->insert([
                          'diary_id'=>$diary->id,
                          'user_id'=>$user->id,
                          'owner'=>'0',
                          'inspected'=>'0'
                        ]); 
                    }  
                   // Notification::send($users, new DiaryNotification($diary)); 
                    SendEventDiaryEmail::dispatch($case->users()->where('type_user_id',7)->get(),$diary)->onQueue('diarys');                   
                } 
            }             
        }
      
        if($shared || $caseL->type_log_id == 22){
            if($caseL->type_log_id == 22){
                $users = $case->users()->where('type_user_id',8)->get();
            }else{
                $users = $case->users()->where('type_user_id',7)->get();
            }
            if(count($users)>0){
               
             
               try {
                //Notification::send($users, new LogNotification($caseL,$notification_message));
               // return $response['mail_error']=($users);
             //  Notification::send($users, new LogNotification($caseL,$notification_message));
            SendLogNotificationEmail::dispatch($caseL,$notification_message,$users)->onQueue('diarys'); 
                } catch (\Throwable $th) {
                    request()
                    ->session()
                    ->flash('mail_error',"A ocurrido un error al enviar el email. Consulte con el administrador.");
        
                    $response['mail_error']='A ocurrido un error al enviar el email. Consulte con el administrador.';
                }
              }
            
        }

        if($caseL->type_log_id == 105){
            if($request->users_all_send){
                $users = $case->users()->where('type_user_id',21)->get();
            }elseif($request->destinatarios){
                $users = User::whereIn('users.id',$request->destinatarios)->get();
            }            
            if(count($users)>0){
                $response['users']= $users ;           
                try {
                    foreach ($users as $key => $user) {
                        $token = str_replace ('/', '', bcrypt(time()));     
                        UserMailNotification::create([
                            'token'=>$token,
                            'user_id'=>$user->id,
                            'caselog_id'=>$caseL->id
                        ]); 
                        //Mail::to($user->email)->send(new LogMail($caseL,$token)); 
                        SendDefendantNotificationEmail::dispatch($users,$caseL,$user,$token)->onQueue('diarys');              
                    }
                       } catch (\Throwable $th) {
                    request()
                    ->session()
                    ->flash('mail_error',"A ocurrido un error al enviar el email. Consulte con el administrador.");
        
                    $response['mail_error']='A ocurrido un error al enviar el email. Consulte con el administrador.';
                }
              }
              $response ['type_log_id'] = $caseL->type_log_id;
              $response['render_view'] = view('content.cases.partials.ajax.defendant',compact('case'))->render();
     
        }

        if($caseL->type_log_id==18 || $caseL->type_log_id==33 || $caseL->type_log_id==23){
            
            $new_category = false;
            if($request->has('category_name')){
                $new_category = $request->category_name;
            }
       
            $response ['view'] = view('content.cases.partials.ajax.case_log',compact('case'))->render();
            $response ['type_log_id'] = $caseL->type_log_id;
            $response ['caseL'] = $caseL;
            $response ['new_category'] = $new_category;
            $response ['type_category_id'] = $type_category_id;

            if($caseL->type_log_id==33){
                $response['render_suport_logs'] = view('content.cases.partials.ajax.support_logs',compact('case'))->render();
            }
            return response()->json($response);
        }

        if($caseL->type_log_id==22){
            $response ['view'] = view('content.front.documents.ajax.index')->render();
            $response ['type_log_id'] = $caseL->type_log_id;
            
            return response()->json($response);
        }

        return response()->json($response);

        //return response()->json($caseL);
    }

  private function insertReferencesData($request){
        if($request->has('category_name')){
        // return response()->json($request->all());
         $reference = [
             'name'=>$request->category_name,
             'categories'=>'type_category_log',
             'table'=>'case_log',
             'section'=>'case_log',
             'created_at'=>date('Y-m-d H:i:s'),
             'updated_at'=>date('Y-m-d H:i:s')
         ];
         $insert = DB::table('references_data')
         ->insertGetId($reference);
         $type_category_id = $insert;
         return $type_category_id;
        }
  }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $caseL = CaseLog::find($id);
        $caseL->files;
        $caseL->user;
        $caseL->type_category;
        
        if($request->ajax())return response()->json($caseL);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $response=[];
        $caseL = CaseLog::find($id);
        $caseL->files;  
        $response['image_list'] = view('content.cases.partials.ajax.list_case_log_files',compact('caseL'))->render();
        $response['caseL'] = $caseL;             
        if($request->ajax())return response()->json($response);       

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
     
        //return $request->all();
        $response=[];
       if($request->has('category_name')){
        $type_category_id = $this->insertReferencesData($request);
        $request['type_category_id'] = $type_category_id;
        $response ['type_category_id'] = $type_category_id;
       }
            $shared = ($request->shared == 'on' || $request->shared == '1' ) ? true : false;
            
            $share_on_diary = ($request->share_on_diary && $request->share_on_diary == 'on' ) ? true : false;
            $caseL =  CaseLog::find($id);   
            $old_shared =  $caseL->shared ;
            $old_share_on_diary =  $caseL->share_on_diary;
            $caseL->fill($request->all());  
            $caseL->shared = $shared;    
            $caseL->share_on_diary = $share_on_diary; 
            if(!$request->has('notification_date'))  $caseL->notification_date = null;
            $caseL->save();
            $notification_message = 'una nueva notificación';    
            if($request->file('log_file')!=''){
                if ($caseL->files()->first() and $caseL->files()->first()->path!='') {
                    Storage::delete($caseL->files()->first()->path);     
                    $file = $caseL->files()->first()->delete();       
                }
                $notification_message = 'un nuevo documento';    
                $file = $caseL->uploadFile($request->file('log_file'),'log_files','/case_'.$caseL->case_id);
                $caseL->files()->attach($file,['type_status_id'=>1]);                  
            }elseif($request->has('files') || count($caseL->files)>0) {
                $notification_message = 'documento';
            }else{
                if($caseL->files()->first() and $caseL->files()->first()->path!='')$notification_message = 'un nuevo documento';  
                
            }
            $case = $caseL->case;
            if($shared  and !$old_shared){
                if(count($case->users()->where('type_user_id',7)->get())>0){                    
                    $users = $case->users()->where('type_user_id',7)->get();
                    try {
                        //Notification::send($users, new LogNotification($caseL,$notification_message));
                        SendLogNotificationEmail::dispatch($caseL,$notification_message,$users)->onQueue('diarys'); 
                     // Notification::send($users, new LogNotification($caseL,$notification_message));
                    } catch (\Throwable $th) {
                        request()
                        ->session()
                        ->flash('mail_error',"A ocurrido un error al enviar el email. Consulte con el administrador.");
                        $response['mail_error']='A ocurrido un error al enviar el email. Consulte con el administrador.';
                    }

             }
        }

        if($request->has('share_on_diary')){
            $diary = Diary::create([
                'title'=>$request['concept'],
                'description'=>$request['description'],
                'color'=>"#FF5733",
                'inicio'=>$request['notification_date'],
                'fin'=>$request['notification_date'],
                'type_status_id'=>16
                ]);
           
            $data = [
                'diary_id'=>$diary->id,
                'user_id'=>Auth::user()->id,
                'owner'=>'1',
                'inspected'=>'1'
              ];
              
              $asistencia = DB::table('diary_user')
              ->insert($data);             
        }
        $new_category = false;
        if($request->has('category_name')){
            $new_category = $request->category_name;
        }

        if($caseL->type_log_id==18 || $caseL->type_log_id==33 || $caseL->type_log_id==23){
           
            $response  ['type_log_id']=$caseL->type_log_id;
            $response  ['view']=view('content.cases.partials.ajax.case_log',compact('case'))->render();
            $response  ['new_category']=$request->category_name;
            
            if($caseL->type_log_id==33){
                $response['render_suport_logs'] = view('content.cases.partials.ajax.support_logs',compact('case'))->render();
            }
            return response()->json($response);
        }
        if($caseL->type_log_id==22){
            $response  ['type_log_id']=$caseL->type_log_id;
            $response  ['view']=view('content.front.documents.ajax.index')->render();
           
            return response()->json($response);
        }
        
        return response()->json($caseL);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $caseL =  CaseLog::find($id);     
         $caseL->type_status_id = 15;
        /* if ($caseL->files()->first() and $caseL->files()->first()->path!='') {
            Storage::delete($caseL->files()->first()->path);     
            $logfile = $caseL->files()->first();       
        }
        
*/
        if(count($caseL->diarys)>0){
            $diary = $caseL->diarys()->first();
            $diary->type_status_id = 15;
            $diary->save();          
        }
         $caseL->save(); 

        if($caseL->type_log_id==22){
            $response = [
                'view'=>view('content.front.documents.ajax.index')->render(),
                'type_log_id'=>$caseL->type_log_id
            ];
            return response()->json($response);
        }
        if($caseL->type_log_id==18 || $caseL->type_log_id==33 || $caseL->type_log_id==23){
            $case = $caseL->case;
            $response = [
                'view'=>view('content.cases.partials.ajax.case_log',compact('case'))->render(),
                'type_log_id'=>$caseL->type_log_id
            ];
            if($caseL->type_log_id==33){
                $response['render_suport_logs'] = view('content.cases.partials.ajax.support_logs',compact('case'))->render();
            }
            return response()->json($response);
        }       
          return response()->json($caseL);
    }

   public function downloadFileLog($lgid){
    array_map('unlink', glob(public_path('temp/'.auth()->user()->id.'___*')));//elimina los archivos que el 
   
    $logfile= File::find($lgid);
    $users_case=$logfile->log[0]->case->users()->where('user_cases.user_id',auth()->user()->id)->first();

    if ($logfile AND $logfile->log[0]->type_status_id != 15) {

        if ($users_case != null || auth()->user()->can('descargar_documentos')) {
            
            $url = 'app/'.$logfile->path;
            $rutaDeArchivo = storage_path($url);
            $filename = auth()->user()->id.'___'.$logfile->original_name;
            
            copy( $rutaDeArchivo, public_path("temp/".$filename));
            return redirect("temp/".$filename); 
        } else {
            abort(401);
        }
    }
    return redirect()->back();
  
     }
 
     public function insertSupport(Request $request)
     {
         //dd($request->all());
 
         $caseL = CaseLog::find($request->caseL_id);
         if($request->file('file')!=''){
             //uploadFile(file,disk,ruta)
             $file = $caseL->uploadFile($request->file('file'),'log_files','/case_'.$caseL->case_id);
             $caseL->files()->attach($file,['type_status_id'=>1]);                 
         }        
         $response=[];
         $case = $caseL->case;
         $response ['view'] = view('content.cases.partials.ajax.case_log',compact('case'))->render();
         $response['image_list'] = view('content.cases.partials.ajax.list_case_log_files',compact('caseL'))->render();
       
        // $response['image_list'] = view('content.cases.partials.ajax.list_payments_files',compact('payment'))->render();
         return response()->json($response) ;
     }
  
     public function deleteSupport(Request $request){
        $caseL = CaseLog::find($request->caseL_id); 

        if ($request->ajax()) {
            $users_case=$caseL->case->users()->where('user_cases.user_id',auth()->user()->id)->first();

        if ($users_case != null || auth()->user()->can('eliminar_documentos')) {
            $file = $caseL->files()->where('caselog_has_files.id',$request->id)->first();
            $file->pivot->type_status_id = 15;
            $file->pivot->save();
            $response = [];
            $case = $caseL->case;
            $response ['view'] = view('content.cases.partials.ajax.case_log',compact('case'))->render();
            return response()->json($response);
        }
      }

        /* revisar eliminar despues de un tiempo de papelera
          if ($file and $file->path!='' and is_file(storage_path($file->path))) {
           unlink(storage_path($file->path));                   
          }
          $file->delete();
        */

    }
     
}