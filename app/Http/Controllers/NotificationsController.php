<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {

        $notifications = $this->notifications($request);
       if ($request->ajax()) {
        $view = view('content.notifications.partials.ajax.index',compact('notifications'))->render();
        return response()->json(['view'=>$view,'request'=>$request->all()]);
       }
        return view('content.notifications.index',compact('notifications'));
    }

    private function notifications(Request $request)
    {
        return  auth()->user()->notifications()
        ->limit($request->has('limit') ? $request->limit : 10)->get();
       // return view('content.notifications.index');
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
        //
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
    public function destroy(Request $request,$id)
    {
        $notification = DB::table('notifications')
        ->where('id',$id)
        ->delete();
        $notifications = $this->notifications($request);
       if ($request->ajax()) {
        $view = view('content.notifications.partials.ajax.index',compact('notifications'))->render();
        return response()->json(['view'=>$view,'request'=>$request->all()]);
       }
        return response()->json($notification);
    }

    public function unreadNotifications()
    {
        // return response()->json($request->all());
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();

        return response()->json($user);
    }

    /* public function notifications()
    {
      
        return view('content.notifications.index');
    } */

}
