<?php

namespace App\Http\Controllers;

use App\Facades\AuditLog;
use Illuminate\Http\Request;
use App\Models\Diary;
use App\Models\User;
use DB;
use Carbon\Carbon;
use App\Notifications\DiaryNotification;
use App\Jobs\SendEventDiaryEmail;
use Illuminate\Support\Facades\Notification;
use Redis;


class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware('permission:access_dashboard_cases',   ['only' => ['index']]);
    }


    public function index(Request $request)
    {
        
        $id_user = \Auth::user()->id;
        $selecteduser=0;
        if (\Auth::user()->can('ver_agendas')) {
            if ($request->has('search')) {
                if ($request->filled('search')) {
                    $id_user =$request->search;
                    $selecteduser=$request->search;
                }
            }
        }

        $diarys= DB::table('diary')
        ->join('diary_user', 'diary.id', '=', 'diary_user.diary_id')
        ->where ('user_id', $id_user )
        ->where ('type_status_id','<>',15)
        ->select('diary.id as id','title','inicio','fin','color','owner')->get();
   


       // $diarys = response()->json($diary);
  
        return view('content.diary.index', compact('diarys','selecteduser')); 
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       // return response()->json($request->all());
        
        $diary = Diary::create([
            'title'=>$request['title'],
            'description'=>$request['description'],
            'url'=>$request['url'],
            'color'=>$request['color'],
            'inicio'=>$request['start'],
            'fin'=>$request['end'],
            'type_status_id'=>16
            ]);
        $diary->id;

        $data = [
            'diary_id'=>$diary->id,
            'user_id'=>\Auth::user()->id,
            'owner'=>'1',
            'inspected'=>'1'
          ];
          
          $asistencia = $diary->users()
          ->attach(\Auth::user()->id,$data);

       //   return response()->json($asistencia);
         /* AuditLog::setEvent('create')
          ->setModelDescription(json_encode($asistencia))
          ->setTable('diary_user')
          ->store();*/
          $usersA = [];
          $usersA[0] = \Auth::user()->id;
        
          if(isset($request['invitados'])) {            
            foreach ($request['invitados'] as $key => $value) {
                $usersA[$key+1] = $value;
                $data = [
                    'diary_id'=>$diary->id,
                    'user_id'=>$value,
                    'owner'=>'0',
                    'inspected'=>'0'
                ];
                $asistencia = DB::table('diary_user')
                ->insert($data);
            }
        }  

        $users = User::whereIn('id',$usersA)->get();
        Notification::send($users, new DiaryNotification($diary)); 
        //SendEventDiaryEmail::dispatch($users,$diary)->onQueue('diarys'); 
        return response()->json($diary);
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
        $diary = Diary::find($id);
        $diary->users;
        $diary->userowner= false;

        $userowner = $diary->users()->where('owner',1)->first();
        if($userowner->id==\Auth::user()->id) {
            $diary->userowner= true;
        }
        

        return response()->json($diary);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
       
        $data = [
            'inicio'=>$request['inicio'],
            'fin'=>$request['fin']
            ];
        $diary = DB::table('diary')->where('id', $request['id'])
        ->update($data);
        return response()->json($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $data = [
            'title'=>$request['title'],
            'description'=>$request['description'],
            'url'=>$request['url'],
            'color'=>$request['color'],
            'inicio'=>$request['start'],
            'fin'=>$request['end']
            ];
        $diary = Diary::find($request['diary_id']);
        $diary->fill($data);
        $diary->save();

        $diary_delete = DB::table('diary_user')
        ->where('diary_id', $request['diary_id'])->where('owner', 0)->delete();

        if(isset($request['invitados'])) {
            foreach ($request['invitados'] as $key => $value) {
                $data = [
                    'diary_id'=>$request['diary_id'],
                    'user_id'=>$value,
                    'owner'=>'0',
                    'inspected'=>'0'
                ];
                $diary_insert = DB::table('diary_user')
                ->insert($data);
            }
        }
        
        return response()->json(['id'=> $request['diary_id']]);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $diary_delete = Diary::find($request['id']);
        $diary_delete->type_status_id = 15;
        $diary_delete->save();
        return response()->json($request->all());
    }

    public function prueba() {
        $redis = Redis::connection();
        $redis -> publish('', json_encode(['channel' => 'login','message' => 'Hola mundo1']));
        return "published";
    }

}
