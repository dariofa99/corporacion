<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Hash;

class AuditLogController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

  


    public function index()
    {
        $auditories = AuditLog::orderBy("id",'desc')->paginate(20);
        return view('content.audit.index',compact('auditories'));
    }
}
