<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserMailNotification;
use App\Notifications\UserRegisterNotificationMail;
use App\Models\File;
use Carbon\Carbon;
use App\Models\SessionAdmin;
use App\Models\User;

class UserMailNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pruebas(Request $request)
    {
        $user = User::find(2);
        $user->notify(new UserRegisterNotificationMail($user,'123435'));
       
        //$user = \App\User::find(2);
        dd(json_encode($user->getTable()));
       // AuditLog::create();    
    }

    public function index(Request $request)
    {
        if($request->session()->has('file')){
            return view('user_notification_mail');
        }else{
            return view('user_notification_mail');
        }
       
    }


    public function confirm_notification(Request $request,$token)
    {
        $usmailnot = UserMailNotification::where('token',$token)->first();
        if($usmailnot){
            $session_data=[];
            $session = new SessionAdmin();          
            $session_data['ip'] = $session->getUserIpAddr();
            $session_data['country'] = $session->getGeoLocalization('country');
            $session_data['city'] = $session->getGeoLocalization('city');
            $session_data['os'] = $session->getOS(request()->header('User-Agent'));
            $session_data['browser'] = $session->getBrowser(request()->header('User-Agent'));
            $session_data['time'] = date('Y-m-d H:i:s'); 
            $usmailnot->access_address = json_encode($session_data); 
            $usmailnot->show_notification_date = Carbon::now();
            $usmailnot->token = null;
            $usmailnot->save();            
            $file = $usmailnot->log->files()->first();
            session(['file' => $file]);
            return  redirect()->action('UserMailNotificationController@index');    
        }else{
            $request->session()->forget('file');
           // session(['file' => $file]);
            return  redirect()->action('UserMailNotificationController@index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pruebasMail()
    {
        $user = User::find(2);
       $user->notify(new UserRegisterNotificationMail($user,'123435'));
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
    public function edit($id)
    {
        $usmailnot = UserMailNotification::firstOrFail($id);

        return response()->json($usmailnot);
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

    public function downloadFileLog($lgid){
        array_map('unlink', glob(public_path('temp/___*')));//elimina los archivos que el 
       
        $logfile= File::find($lgid)  ;
        if ($logfile) {
            $url = 'app/'.$logfile->path;
            $rutaDeArchivo = storage_path($url);
            $filename = '___'.$logfile->original_name;
            
            copy( $rutaDeArchivo, public_path("temp/".$filename));
            return redirect("temp/".$filename); 
          }
      
         }

 
}
