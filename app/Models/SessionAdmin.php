<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\Traits\SessionAdmin as NewSession;

class SessionAdmin extends Model
{
   
use NewSession;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="user_access";
    protected $fillable = [
        'access_address', 'token_pc', 'entry_date', 'out_date','user_id', 'confirm','token_confirm','logout'
    ];

    //public $user_agent;
    public $tokenpc = null;

    public function __construct()
    {
       
    }

   


     


}
