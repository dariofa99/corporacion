<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all();
        return view('content.chat.index',compact('users'));
    }


    public function show($id)
    {
        $users = User::all();
        return view('content.chat.index','users');
    }
    public function chat()
    {
        return view('content.chat.index');
    }
}
