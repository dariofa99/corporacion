<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Directory;
use App\Models\AditionalData;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directories = $this->getDirectories();
        return view('content.directory.index', compact('directories')); 
    }

    public function getDirectories()
    {
       // $directory = Directory::all();
        return Directory::where('type_status_id','<>',15)
        ->where('origin','web')->get();
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
        //return response()->json($request->all());

        $request['type_status_id'] = 16;
        $request['user_id'] = auth()->user()->id;
        $request['origin'] = 'web';
        $directory = new Directory($request->all());
        $directory->save();
        if($request->aditional_field and $request->type_field_directory){
            foreach ($request->aditional_field as $key => $aditional_field) {
                if($aditional_field!=''){
                    $addata = AditionalData::create([
                        'value'=>$aditional_field,                        
                    ]);
                    $directory->aditional_data()->attach($addata,[
                        'type_data_id'=>$request->type_field_directory[$key],
                        'user_id'=>auth()->user()->id
                    ]);
                }
            }
        }
        $response=[];
        $directories = $this->getDirectories();
        $response['view'] = view('content.directory.partials.ajax.index',compact('directories'))->render();
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
        $directory = Directory::find($id);
        $directory->aditional_data->each(function($aditional_data){
            $aditional_data->type_aditional_data;
        });
        
        
        return response()->json($directory);
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
        //return response()->json($request->all());
        $directory = Directory::find($id);
        $directory->fill($request->all());
        $directory->save();
        if(count($directory->aditional_data)>0){
            if($request->aditional_old_field and count($request->aditional_old_field)>0){
                foreach ($directory->aditional_data as $key => $aditional_data) {
                    if(isset($request->aditional_old_field[$aditional_data->id])){
                        $aditional_data->value = $request->aditional_old_field[$aditional_data->id];
                        $aditional_data->save();
                    }else{
                        $aditional_data->delete();
                    }
                }              
                $aditional_data->value = 1;
            }else{
                foreach ($directory->aditional_data as $key => $aditional_data) {               
                    $aditional_data->delete();                
                }
            }
        }
        if($request->aditional_field and $request->type_field_directory){
            foreach ($request->aditional_field as $key => $aditional_field) {
                if($aditional_field!=''){
                    $addata = AditionalData::create([
                        'value'=>$aditional_field,                       
                    ]);
                    $directory->aditional_data()->attach($addata,[
                        'type_data_id'=>$request->type_field_directory[$key],
                        'user_id'=>auth()->user()->id
                    ]);
                }
               
            }
        }
        $directories = $this->getDirectories();
        $response['view'] = view('content.directory.partials.ajax.index',compact('directories'))->render();
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $directory = Directory::find($id);
        $directory->type_status_id = 15;
        $directory->save();
        $directories = $this->getDirectories();
        $response['view'] = view('content.directory.partials.ajax.index',compact('directories'))->render();
        return response()->json($response);
    }
}
