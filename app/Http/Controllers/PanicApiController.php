<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PanicAlert;
use App\Models\CaseM;
use App\Models\Directory;

class PanicApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $panic_alerts = PanicAlert::join('users','users.id','=','panic_alerts.user_id')
        ->join('references_table as rf','rf.id','=','panic_alerts.type_status_id')
        ->leftjoin('panic_alerts_has_case','panic_alerts_has_case.panic_alert_id','=','panic_alerts.id')
        ->search($request)->orderBy('panic_alerts.created_at','desc')
        ->select('case_id','rf.name as type_status','panic_alerts.created_at','users.type_status_id',
        'panic_alerts.id as id','users.name','panic_alerts.user_id','users.identification_number','panic_alerts.city',
        'panic_alerts.address','panic_alerts.location')            
        ->orderBy('panic_alerts.user_id','asc')->paginate(10);
        //dd($panic_alerts);
        if($request->ajax()){ 
            $response = [
                'view'=>view('content.panic_api.partials.ajax.index',compact('panic_alerts'))->render(),
            ];
            return response()->json($response);      
        }

        return view("content.panic_api.index",compact('panic_alerts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $panic_alert = PanicAlert::find($id);

        return response()->json($panic_alert);
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
        $panic_alert = PanicAlert::find($id);
        $panic_alert->fill($request->all());
        $panic_alert->save();
       
        if($request->ajax()){ 
            $panic_alert = PanicAlert::join('users','users.id','=','panic_alerts.user_id')
            ->join('references_table as rf','rf.id','=','panic_alerts.type_status_id')        
            ->select('rf.name as type_status','panic_alerts.created_at','users.type_status_id',
            'panic_alerts.id as id','users.name','users.identification_number','panic_alerts.city',
            'panic_alerts.address','panic_alerts.location')          
            ->where('panic_alerts.id',$id)          
           ->first();
            $response = [
                'view'=>view('content.panic_api.partials.ajax.panic_alert',compact('panic_alert'))->render(),
            ];
            return response()->json($response);      
        }
       // return response()->json($panic_alert);
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

    public function directories(Request $request)
    {
        $directories = Directory::join('users','users.id','=','directory.user_id')
        ->select('directory.user_id','users.name as user_name','directory.name as dir_name','directory.email','directory.address',
        'number_phone','directory.id as id','directory.is_trusted')
        ->where('directory.type_status_id','<>',15)
        ->where(function($query) use ($request) {
           if($request->user_id) $query->where('user_id',$request->user_id);
           if($request->data){
                $query->where('users.name','like','%'.$request->data.'%')
                ->orWhere('directory.name','like','%'.$request->data.'%');
           } 
        })
        ->where('origin','movil')->get();
        if($request->ajax()){ 
            $response = [
                'view'=>view('content.panic_api.partials.ajax.directories',compact('directories'))->render(),
            ];
            return response()->json($response);      
        }
        return view('content.panic_api.directories',compact('directories'));
    }

    public function view_directory(Request $request, $id)
    {
        
        $directories = Directory::where('type_status_id','<>',15)
        ->where('origin','movil')
        ->where('user_id',$id)->get();
        //dd($directories );
        return response()->json($directories);      
        return view('content.panic_api.directories',compact('directories'));
    }
}
