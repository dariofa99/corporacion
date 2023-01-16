<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use DB;

class StaffController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware('permission:access_dashboard_cases',   ['only' => ['index','edit']]);
    }

    public function index(Request $Request)
    {
      

        $sw=0;
        if ($Request->has('search')) {
            if ($Request->filled('search')) {
                
                $users =User::join('role_user', 'users.id','=', 'role_user.user_id')
                ->select('users.id as id','name', 'email', 'password','identification_number','phone_number','type_identification_id','address','image')
                ->where('users.id','<>',\Auth::user()->id)
                ->where('role_id','<>','5')
                ->where('role_id','<>','1')
                ->where(function ($query) use($Request) {
                    $query->orWhere('name', 'like', "%$Request->search%")
                    ->orWhere('identification_number', 'like', "%$Request->search%")
                    ->orWhere('phone_number', 'like', "%$Request->search%")
                    ->orWhere('address', 'like', "%$Request->search%")
                    ->orWhere('email', 'like', "%$Request->search%");
                })
                ->paginate(30);
              
            } else {
                $sw=1;
            }
           
        } else {
            $sw=1;
        }

        if($sw==1) {
            $users =User::join('role_user', 'users.id','=', 'role_user.user_id')
            ->select('users.id as id','name', 'email', 'password','identification_number','phone_number','type_identification_id','address','image')
            ->where('users.id','<>',\Auth::user()->id)
            ->where('role_id','<>','5')->where('role_id','<>','1')->paginate(30); 
        }
      

        return view('content.staff.index',compact('users','sw'));


      


    }
}
